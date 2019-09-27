<?php

Route::group(['middleware' => 'web', 'prefix' => 'brand', 'namespace' => 'Modules\Brand\Http\Controllers'], function () {
    Route::get('/', 'BrandController@index');
    Route::get('create', 'BrandController@create');
    Route::get('show/{id}', 'BrandController@show');
    Route::post('store', 'BrandController@store');
});
