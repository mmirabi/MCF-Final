<?php

use Botble\Base\Http\Middleware\RequiresJsonRequestMiddleware;
use Botble\Theme\Facades\Theme;
use Illuminate\Support\Facades\Route;
use Theme\Nest\Http\Controllers\CartController;
use Theme\Nest\Http\Controllers\NestController;

Route::group(['middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::group(['prefix' => 'ajax', 'as' => 'public.ajax.', 'middleware' => [RequiresJsonRequestMiddleware::class]], function () {
            Route::group(['controller' => NestController::class], function () {
                Route::get('product-reviews/{id}', 'ajaxGetProductReviews')
                    ->name('product-reviews');

                Route::get('quick-view/{id}', 'getQuickView')
                    ->name('quick-view')
                    ->wherePrimaryKey();

                Route::get('search-products', 'ajaxSearchProducts')
                    ->name('search-products');

                Route::get('ajax/products-by-collection/{id}', 'ajaxGetProductsByCollection')
                    ->name('products-by-collection')
                    ->wherePrimaryKey();

                Route::get('ajax/products-by-category/{id}', 'ajaxGetProductsByCategory')
                    ->name('products-by-category')
                    ->wherePrimaryKey();
            });

            if (is_plugin_active('ecommerce')) {
                Route::group(['controller' => CartController::class], function () {
                    Route::post('cart', 'store')->name('cart.store');

                    Route::put('cart', 'update')->name('cart.update');

                    Route::delete('cart/{id}', 'destroy')->name('cart.destroy');
                });
            }
        });
    });
});

Theme::routes();
