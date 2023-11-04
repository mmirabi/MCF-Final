<?php

use Botble\Base\Facades\BaseHelper;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers', 'middleware' => ['web', 'core']], function () {
    Route::group(['prefix' => BaseHelper::getAdminPrefix(), 'middleware' => 'auth'], function () {
        Route::group(['prefix' => 'taxes', 'as' => 'tax.'], function () {
            Route::resource('', 'TaxController')->parameters(['' => 'tax']);

            Route::group(['prefix' => '{tax}/rules', 'as' => 'rule.'], function () {
                Route::resource('', 'TaxRuleController')
                    ->parameters(['' => 'rule'])
                    ->only(['index']);
            });

            Route::group(['prefix' => 'rules', 'as' => 'rule.'], function () {
                Route::resource('', 'TaxRuleController')
                    ->parameters(['' => 'rule'])
                    ->except(['index']);
            });
        });
    });
});
