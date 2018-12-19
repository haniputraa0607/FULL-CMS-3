<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'news', 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    Route::get('/', ['middleware' => 'feature_control:19', 'uses' => 'NewsController@index']);
    Route::get('ajax', ['middleware' => 'feature_control:19', 'uses' => 'NewsController@indexAjax']);
    Route::any('create', ['middleware' => 'feature_control:21', 'uses' => 'NewsController@create']);
    Route::post('delete', ['middleware' => 'feature_control:23', 'uses' => 'NewsController@delete']);
    Route::get('detail/{id}/{slug}', ['middleware' => 'feature_control:20', 'uses' => 'NewsController@detail']);
    Route::post('detail/{id}/{slug}', ['middleware' => 'feature_control:22', 'uses' => 'NewsController@detail']);
});

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'news', 'namespace' => 'Modules\Advert\Http\Controllers'], function()
{
    /* ADVERT */
    Route::any('advert', 'AdvertController@index');
});

Route::group(['middleware' => 'web', 'prefix' => '', 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    Route::any('news_form/{id}/form/{phone?}', 'NewsController@customFormView');
    // Route::get('news_form/success', 'NewsController@customFormSuccess');
});

Route::group(['prefix' => 'news', 'namespace' => 'Modules\News\Http\Controllers'], function()
{
    Route::any('webview/{id}', 'WebviewNewsController@detail');
});
