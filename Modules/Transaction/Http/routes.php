<?php

Route::group(['middleware' => 'web', 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::get('/setting/rule', 'TransactionController@ruleTransaction');
    Route::post('/setting/rule/update', 'TransactionController@ruleTransactionUpdate');
    Route::get('/internalcourier', 'TransactionController@internalCourier');
    
    Route::post('/manual-payment-save', ['middleware' => 'config_control:17', 'uses' => 'TransactionController@manualPaymentSave']);
    Route::post('/manual-payment-update/{id}', ['middleware' => 'config_control:17', 'uses' => 'TransactionController@manualPaymentUpdate']);

    Route::get('/point', 'TransactionController@pointUser');
    Route::get('/balance', 'TransactionController@balanceUser');
	Route::any('autoresponse/{subject}', ['middleware' => 'feature_control:17', 'uses' =>'TransactionController@autoResponse']);
    Route::group(['prefix' => 'manualpayment', 'middleware' => 'config_control:17'], function()
    {
		Route::any('/banks', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksList']);
		Route::any('/banks/create', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksCreate']);
		Route::get('/banks/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@banksDelete']);
        Route::any('/banks/method/create', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@bankMethodsCreate']);
        Route::any('/banks/method', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@banksMethodList']);
		Route::get('/banks/method/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@bankMethodsDelete']);
		
        Route::get('/', ['middleware' => 'feature_control:64', 'uses' => 'TransactionController@manualPaymentList']);
        Route::any('/list/{type?}', 'TransactionController@manualPaymentUnpay');
        Route::any('/reset/{type?}', 'TransactionController@manualPaymentUnpay');
        Route::get('/create', ['middleware' => 'feature_control:66', 'uses' => 'TransactionController@manualPaymentCreate']);
        Route::get('/edit/{id}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentEdit']);
        Route::get('/detail/{id}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentDetail']);
        Route::get('/delete/{id}', ['middleware' => 'feature_control:68', 'uses' => 'TransactionController@manualPaymentDelete']);
        Route::get('/getData/{id}', 'TransactionController@manualPaymentGetData');
        Route::post('/method/save', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@manualPaymentMethod']);
        Route::post('/method/delete', ['middleware' => 'feature_control:67', 'uses' => 'TransactionController@manualPaymentMethodDelete']);
        
        Route::any('/confirm/{id}', ['middleware' => 'feature_control:65', 'uses' => 'TransactionController@manualPaymentConfirm']);
    });

    Route::get('/admin/{receipt}/{phone}', 'TransactionController@adminOutlet');
    Route::get('/admin/{type}/{status}/{receipt}/{id}', 'TransactionController@adminOutletConfirm');

});

Route::group(['middleware' => 'web', 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::get('/setting/cashback', 'TransactionSettingController@list');
    Route::post('/setting/cashback/update', 'TransactionSettingController@update');
});


Route::group(['middleware' => 'web', 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => 'feature_control:69', 'uses' => 'TransactionController@transactionList']);
    Route::get('/detail/{id}/{key}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionDetail']);
    Route::get('/delete/{id}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionDelete']);

    Route::any('/{key}/{slug}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transaction']);
    Route::any('/{key}/{slug}/filter', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transactionFilter']);

    Route::any('/point/filter/{date}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@pointUserFilter']);
    Route::any('/balance/filter/{date}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@balanceUserFilter']);
    // Route::any('/{key}/{slug}', ['middleware' => 'feature_control:70', 'uses' => 'TransactionController@transaction']);
});

Route::group(['middleware' => 'web', 'prefix' => 'transaction', 'namespace' => 'Modules\Transaction\Http\Controllers'], function()
{
    Route::get('/web/view/detail', 'WebviewController@detail');
    Route::get('/web/view/detail/point', 'WebviewController@detailPoint');
    Route::get('/web/view/trx', 'WebviewController@success');
});