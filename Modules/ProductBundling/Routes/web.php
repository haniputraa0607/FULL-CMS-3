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
	Route::any('/', 'ProductBundlingController@index');
	Route::get('create', 'ProductBundlingController@create');
    Route::post('store', 'ProductBundlingController@store');
    Route::get('detail/{id}', 'ProductBundlingController@detail');
    Route::post('update/{id}', 'ProductBundlingController@update');
    Route::post('product-brand', 'ProductBundlingController@productBrand');
    Route::post('outlet-available', 'ProductBundlingController@outletAvailable');
    Route::post('global-price', 'ProductBundlingController@getGlobalPrice');
    Route::post('delete', 'ProductBundlingController@destroy');
    Route::post('delete-product', 'ProductBundlingController@destroyBundlingProduct');

    //Product Bundling Category
    Route::get('category', 'ProductBundlingController@indexBundlingCategory');
    Route::get('category/create', 'ProductBundlingController@createBundlingCategory');
    Route::post('category/store', 'ProductBundlingController@storeBundlingCategory');
    Route::any('category/edit/{id}', 'ProductBundlingController@updateBundlingCategory');
    Route::any('category/delete', 'ProductBundlingController@deleteBundlingCategory');
});
