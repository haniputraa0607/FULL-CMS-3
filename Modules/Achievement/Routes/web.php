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

    /*Report Achievement*/
    Route::any('report', 'AchievementController@reportAchievement');
    Route::any('report/detail/{id}', 'AchievementController@reportDetailAchievement');
    Route::any('report/list-user/{id}', 'AchievementController@reportListUserAchievement');

    /*Report User Achievement*/
    Route::any('report/user-achievement', 'AchievementController@reportUser');
    Route::any('report/user-achievement/detail/{phone}', 'AchievementController@reportDetailUser');
    Route::any('report/user-achievement/detail-badge/{id_achievement_group}/{phone}', 'AchievementController@reportDetailBadgeUser');

});
