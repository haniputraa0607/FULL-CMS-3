<?php

Route::group(['middleware' => 'web', 'prefix' => 'shipment', 'namespace' => 'Modules\Shipment\Http\Controllers'], function()
{
    Route::get('/', 'ShipmentController@index');
});
