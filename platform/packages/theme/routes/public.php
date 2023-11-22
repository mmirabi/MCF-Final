<?php

use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Events\ThemeRoutingAfterEvent;
use Botble\Theme\Events\ThemeRoutingBeforeEvent;
use Botble\Theme\Facades\SiteMapManager;
use Botble\Theme\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::group(['controller' => PublicController::class, 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        event(new ThemeRoutingBeforeEvent(app()->make('router')));

        Route::get('/', 'getIndex')->name('public.index');

        Route::get('{key}.{extension}', 'getSiteMapIndex')
            ->where('key', '^' . collect(SiteMapManager::getKeys())->map(fn ($item) => '(?:' . $item . ')')->implode('|') . '$')
            ->whereIn('extension', SiteMapManager::allowedExtensions())
            ->name('public.sitemap.index');

        Route::get('{slug?}', 'getView')->name('public.single');

        Route::get('{prefix}/{slug?}', 'getViewWithPrefix')
            ->whereIn('prefix', SlugHelper::getSlugPrefixes() ?: ['1437bcd2-d94e-4a5fd-9a39-b5d60225e9af']);

        event(new ThemeRoutingAfterEvent(app()->make('router')));
    });
});
