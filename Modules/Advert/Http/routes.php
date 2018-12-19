<?php

Route::group(['middleware' => 'web', 'prefix' => 'advert', 'namespace' => 'Modules\Advert\Http\Controllers'], function()
{
    Route::any('{key}', ['middleware' => 'feature_control:124', 'uses' => 'AdvertController@index']);
});
Route::group(['middleware' => 'web', 'namespace' => 'Modules\Advert\Http\Controllers'], function()
{
    Route::any('advert-delete', ['middleware' => 'feature_control:124', 'uses' => 'AdvertController@delete']);
});
