<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'activity'], function () {
    Route::get('/', [
        'as'   => 'index',
        'uses' => 'HomeController@index'
    ]);

    Route::get('/download/{folder}/{slug}', [
        'as' => 'download',
        'uses' => 'Api\DownloadController@download'
    ]);

    Route::match(['get','post'],'/'.trans('public.search.slug'), [
        'as'   => 'search',
        'uses' => 'SearchController@index'
    ]);

    Route::group(['prefix' => trans('public.feeds.slug')], function() {
        Route::get('/'.trans('public.feeds.labels.slug').'/{label}', [
            'as'   => 'feeds.label',
            'uses' => 'FeedController@label'
        ]);
        Route::get('/{category?}', [
            'as'   => 'feeds.lists',
            'uses' => 'FeedController@lists'
        ]);
        Route::get('/{category}/{slug}', [
            'as'   => 'feeds.item',
            'uses' => 'FeedController@item'
        ]);
    });

    Route::group(['prefix' => trans('public.events.slug')], function() {
        Route::get('/{category?}', [
            'as'   => 'events',
            'uses' => 'EventsController@index'
        ]);
        Route::get('/{category}/{slug}', [
            'as'   => 'event.item',
            'uses' => 'EventsController@item'
        ]);
    });

    Route::group(['prefix' => 'form/{id}'], function () {
        Route::post('/', [
            'as' => 'form.post',
            'uses' => 'FormController@index'
        ]);
        Route::get('/success', [
            'as' => 'form.success',
            'uses' => 'FormController@success'
        ]);
    });

    Route::match(['get','post'],'/'.trans('public.login.slug'), [
        'as'   => 'login',
        'uses' => 'UsersController@login'
    ]);

    Route::group(['prefix' => trans('public.login.reminder.slug')], function () {
        Route::match(['get', 'post'], '/', [
            'as' => 'reminder',
            'uses' => 'UsersController@reminder'
        ]);
        Route::match(['get', 'post'],'/{token}', [
            'as' => 'reminder.token',
            'uses' => 'UsersController@reminder_token'
        ]);
    });

    Route::match(['get','post'],'/'.trans('public.reg.slug'), [
        'as'   => 'reg',
        'uses' => 'UsersController@registration'
    ]);

    Route::get('/{slug}', [
        'as'   => 'pages',
        'uses' => 'PagesController@index'
    ]);
});
