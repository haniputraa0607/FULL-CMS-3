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

Route::group(['middleware' => 'validate_session', 'prefix' => 'merchant'], function(){
    Route::get('setting/register-introduction', 'MerchantController@settingRegisterIntroduction');
    Route::post('setting/register-introduction', 'MerchantController@settingRegisterIntroduction');
    Route::get('setting/register-success', 'MerchantController@settingRegisterSuccess');
    Route::post('setting/register-success', 'MerchantController@settingRegisterSuccess');
});

