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

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'achievement'], function () {
    Route::get('/', 'AchievementController@index');
    Route::post('/', 'AchievementController@indexAjax');
    Route::any('create', 'AchievementController@create');
    Route::any('remove', 'AchievementController@remove');
    Route::any('detail/{slug}', 'AchievementController@show');
    Route::any('update/detail', 'AchievementController@update');
    Route::any('report/{slug}', 'AchievementController@report');
});
