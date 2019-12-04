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

Route::group(['middleware' => ['web', 'validate_session', 'config_control:84'], 'prefix' => 'subscription'], function () {
    Route::get('/', 'SubscriptionController@index');
    Route::any('create', 'SubscriptionController@create');
    Route::any('step1/{id_subscription}', 'SubscriptionController@create');
    Route::any('step1', 'SubscriptionController@create');
    Route::any('step2/{id_subscription}', 'SubscriptionController@step2');
    Route::any('step3/{id_subscription}', 'SubscriptionController@step3');
});
