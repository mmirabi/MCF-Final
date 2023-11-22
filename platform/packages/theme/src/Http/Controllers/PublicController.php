<?php

namespace Botble\Theme\Http\Controllers;

use Botble\Base\Facades\BaseHelper;
use Botble\Page\Models\Page;
use Botble\Page\Services\PageService;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Events\RenderingHomePageEvent;
use Botble\Theme\Events\RenderingSingleEvent;
use Botble\Theme\Events\RenderingSiteMapEvent;
use Botble\Theme\Facades\SiteMapManager;
use Botble\Theme\Facades\Theme;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function getIndex()
    {
        if (
            defined('PAGE_MODULE_SCREEN_NAME') &&
            ($homepageId = BaseHelper::getHomepageId()) &&
            ($slug = SlugHelper::getSlug(null, null, Page::class, $homepageId))
        ) {
            $data = (new PageService())->handleFrontRoutes($slug);

            if (! $data) {
                return Theme::scope('index')->render();
            }

            event(new RenderingSingleEvent($slug));

            return Theme::scope($data['view'], $data['data'], $data['default_view'])->render();
        }

        SeoHelper::setTitle(theme_option('site_title'));

        Theme::breadcrumb()->add(__('Home'), route('public.index'));

        event(RenderingHomePageEvent::class);

        return Theme::scope('index')->render();
    }

    public function getView(string|null $key = null, string $prefix = '')
    {
        if (empty($key)) {
            return $this->getIndex();
        }

        $slug = SlugHelper::getSlug($key, $prefix);

        if (! $slug) {
            abort(404);
        }

        if (
            defined('PAGE_MODULE_SCREEN_NAME') &&
            $slug->reference_type === Page::class &&
            BaseHelper::isHomepage($slug->reference_id)
        ) {
            return redirect()->route('public.index');
        }

        $result = apply_filters(BASE_FILTER_PUBLIC_SINGLE_DATA, $slug);

        $extension = SlugHelper::getPublicSingleEndingURL();

        if ($extension) {
            $key = Str::replaceLast($extension, '', $key);
        }

        if (isset($result['slug']) && $result['slug'] !== $key) {
            $prefix = SlugHelper::getPrefix(get_class(Arr::first($result['data'])));

            return redirect()->route('public.single', empty($prefix) ? $result['slug'] : "$prefix/{$result['slug']}");
        }

        event(new RenderingSingleEvent($slug));

        if (! empty($result) && is_array($result)) {
            return Theme::scope($result['view'], $result['data'], Arr::get($result, 'default_view'))->render();
        }

        abort(404);
    }

    public function getSiteMap()
    {
        return $this->getSiteMapIndex();
    }

    public function getSiteMapIndex(string $key = null, string $extension = 'xml')
    {
        if ($key == 'sitemap') {
            $key = null;
        }

        if (! SiteMapManager::init($key, $extension)->isCached()) {
            event(new RenderingSiteMapEvent($key));
        }

        // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return SiteMapManager::render($key ? $extension : 'sitemapindex');
    }

    public function getViewWithPrefix(string $prefix, string|null $slug = null)
    {
        return $this->getView($slug, $prefix);
    }
}
