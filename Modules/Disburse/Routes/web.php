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
Route::get('/disburse', function () {
    return redirect('disburse/login');
});

Route::group(['middleware' => 'web', 'prefix' => 'disburse'], function() {
//    Route::get('login', function () {
//        if (!session()->has('username-disburse')) return view('disburse::login'); else return redirect('disburse::home');
//    });
//    Route::post('login', 'DisburseController@login');
//    Route::group(['middleware' => 'validate_session_disburse'], function(){
//        Route::get('dashboard', 'DisburseController@dashboard');
//    });

    Route::any('dashboard', 'DisburseController@dashboard');
    Route::post('getOutlets', 'DisburseController@getOutlets');
    Route::post('getUserFranchise', 'DisburseController@userFranchise');

    //Setting Bank Account
    Route::any('setting/list-outlet', 'DisburseSettingController@listOutlet');
    Route::any('setting/bank-account', 'DisburseSettingController@bankAccount');
    Route::any('setting/mdr', 'DisburseSettingController@mdr');
    Route::any('setting/mdr-global', 'DisburseSettingController@mdrGlobal');
    Route::get('setting/global', 'DisburseSettingController@settingGlobal');
    Route::post('setting/fee-global', 'DisburseSettingController@feeGlobal');
    Route::post('setting/point-charged-global', 'DisburseSettingController@pointChargedGlobal');

    //Disburse
    Route::any('list/trx', 'DisburseController@listTrx');
    Route::any('list/{status}', 'DisburseController@listDisburse');
    Route::any('list-datatable/{status}', 'DisburseController@listDisburseDataTable');
    Route::any('detail/{id}', 'DisburseController@detailDisburse');
});