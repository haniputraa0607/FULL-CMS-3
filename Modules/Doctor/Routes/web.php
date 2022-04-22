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

Route::prefix('doctor')->group(function() {
    Route::get('/', 'DoctorController@index');
    Route::post('/', 'DoctorController@filter');
    Route::get('/create', 'DoctorController@create');
    Route::get('/{id}/show', 'DoctorController@show');
    Route::post('/store', 'DoctorController@store');
    Route::get('/{id}/edit', 'DoctorController@edit');
    Route::put('/{id}/update', 'DoctorController@update');
    Route::post('/delete', 'DoctorController@destroy');

    Route::resource('clinic', 'DoctorClinicController');
    Route::resource('service', 'DoctorServiceController');
    Route::resource('specialist', 'DoctorSpecialistController');
    Route::resource('specialist-category', 'DoctorSpecialistCategoryController');
});
