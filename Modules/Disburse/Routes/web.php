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

Route::get('disburse/logout', function(){
    $a = session('success')['s'];
    session()->flush();
    if($a) session(['success' => ['s' => $a]]);
    return redirect('disburse/login');
});

Route::group(['middleware' => 'web', 'prefix' => 'disburse'], function() {
    Route::get('login', function(){
        if(!session()->has('username-franchise')) return view('disburse::login'); else return redirect('disburse/home');
    });

    Route::post('login', 'DisburseController@loginUserFranchise');

    Route::group(['middleware' => 'validate_session_disburse'], function(){
        Route::any('user-franchise/dashboard', 'DisburseController@dashboard');
        Route::post('user-franchise/getOutlets', 'DisburseController@getOutlets');
        Route::post('user-franchise/getUserFranchise', 'DisburseController@userFranchise');

        //Disburse
        Route::any('user-franchise/list/trx', 'DisburseController@listTrx');
        Route::any('user-franchise/list/{status}', 'DisburseController@listDisburse');
        Route::any('user-franchise/list-datatable/{status}', 'DisburseController@listDisburseDataTable');
        Route::any('user-franchise/detail/{id}', 'DisburseController@detailDisburse');

        Route::any('user-franchise/reset-password', 'DisburseController@resetPassword');
    });

    Route::group(['middleware' => 'validate_session'], function(){
        Route::any('dashboard', 'DisburseController@dashboard');
        Route::post('getOutlets', 'DisburseController@getOutlets');
        Route::post('getUserFranchise', 'DisburseController@userFranchise');

        //Setting
        Route::any('setting/list-outlet', 'DisburseSettingController@listOutlet');
        Route::any('setting/bank-account', 'DisburseSettingController@bankAccount');
        Route::any('setting/mdr', 'DisburseSettingController@mdr');
        Route::any('setting/mdr-global', 'DisburseSettingController@mdrGlobal');
        Route::get('setting/global', 'DisburseSettingController@settingGlobal');
        Route::post('setting/fee-global', 'DisburseSettingController@feeGlobal');
        Route::post('setting/point-charged-global', 'DisburseSettingController@pointChargedGlobal');
        Route::any('setting/fee-outlet-special/outlets', 'DisburseSettingController@listOutletAjax');
        Route::any('setting/fee-outlet-special/update', 'DisburseSettingController@settingFeeOutletSpecial');

        //Disburse
        Route::any('list/trx', 'DisburseController@listTrx');
        Route::any('list/{status}', 'DisburseController@listDisburse');
        Route::any('list-datatable/{status}', 'DisburseController@listDisburseDataTable');
        Route::any('detail/{id}', 'DisburseController@detailDisburse');
    });
});