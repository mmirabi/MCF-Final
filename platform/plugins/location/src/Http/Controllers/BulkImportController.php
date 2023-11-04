<?php

namespace Botble\Location\Http\Controllers;

use Botble\Base\Facades\Assets;
use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Supports\Helper;
use Botble\Location\Exports\TemplateLocationExport;
use Botble\Location\Location;
use Botble\Location\Models\Country;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;

class BulkImportController extends BaseController
{
    public function index()
    {
        PageTitle::setTitle(trans('plugins/location::bulk-import.name'));

        $mimetypes = collect(config('plugins.location.general.bulk-import.mime_types', []))->implode(',');

        Assets::addScriptsDirectly([
                'vendor/core/plugins/location/js/bulk-import.js',
            ])
            ->addScripts(['dropzone', 'blockui'])
            ->addStyles(['dropzone', 'blockui']);

        return view('plugins/location::bulk-import.index', compact('mimetypes'));
    }

    public function downloadTemplate(Request $request)
    {
        $extension = $request->input('extension');
        $extension = $extension === 'csv' ? $extension : Excel::XLSX;
        $writeType = $extension === 'csv' ? Excel::CSV : Excel::XLSX;
        $contentType = $extension === 'csv' ? ['Content-Type' => 'text/csv'] : ['Content-Type' => 'text/xlsx'];
        $fileName = 'template_locations_import.' . $extension;

        return (new TemplateLocationExport($extension))->download($fileName, $writeType, $contentType);
    }

    public function ajaxGetAvailableRemoteLocations(Location $location, BaseHttpResponse $response)
    {
        $remoteLocations = $location->getRemoteAvailableLocations();

        $availableLocations = Country::query()->pluck('code')->all();

        $listCountries = Helper::countries();

        $locations = [];

        foreach ($remoteLocations as $location) {
            $location = strtoupper($location);

            if (in_array($location, $availableLocations)) {
                continue;
            }

            foreach ($listCountries as $key => $country) {
                if ($location === strtoupper($key)) {
                    $locations[$location] = $country;
                }
            }
        }

        $locations = array_unique($locations);

        return $response
            ->setData(view('plugins/location::partials.available-remote-locations', compact('locations'))->render());
    }

    public function importLocationData(string $countryCode, Location $location, BaseHttpResponse $response)
    {
        BaseHelper::maximumExecutionTimeAndMemoryLimit();

        $result = $location->downloadRemoteLocation($countryCode);

        return $response
            ->setError($result['error'])
            ->setMessage($result['message']);
    }
}
