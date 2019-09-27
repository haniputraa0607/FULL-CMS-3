<?php

Route::group(['middleware' => 'web', 'prefix' => 'brand', 'namespace' => 'Modules\Brand\Http\Controllers'], function()
{
    Route::get('/', 'BrandController@index');
});
