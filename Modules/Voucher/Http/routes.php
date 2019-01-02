<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'voucher', 'namespace' => 'Modules\Voucher\Http\Controllers'], function()
{
    Route::get('/', 'VoucherController@voucherList');
    Route::any('create', 'VoucherController@create');
    Route::post('delete', 'VoucherController@delete');
    Route::any('edit/{id}', 'VoucherController@update');

    Route::any('point', 'PointController@point');
    Route::any('point/detail/{phone}', 'PointController@pointDetail');
});

/* webview */
Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'webview', 'namespace' => 'Modules\Voucher\Http\Controllers'], function()
{
    Route::get('/voucher/{id_deals_user}', 'WebviewVoucherController@voucherDetail');
});