<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'consultation', 'namespace' => 'Modules\Consultation\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => 'feature_control:41', 'uses' => 'ConsultationController@consultationList']);
    Route::get('/search', ['middleware' => 'feature_control:43', 'uses' => 'ConsultationController@consultationSearch']);
    Route::any('/filter', ['middleware' => 'feature_control:43', 'uses' => 'ConsultationController@consultationFilter']);

    Route::get('/be', 'ConsultationController@index');
    Route::post('/be', 'ConsultationController@filter');
    Route::get('be/{id}/detail', 'ConsultationController@detail');
});