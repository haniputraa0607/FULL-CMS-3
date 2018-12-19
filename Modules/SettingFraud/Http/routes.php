<?php

Route::group(['middleware' => 'web', 'prefix' => 'setting-fraud-detection', 'namespace' => 'Modules\SettingFraud\Http\Controllers'], function()
{
    Route::get('/', 'SettingFraudController@list');
    Route::any('detail/{id}', 'SettingFraudController@detail');
});
