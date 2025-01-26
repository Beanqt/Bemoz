<?php namespace App\Http\Middleware;

use Closure;

class Authenticate {
    protected $auth;

    public function __construct(){
        $this->auth = auth()->guard('admin');
    }

    public function handle($request, Closure $next){
        if(!$this->auth->check()){
            return $request->ajax() ? response(['redirect' => route('throne.logout')], 401) : redirect()->route('throne.logout');
        }

        if(session('adminLang')){
            app()->setLocale(session('adminLang'));
        }else{
            app()->setLocale('hu');
        }

        if(isset($_GET['moduleLang'])){
            session()->put('moduleLang', $_GET['moduleLang']);
            return redirect()->back();
        }elseif(!session('moduleLang')){
            session()->put('moduleLang', env('DEFAULT_LANG'));
        }

        return $next($request);
    }
}
