<?php

Route::group(['middleware' => ['activity', 'account']], function () {
    Route::group(['prefix' => trans('public.profile.main.slug')], function () {
        Route::match(['get', 'post'], '/', [
            'as'   => 'profile',
            'uses' => 'UsersController@profile_edit'
        ]);
    });

    Route::match(['get','post'],'/'.trans('public.logout.slug'), [
        'as'   => 'logout',
        'uses' => 'UsersController@logout'
    ]);
});