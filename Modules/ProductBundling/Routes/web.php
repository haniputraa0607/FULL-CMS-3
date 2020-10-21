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

// Route::prefix('productbundling')->group(function() {
//     Route::get('/', 'ProductBundlingController@index');
// });

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'product-bundling'], function()
{
	/**
	 * Bundling
	 */
	Route::get('/', 'ProductBundlingController@index');
	Route::get('create', 'ProductBundlingController@create');

	/**
	 * Get Brand Product
	 */
	Route::get('get_product', 'ProductBundlingController@get_product')->name('brand.product');
	Route::post('getAjax', 'ProductBundlingController@getAjax');
});
