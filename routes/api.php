<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::prefix('v1')->group(function () {

    Route::get('/product/{id}/reviews', 'ProductRewiewsController@index');

    Route::group(['middleware' => 'auth:api'], function () {


        Route::group(['middleware' => 'can:customer'], function () {

            Route::apiResource('orders', 'OrdersController')->only(['store']);

            Route::post('/product/{id}/like', 'ProductLikesController@store');
            Route::delete('/product/{id}/dislike', 'ProductLikesController@destroy');
            Route::post('/product/{id}/reviews', 'ProductRewiewsController@store');
            Route::post('/wishlist/products', 'WishlistProductsController@store');

            Route::post('/order/{id}/purchase/{payment_type}', 'OrderPurchaseController@store');

        });


        Route::group(['middleware' => 'can:admin'], function () {

            Route::apiResource('products', 'ProductsController')->only(['store', 'destroy']);
            Route::put('product/{id}/cover-image', 'ProductCoverImageController@update');


        });

    });

});
