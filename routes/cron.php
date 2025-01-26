<?php

Route::group(['prefix' => 'yUQbcyWhOL', 'namespace' => 'App\Http\Controllers'], function () {
    Route::get('manager', function () {
        \Illuminate\Support\Facades\Artisan::call('schedule:run');
    });
});