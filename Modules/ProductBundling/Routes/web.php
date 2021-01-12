<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product-bundling'], function()
{
	/**
	 * Bundling
	 */
	Route::get('/', 'ProductBundlingController@index');
	Route::get('create', 'ProductBundlingController@create');
    Route::post('store', 'ProductBundlingController@store');
    Route::get('detail/{id}', 'ProductBundlingController@detail');
    Route::post('update/{id}', 'ProductBundlingController@update');
    Route::post('product-brand', 'ProductBundlingController@productBrand');
    Route::post('outlet-available', 'ProductBundlingController@outletAvailable');
    Route::post('global-price', 'ProductBundlingController@getGlobalPrice');
});
