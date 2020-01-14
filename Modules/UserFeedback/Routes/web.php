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
	Route::group(['prefix'=>'item'],function(){
	    Route::get('/', ['middleware' => 'feature_control:212', 'uses' => 'RatingItemController@index']);
	    Route::post('/', ['middleware' => 'feature_control:213', 'uses' => 'RatingItemController@update']);
	});
    Route::get('setting', ['middleware' => 'feature_control:213', 'uses' => 'UserFeedbackController@setting']);
    Route::post('setting', ['middleware' => 'feature_control:213', 'uses' => 'UserFeedbackController@settingUpdate']);
    Route::get('/detail/{id}', 'UserFeedbackController@show');
    Route::get('/{key?}', 'UserFeedbackController@index');
});
