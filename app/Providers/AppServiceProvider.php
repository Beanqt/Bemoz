<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('SettingsService','App\Services\SettingsService');
        $this->app->singleton('MenuService','App\Services\MenuService');
        $this->app->singleton('WidgetService','App\Services\WidgetService');
        $this->app->singleton('HelperService', 'App\Services\HelperService');
        $this->app->singleton('LanguageService', 'App\Services\LanguageService');
        $this->app->singleton('HelpMessageService', 'App\Services\HelpMessageService');
        $this->app->singleton('PopupService', 'App\Services\PopupService');
    }
}
