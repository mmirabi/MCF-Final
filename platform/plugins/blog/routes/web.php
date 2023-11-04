<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Blog\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix() . '/blog', 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
            Route::resource('', 'PostController')
                ->parameters(['' => 'post']);

            Route::get('widgets/recent-posts', [
                'as' => 'widget.recent-posts',
                'uses' => 'PostController@getWidgetRecentPosts',
                'permission' => 'posts.index',
            ]);
        });

        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::resource('', 'CategoryController')
                ->parameters(['' => 'category']);
        });

        Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
            Route::resource('', 'TagController')
                ->parameters(['' => 'tag']);

            Route::get('all', [
                'as' => 'all',
                'uses' => 'TagController@getAllTags',
                'permission' => 'tags.index',
            ]);
        });
    });

    if (defined('THEME_MODULE_SCREEN_NAME')) {
        Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
            Route::get('search', [
                'as' => 'public.search',
                'uses' => 'PublicController@getSearch',
            ]);
        });
    }
});
