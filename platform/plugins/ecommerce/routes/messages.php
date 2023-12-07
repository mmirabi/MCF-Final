<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix() . '/ecommerce', 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'message_cards', 'as' => 'message_cards.'], function () {
            Route::resource('', 'MessageCardController')
                ->parameters(['' => 'message_card']);


        });
        Route::group(['prefix' => 'message_categories', 'as' => 'message-categories.'], function () {
            Route::resource('', 'MessageCategoryController')
                ->parameters(['' => 'message_category']);

            Route::get('search', [
                'as' => 'search',
                'uses' => 'MessageCategoryController@getSearch',
                'permission' => 'message-categories.index',
            ]);

            Route::get('get-list-message-categories-for-select', [
                'as' => 'get-list-message-categories-for-select',
                'uses' => 'MessageCategoryController@getListForSelect',
                'permission' => 'message-categories.index',
            ]);
        });
    });
});
