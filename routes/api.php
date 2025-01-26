<?php

Route::group(['prefix' => app()->getLocale() == env('DEFAULT_LANG') ? null : app()->getLocale()], function () {
    Route::get('/gallery/{id}', [
        'as' => 'api.gallery',
        'uses' => 'ApiController@gallery'
    ]);
    Route::get('/document/{id}', [
        'as' => 'api.document',
        'uses' => 'ApiController@document'
    ]);
    Route::get('/video/{id}', [
        'as' => 'api.video',
        'uses' => 'ApiController@video'
    ]);
    Route::post('/search', [
        'as'   => 'api.search',
        'uses' => 'SearchController@search'
    ]);
    Route::post('/save-search', [
        'as'   => 'api.save.search',
        'uses' => 'SearchController@searchSave'
    ]);
    Route::get('/events/{category?}', [
        'as' => 'api.events',
        'uses' => 'EventsController@events'
    ]);
    Route::get('/delete-cookie', [
        'as'   => 'delete_cookie',
        'uses' => 'HomeController@deleteCookie'
    ]);

    Route::group(['prefix' => 'feeds'], function(){
        Route::post('/view', [
            'as' => 'api.feeds.view',
            'uses' => 'FeedController@view'
        ]);
        Route::get('/page', [
            'as' => 'api.feeds.page',
            'uses' => 'FeedController@page'
        ]);
    });
});