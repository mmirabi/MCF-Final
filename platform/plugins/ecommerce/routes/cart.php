<?php

use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Botble\Ecommerce\Http\Controllers\Fronts', 'middleware' => ['web', 'core']], function () {
    Route::group(apply_filters(BASE_FILTER_GROUP_PUBLIC_ROUTE, []), function () {
        Route::get('cart', [
            'as' => 'public.cart',
            'uses' => 'PublicCartController@index',
        ]);

        Route::post('cart/add-to-cart', [
            'as' => 'public.cart.add-to-cart',
            'uses' => 'PublicCartController@store',
        ]);

        Route::post('cart/update', [
            'as' => 'public.cart.update',
            'uses' => 'PublicCartController@update',
        ]);

        Route::get('cart/remove/{id}', [
            'as' => 'public.cart.remove',
            'uses' => 'PublicCartController@destroy',
        ]);

        Route::get('cart/destroy', [
            'as' => 'public.cart.destroy',
            'uses' => 'PublicCartController@empty',
        ]);
        // mehdi mirabi add 5 step order 
        Route::get('delivery', [
            'as' => 'public.delivery',
            'uses' => 'PublicStepController@delivery',
        ]);

        Route::get('additionalgifts', [
            'as' => 'public.additionalgifts',
            'uses' => 'PublicStepController@additionalgifts',
        ]);

        Route::get('messagecard', [
            'as' => 'public.messagecard',
            'uses' => 'PublicStepController@messagecard',
        ]);

        Route::get('invoice', [
            'as' => 'public.invoice',
            'uses' => 'PublicStepController@invoice',
        ]);
        
        Route::get('payment', [
            'as' => 'public.payment',
            'uses' => 'PublicStepController@payment',
        ]);

    });
});
