<?php

Route::group(['middleware' => 'web', 'prefix' => 'brand', 'namespace' => 'Modules\Brand\Http\Controllers'], function () {
    Route::get('/', 'BrandController@index');
    Route::get('create', 'BrandController@create');

    Route::get('show/{id}', 'BrandController@show');
    Route::get('outlet/{id}', 'BrandController@show');
    Route::get('product/{id}', 'BrandController@show');
    Route::get('deals/{id}', 'BrandController@show');

    Route::post('outlet/{id}/list', 'BrandController@list');
    Route::post('product/{id}/list', 'BrandController@list');

    Route::post('outlet/store', 'BrandController@createOutlet');
    Route::post('product/store', 'BrandController@createProduct');

    Route::post('store', 'BrandController@store');
    Route::any('delete', 'BrandController@destroy');
    Route::group(['prefix' => 'delete'], function () {
        Route::post('outlet', 'BrandController@destroy');
        Route::post('product', 'BrandController@destroy');
        Route::post('deals', 'BrandController@destroy');
    });
});
