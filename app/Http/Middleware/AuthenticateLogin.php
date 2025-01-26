<?php namespace App\Http\Middleware;

use Closure;

class AuthenticateLogin {
	protected $auth;

	public function __construct(){
		$this->auth = auth()->guard('public');
	}

	public function handle($request, Closure $next){
		if(!$this->auth->check()){
			return $request->ajax() ? response(['redirect' => route('login')], 401) : redirect()->route('login');
		}

		return $next($request);
	}

}
