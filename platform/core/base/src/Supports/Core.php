<?php

namespace Botble\Base\Supports;

use Botble\Base\Events\LicenseActivated;
use Botble\Base\Events\LicenseActivating;
use Botble\Base\Events\LicenseDeactivated;
use Botble\Base\Events\LicenseDeactivating;
use Botble\Base\Events\LicenseInvalid;
use Botble\Base\Events\LicenseRevoked;
use Botble\Base\Events\LicenseRevoking;
use Botble\Base\Events\LicenseUnverified;
use Botble\Base\Events\LicenseVerified;
use Botble\Base\Events\LicenseVerifying;
use Botble\Base\Events\SystemUpdateAvailable;
use Botble\Base\Events\SystemUpdateCachesCleared;
use Botble\Base\Events\SystemUpdateCachesClearing;
use Botble\Base\Events\SystemUpdateChecked;
use Botble\Base\Events\SystemUpdateChecking;
use Botble\Base\Events\SystemUpdateDBMigrated;
use Botble\Base\Events\SystemUpdateDBMigrating;
use Botble\Base\Events\SystemUpdateDownloaded;
use Botble\Base\Events\SystemUpdateDownloading;
use Botble\Base\Events\SystemUpdateExtractedFiles;
use Botble\Base\Events\SystemUpdatePublished;
use Botble\Base\Events\SystemUpdatePublishing;
use Botble\Base\Events\SystemUpdateUnavailable;
use Botble\Base\Exceptions\LicenseInvalidException;
use Botble\Base\Exceptions\LicenseIsAlreadyActivatedException;
use Botble\Base\Exceptions\MissingCURLExtensionException;
use Botble\Base\Exceptions\RequiresLicenseActivatedException;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Services\ClearCacheService;
use Botble\Base\Supports\ValueObjects\CoreProduct;
use Botble\Setting\Facades\Setting;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Session\Session;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;
use ZipArchive;

/**
 * DO NOT MODIFY THIS FILE.
 *
 * @readonly
 */
final class Core
{
    private string $basePath;

    private string $coreDataFilePath;

    private string $licenseFilePath;

    private string $productId;

    private string $productSource;

    private string $version = '1.0.0';

    private string $minimumPhpVersion = '8.1.0';

    private string $licenseUrl = 'https://license.botble.com';

    private string $licenseKey = 'CAF4B17F6D3F656125F9';

    private string $cacheLicenseKeyName = '45d0da541764682476f822028d945a46270ba404';

    private int $verificationPeriod = 1;

    public function __construct(
        private CacheRepository $cache,
        private Filesystem $files,
        private Session $session
    ) {
        $this->basePath = base_path();
        $this->licenseFilePath = storage_path('.license');
        $this->coreDataFilePath = core_path('core.json');

        $this->parseDataFromCoreDataFile();
    }

    public static function make(): self
    {
        return app(self::class);
    }

    public function checkConnection(): bool
    {
        $cachesKey = "license:{$this->cacheLicenseKeyName}:check_connection";

        if ($this->cache->has($cachesKey)) {
            return (bool) $this->cache->get($cachesKey);
        }

        $connected = rescue(fn () => $this->createRequest('check_connection_ext')->ok());

        if ($connected) {
            $this->cache->put($cachesKey, true, Carbon::now()->addDays($this->verificationPeriod)) ;
        }

        return $connected;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function minimumPhpVersion(): string
    {
        return $this->minimumPhpVersion;
    }

    /**
     * @throws \Botble\Base\Exceptions\LicenseInvalidException
     * @throws \Botble\Base\Exceptions\LicenseIsAlreadyActivatedException
     */
    public function activateLicense(string $license, string $client): bool
    {
        LicenseActivating::dispatch($license, $client);

        $response = $this->createRequest('activate_license', [
            'product_id' => $this->productId,
            'license_code' => $license,
            'client_name' => $client,
            'verify_type' => $this->productSource,
        ]);

        if ($response->failed()) {
            throw new LicenseInvalidException('Could not activate your license. Please try again later.');
        }

        $data = $response->json();

        if (! Arr::get($data, 'status')) {
            $message = Arr::get($data, 'message');

            if (Arr::get($data, 'status_code') === 'ACTIVATED_MAXIMUM_ALLOWED_PRODUCT_INSTANCES') {
                throw new LicenseIsAlreadyActivatedException($message);
            }

            LicenseInvalid::dispatch($license, $client);

            throw new LicenseInvalidException($message);
        }

        $this->files->put($this->licenseFilePath, Arr::get($data, 'lic_response'), true);

        $this->session->forget("license:{$this->cacheLicenseKeyName}:last_checked_date");

        LicenseActivated::dispatch($license, $client);

        return true;
    }

    public function verifyLicense(bool $timeBasedCheck = false): bool
    {
        LicenseVerifying::dispatch();

        if (! $this->isLicenseFileExists()) {
            return false;
        }

        $verified = true;

        if ($timeBasedCheck) {
            $dateFormat = 'd-m-Y';
            $cachesKey = "license:{$this->cacheLicenseKeyName}:last_checked_date";
            $lastCheckedDate = Carbon::createFromFormat(
                $dateFormat,
                $this->session->get($cachesKey, '01-01-1970')
            )->endOfDay();
            $now = Carbon::now()->addDays($this->verificationPeriod);

            if ($now->greaterThan($lastCheckedDate) && $verified = $this->verifyLicenseDirectly()) {
                $this->session->put($cachesKey, $now->format($dateFormat));
            }

            return $verified;
        }

        return $this->verifyLicenseDirectly();
    }

    public function revokeLicense(string $license, string $client): bool
    {
        $this->session->forget("license:{$this->cacheLicenseKeyName}:last_checked_date");

        LicenseRevoking::dispatch($license, $client);

        $data = [
            'product_id' => $this->productId,
            'license_code' => $license,
            'client_name' => $client,
        ];

        return tap(
            $this->createDeactivateRequest($data),
            fn () => LicenseRevoked::dispatch($license, $client)
        );
    }

    public function deactivateLicense(): bool
    {
        $this->session->forget("license:{$this->cacheLicenseKeyName}:last_checked_date");

        LicenseDeactivating::dispatch();

        if (! $this->isLicenseFileExists()) {
            return false;
        }

        $data = [
            'product_id' => $this->productId,
            'license_file' => $this->getLicenseFile(),
        ];

        return tap(
            $this->createDeactivateRequest($data),
            fn () => LicenseDeactivated::dispatch()
        );
    }

    public function checkUpdate(): CoreProduct|false
    {
        SystemUpdateChecking::dispatch();

        $response = $this->createRequest('check_update', [
            'product_id' => $this->productId,
            'current_version' => $this->version,
        ]);

        SystemUpdateChecked::dispatch();

        $product = $this->parseProductUpdateResponse($response);

        return tap($product, function (CoreProduct|false $coreProduct) {
            if (! $coreProduct || ! $coreProduct->hasUpdate()) {
                SystemUpdateUnavailable::dispatch();

                return;
            }

            SystemUpdateAvailable::dispatch($coreProduct);
        });
    }

    public function getLatestVersion(): CoreProduct|false
    {
        $response = $this->createRequest('check_update', [
            'product_id' => $this->productId,
            'current_version' => '0.0.0',
        ]);

        return $this->parseProductUpdateResponse($response);
    }

    public function getUpdateSize(string $updateId): float
    {
        $sizeUpdateResponse = $this->createRequest('get_update_size/' . $updateId, method: 'HEAD');

        return (float) $sizeUpdateResponse->header('Content-Length') ?: 1;
    }

    public function downloadUpdate(string $updateId, string $version): bool
    {
        SystemUpdateDownloading::dispatch();

        if (! $this->isLicenseFileExists()) {
            throw new RequiresLicenseActivatedException();
        }

        $data = [
            'product_id' => $this->productId,
            'license_file' => $this->getLicenseFile(),
        ];

        $filePath = $this->getUpdatedFilePath($version);

        $response = $this->createRequest('download_update/main/' . $updateId, $data);

        $this->files->put($filePath, $response->body());

        if ($this->validateUpdateFile($filePath)) {
            SystemUpdateDownloaded::dispatch($filePath);

            return true;
        }

        $this->files->delete($filePath);

        return false;
    }

    public function updateFilesAndDatabase(string $version): bool
    {
        return $this->updateFiles($version) && $this->updateDatabase();
    }

    public function updateFiles(string $version): bool
    {
        $filePath = $this->getUpdatedFilePath($version);

        if (! $this->files->exists($filePath)) {
            return false;
        }

        $this->cleanCaches();

        $coreTempPath = storage_path('app/core.json');

        try {
            $this->files->copy($this->coreDataFilePath, $coreTempPath);
            $zip = new Zipper();

            if ($zip->extract($filePath, $this->basePath)) {
                $this->files->delete($filePath);

                SystemUpdateExtractedFiles::dispatch();

                $this->files->delete($coreTempPath);

                return true;
            }

            if ($this->files->exists($coreTempPath)) {
                $this->files->move($coreTempPath, $this->coreDataFilePath);
            }

            return false;
        } catch (Throwable $exception) {
            if ($this->files->exists($coreTempPath)) {
                $this->files->move($coreTempPath, $this->coreDataFilePath);
            }

            $this->logError($exception);

            throw $exception;
        }
    }

    public function updateDatabase(): bool
    {
        try {
            $this->runMigrationFiles();

            return true;
        } catch (Throwable $exception) {
            rescue(fn () => $this->runMigrationFiles());

            $this->logError($exception);

            return false;
        }
    }

    public function publishUpdateAssets(): void
    {
        $this->publishCoreAssets();
        $this->publishPackagesAssets();
    }

    public function publishCoreAssets(): bool
    {
        SystemUpdatePublishing::dispatch();

        $this->publishAssets(core_path());

        return true;
    }

    public function publishPackagesAssets(): bool
    {
        $this->publishAssets(package_path());

        SystemUpdatePublished::dispatch();

        return true;
    }

    public function cleanCaches(): void
    {
        try {
            SystemUpdateCachesClearing::dispatch();

            ClearCacheService::make()->purgeAll();

            SystemUpdateCachesCleared::dispatch();
        } catch (Throwable $exception) {
            $this->logError($exception);
        }
    }

    public function cleanUp(): bool
    {
        $this->cleanCaches();

        return true;
    }

    public function logError(Exception|Throwable $exception): void
    {
        BaseHelper::logError($exception);
    }

    private function publishPaths(): array
    {
        return array_merge(
            IlluminateServiceProvider::pathsToPublish(null, 'cms-lang'),
            IlluminateServiceProvider::pathsToPublish(null, 'cms-public')
        );
    }

    public function publishAssets(string $path): void
    {
        foreach ($this->publishPaths() as $from => $to) {
            if (! Str::contains($from, $path)) {
                continue;
            }

            $this->files->ensureDirectoryExists(dirname($to));
            $this->files->copyDirectory($from, $to);
        }
    }

    private function runMigrationFiles(): void
    {
        SystemUpdateDBMigrating::dispatch();

        $migrator = app('migrator');

        $migrator->run(database_path('migrations'));

        $paths = [
            core_path(),
            package_path(),
        ];

        foreach ($paths as $path) {
            foreach (BaseHelper::scanFolder($path) as $module) {
                $modulePath = $path . '/' . $module;

                if (! $this->files->isDirectory($modulePath)) {
                    continue;
                }

                if ($this->files->isDirectory($moduleMigrationPath = $modulePath . '/database/migrations')) {
                    $migrator->run($moduleMigrationPath);
                }
            }
        }

        SystemUpdateDBMigrated::dispatch();
    }

    private function validateUpdateFile(string $filePath): bool
    {
        if (! class_exists('ZipArchive', false)) {
            return true;
        }

        $zip = new ZipArchive();

        if ($zip->open($filePath)) {
            if ($zip->getFromName('.env')) {
                throw ValidationException::withMessages([
                    'file' => 'The update file contains a .env file. Please remove it and try again.',
                ]);
            }

            /**
             * @var array{
             *     productId: string,
             *     source: string,
             *     apiUrl: string,
             *     apiKey: string,
             *     version: string,
             *     minimumPhpVersion?: string,
             * }|null $content
             */
            $content = json_decode($zip->getFromName('platform/core/core.json'), true);

            if (! $content) {
                throw ValidationException::withMessages([
                    'file' => 'The update file is invalid. Please contact us for support.',
                ]);
            }

            $validator = Validator::make($content, [
                'productId' => ['required', 'string'],
                'source' => ['required', 'string'],
                'apiUrl' => ['required', 'url'],
                'apiKey' => ['required', 'string'],
                'version' => ['required', 'string'],
                'marketplaceUrl' => ['required', 'url'],
                'marketplaceToken' => ['required', 'string'],
                'minimumPhpVersion' => ['nullable', 'string'],
            ])->stopOnFirstFailure();

            if ($validator->passes()) {
                if ($content['productId'] !== $this->productId) {
                    $zip->close();

                    throw ValidationException::withMessages(['productId' => 'The product ID of the update does not match the product ID of your website.']);
                }

                if (version_compare($content['version'], $this->version, '<')) {
                    $zip->close();

                    throw ValidationException::withMessages(['version' => 'The version of the update is lower than the current version.']);
                }

                if (
                    isset($content['minimumPhpVersion']) &&
                    version_compare($content['minimumPhpVersion'], phpversion(), '>')
                ) {
                    $zip->close();

                    throw ValidationException::withMessages(['minimumPhpVersion' => sprintf('The minimum PHP version required (v%s) for the update is higher than the current PHP version.', $content['minimumPhpVersion'])]);
                }
            } else {
                $zip->close();

                throw ValidationException::withMessages($validator->errors()->toArray());
            }
        }

        $zip->close();

        return true;
    }

    public function getLicenseFile(): string|null
    {
        if (! $this->isLicenseFileExists()) {
            return null;
        }

        return $this->files->get($this->licenseFilePath);
    }

    private function forgotLicensedInformation(): void
    {
        Setting::forceDelete('licensed_to');
    }

    private function parseDataFromCoreDataFile(): void
    {
        if (! $this->files->exists($this->coreDataFilePath)) {
            return;
        }

        $data = $this->getCoreFileData();

        $this->productId = Arr::get($data, 'productId', '');
        $this->productSource = Arr::get($data, 'source', 'envato');
        $this->licenseUrl = rtrim(Arr::get($data, 'apiUrl', $this->licenseUrl), '/');
        $this->licenseKey = Arr::get($data, 'apiKey', $this->licenseKey);
        $this->version = Arr::get($data, 'version', $this->version);
        $this->minimumPhpVersion = Arr::get($data, 'minimumPhpVersion', $this->minimumPhpVersion);
    }

    public function getCoreFileData(): array
    {
        try {
            return json_decode($this->files->get($this->coreDataFilePath), true) ?: [];
        } catch (FileNotFoundException) {
            return [];
        }
    }

    private function createRequest(string $path, array $data = [], string $method = 'POST'): Response
    {
        if (! extension_loaded('curl')) {
            throw new MissingCURLExtensionException();
        }

        $request = Http::baseUrl(ltrim($this->licenseUrl, '/') . '/api')
            ->withHeaders([
                'LB-API-KEY' => $this->licenseKey,
                'LB-URL' => rtrim(url(''), '/'),
                'LB-IP' => $this->getClientIpAddress(),
                'LB-LANG' => 'english',
            ])
            ->asJson()
            ->acceptJson()
            ->withoutVerifying()
            ->connectTimeout(100)
            ->timeout(300);

        return match (Str::upper($method)) {
            'GET' => $request->get($path, $data),
            'HEAD' => $request->head($path),
            default => $request->post($path, $data)
        };
    }

    private function createDeactivateRequest(array $data): bool
    {
        $response = $this->createRequest('deactivate_license', $data);

        $data = $response->json();

        if ($response->ok() && Arr::get($data, 'status')) {
            $this->files->delete($this->licenseFilePath);

            $this->forgotLicensedInformation();

            return true;
        }

        return false;
    }

    private function getClientIpAddress(): string
    {
        return Helper::getIpFromThirdParty();
    }

    private function verifyLicenseDirectly(): bool
    {
        if (! $this->isLicenseFileExists()) {
            LicenseUnverified::dispatch();

            return false;
        }

        $data = [
            'product_id' => $this->productId,
            'license_file' => $this->getLicenseFile(),
        ];

        $response = $this->createRequest('verify_license', $data);
        $data = $response->json();

        if ($verified = $response->ok() && Arr::get($data, 'status')) {
            LicenseVerified::dispatch();
        } else {
            LicenseUnverified::dispatch();
        }

        return $verified;
    }

    private function parseProductUpdateResponse(Response $response): CoreProduct|false
    {
        $data = $response->json();

        if ($response->ok() && Arr::get($data, 'status')) {
            return new CoreProduct(
                Arr::get($data, 'update_id'),
                Arr::get($data, 'version'),
                Carbon::createFromFormat('Y-m-d', Arr::get($data, 'release_date')),
                trim((string) Arr::get($data, 'summary')),
                trim((string) Arr::get($data, 'changelog')),
                (bool) Arr::get($data, 'has_sql')
            );
        }

        return false;
    }

    private function getUpdatedFilePath(string $version): string
    {
        $version = str_replace('.', '_', $version);

        return base_path('update_main_' . $version . '.zip');
    }

    protected function isLicenseFileExists(): bool
    {
        return $this->files->exists($this->licenseFilePath);
    }

    public function getLicenseFilePath(): string
    {
        return $this->licenseFilePath;
    }
}
