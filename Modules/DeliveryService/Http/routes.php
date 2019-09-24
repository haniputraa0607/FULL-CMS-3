<?php

Route::group(['middleware' => 'web', 'prefix' => 'delivery-service', 'namespace' => 'Modules\DeliveryService\Http\Controllers'], function () {
    Route::get('/', 'DeliveryServiceController@index');
});

Route::group(['prefix' => 'delivery-service', 'namespace' => 'Modules\DeliveryService\Http\Controllers'], function () {
    Route::get('webview', 'DeliveryServiceController@detailWebview');
});
