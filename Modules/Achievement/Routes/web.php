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
    Route::any('create', 'AchievementController@create');
    Route::any('create/{slug}', 'AchievementController@create');
    Route::any('detail/{slug}', 'AchievementController@detail');
});
