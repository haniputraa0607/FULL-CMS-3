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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'merchant'], function(){
    Route::get('setting/register-introduction', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterIntroduction']);
    Route::post('setting/register-introduction', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterIntroduction']);
    Route::get('setting/register-success', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterSuccess']);
    Route::post('setting/register-success', ['middleware' => 'feature_control:326', 'uses' => 'MerchantController@settingRegisterSuccess']);

    //merchant management
    Route::get('/', 'MerchantController@list');
    Route::get('detail/{id}', 'MerchantController@detail');
    Route::post('update/{id}', 'MerchantController@update');
    Route::any('candidate', 'MerchantController@candidate');
    Route::get('candidate/detail/{id}', 'MerchantController@detail');
    Route::post('candidate/update/{id}', 'MerchantController@candidateUpdate');
    Route::post('candidate/delete/{id}', 'MerchantController@candidateDelete');
});
