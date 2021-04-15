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

Route::prefix('quest')->middleware(['web', 'validate_session'])->group(function () {
    Route::any('/', 'QuestController@index');
    Route::get('create', 'QuestController@create');
    Route::post('create', 'QuestController@store');
    Route::any('detail/{slug}', 'QuestController@show');
    Route::post('detail/{id}/update/content', 'QuestController@updateContent');
    Route::post('detail/{id}/update/quest', 'QuestController@updateQuest');
    Route::post('detail/{id}/update/benefit', 'QuestController@updateBenefit');
    Route::any('update/detail', 'QuestController@update');
});
