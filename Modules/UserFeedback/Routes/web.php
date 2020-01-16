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

Route::prefix('user-feedback')->group(function() {
    Route::post('item', ['middleware' => 'feature_control:213', 'uses' => 'RatingItemController@update']);
    Route::get('setting', ['middleware' => 'feature_control:212', 'uses' => 'UserFeedbackController@setting']);
    Route::post('setting', ['middleware' => 'feature_control:212', 'uses' => 'UserFeedbackController@settingUpdate']);
    Route::get('/detail/{id}', 'UserFeedbackController@show');
    Route::get('/', 'UserFeedbackController@index');
    Route::post('/', 'UserFeedbackController@setFilter');
});
