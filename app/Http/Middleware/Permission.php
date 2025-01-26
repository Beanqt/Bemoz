<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;

class Permission {
	protected $auth;

	public function __construct(){
		$this->auth = auth()->guard('admin');
	}

	public function handle($request, Closure $next, $role){
		$route = Route::current();

		if(array_key_exists('permission_name',$route->action)){
			if(is_array($route->action['permission_name'])){
				$route->action['permission_name'] = end($route->action['permission_name']);
			}
			if(!$this->auth->user()->havePermission($route->action['permission_name'].'.'.$role)){
				if($request->ajax()){
					return response(['content' => trans('admin.notPermission.text')], 401);
				}

				return redirect()->route('throne.notPermission');
			}
		}else{
			throw new \Exception('Not set "permission_name" in route');
		}

		return $next($request);
	}

}
