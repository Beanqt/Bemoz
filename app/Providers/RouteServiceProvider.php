<?php

namespace App\Providers;

use App\Http\Controllers\Api\UserDetect;
use App\Models\Cache;
use App\Models\Redirects;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function boot()
    {
        $this->configureRateLimiting();

        if(isset($_SERVER['HTTP_BROWSERSYNC_HEADER']) && request()->ajax()){
            $url = isset($_SERVER['APP_URL']) ? $_SERVER['APP_URL'] : '';
            if(isset($_SERVER['HTTP_REFERER'])){
                preg_match('/:([0-9]{4})/', $_SERVER['HTTP_REFERER'], $port);

                if(isset($port[1])){
                    $url = env('APP_URL').':'.$port[1];
                }
            }

            $this->app['url']->forceRootUrl($url);
        }

        if(!app()->runningInConsole()){
            $this->routes(function(){
                $userDetect = new UserDetect();
                $userDetect->detect();

                $segment = request()->segment(1);

                if($segment == 'throne'){
                    $this->mapThroneRoutes();
                }elseif($segment == 'cron'){
                    $this->mapCronRoutes();
                }else{
                    if(auth()->guard('public')->check()){
                        session()->put('visitor_type', [0,1]);
                    }else{
                        session()->put('visitor_type', [0]);
                    }

                    app('LanguageService')->init();

                    $this->mapAuthRoutes();
                    $this->mapWebRoutes();
                    $this->mapApiRoutes();
                }
            });
        }
    }

    protected function configureRateLimiting(){
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapWebRoutes(){
        $this->redirects();

        Route::middleware('web')->prefix(app()->getLocale() == env('DEFAULT_LANG') ? null : app()->getLocale())
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    protected function mapAuthRoutes(){
        Route::middleware('public')->prefix(app()->getLocale() == env('DEFAULT_LANG') ? null : app()->getLocale())
            ->namespace($this->namespace)
            ->group(base_path('routes/auth.php'));
    }

    protected function mapApiRoutes(){
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    protected function mapThroneRoutes(){
        if($_SERVER['USER_DATA']['device'] == 4){
            header("HTTP/1.1 401 Unauthorized");
            exit;
        }
        Route::prefix('throne')->group(base_path('routes/throne.php'));
    }

    protected function mapCronRoutes()
    {
        Route::prefix('cron')->group(base_path('routes/cron.php'));
    }

    protected function redirects(){
        if(Cache::has('redirects')){
            $redirects = Cache::get('redirects');
        }else{
            $redirects = Redirects::pluck('new', 'old')->all();
            Cache::rememberForever('redirects', $redirects);
        }

        $url = str_replace(url('/'),'', request()->fullUrl());

        if(array_key_exists($url, $redirects)){
            header('Location: '.$redirects[$url]);
            die();
        }
    }
}
