<?php

Route::group(['middleware' => ['web', 'validate_session'], 'prefix' => 'campaign', 'namespace' => 'Modules\Campaign\Http\Controllers'], function()
{
	Route::any('/', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignList']);
	Route::any('/page/{page}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignList']);
	
    Route::any('email/outbox', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailOutbox']);
    Route::any('email/outbox/page/{page}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailOutbox']);
    Route::any('email/outbox/detail/{id}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailOutboxDetail']);
	
    Route::any('email/queue', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailQueue']);    
    Route::any('email/queue/page/{page}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailQueue']);  
    Route::any('email/queue/detail/{id}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@emailQueueDetail']);  
	
	Route::any('sms/outbox', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsOutbox']);
	Route::any('sms/outbox/page/{page}', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsOutbox']);
	Route::any('sms/outbox/detail/{id}', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsOutboxDetail']);
	
    Route::any('sms/queue', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsQueue']);
    Route::any('sms/queue/page/{page}', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsQueue']);
    Route::any('sms/queue/detail/{id}', ['middleware' => 'config_control:50,52', 'uses' => 'CampaignController@smsQueueDetail']);
	
	Route::any('push/outbox', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushOutbox']);
	Route::any('push/outbox/page/{page}', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushOutbox']);
	Route::any('push/outbox/detail/{id}', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushOutboxDetail']);
	
    Route::any('push/queue', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushQueue']);
    Route::any('push/queue/page/{page}', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushQueue']);
    Route::any('push/queue/detail/{page}', ['middleware' => 'config_control:50,53', 'uses' => 'CampaignController@pushQueueDetail']);

    Route::any('whatsapp/outbox', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappList']);
    Route::any('whatsapp/outbox/page/{page}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappList']);
    Route::any('whatsapp/outbox/detail/{id}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappDetail']);
	
    Route::any('whatsapp/queue', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappList']);    
    Route::any('whatsapp/queue/page/{page}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappList']);  
    Route::any('whatsapp/queue/detail/{id}', ['middleware' => 'config_control:50,51', 'uses' => 'CampaignController@whatsappDetail']);  
	
    Route::get('create', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@create']);
    Route::post('create', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@createPost']);
    Route::get('step1/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep1']);
    Route::post('step1/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep1Post']);
    
    Route::get('step2/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep2']);
    Route::post('step2/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep2Post']);
	
	Route::get('step3/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep3']);
	Route::post('step3/{id_campaign}', ['middleware' => 'config_control:50', 'uses' => 'CampaignController@campaignStep3Post']);

});
