<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admins;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class AuthController extends Controller {

	public function __construct() {
		if(session('adminLang')){
			app()->setLocale(session('adminLang'));
		}else{
			app()->setLocale('hu');
		}
	}
	public function authenticate() {
		$e = request()->all();

		if(auth()->guard('admin')->attempt(['email' => $e['email'], 'password' => $e['password']])) {
			$user = auth()->guard('admin')->user();
			auth()->guard('admin')->logout();

			if(!is_null($user->ban) && $user->ban < date('Y-m-d H:i:s', strtotime($user->ban.' +24 hour'))) {
				session()->flash('error', trans('admin.auth.ban'));
				return redirect()->route('throne.login');
			}elseif($user->first_login){
				session()->put('change_password', ['email' => $e['email'], 'password' => $e['password']]);
				return redirect()->route('throne.login');
			}

			auth()->guard('admin')->attempt(['email' => $e['email'], 'password' => $e['password']]);
			Admins::where('id', auth()->guard('admin')->id())->update(['wrong' => 0]);

			return redirect()->intended('throne/dashboard');
		}else{
			$admin = Admins::where('email', $e['email'])->first();
			$error = trans('admin.auth.wrong');

			if($admin && is_null($admin['ban'])){
				if($admin->wrong < 3){
					Admins::where('id', $admin->id)->update(['wrong' => $admin->wrong+1]);
				}else {
					if(is_null($admin->ban)){
						Admins::where('id', $admin->id)->update(['ban' => date('Y-m-d H:i:s')]);
					}

					$error = trans('admin.auth.ban');
				}
			}

			session()->flash('error', $error);
			return redirect()->route('throne.login');
		}

	}

	public function login() {
		if(auth()->guard('admin')->check()){
			return redirect()->intended('throne/dashboard');
		}
		return View::make('throne.layouts.login');
	}

	public function firstLogin(Request $request){
		if(session('change_password')){
			if($request->isMethod('post')){
				$e = request()->all();

				$messages = [
					'required' => trans('admin.alert.required'),
					'min' => trans('admin.alert.min', ['c' => 5]),
					'regex' => trans('admin.alert.password_regex'),
					'password.confirmed' => trans('admin.alert.password_confirmed'),
				];

				$rules['password'] = 'required|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).[A-Za-z0-9%_]{5,}$/|confirmed';
				$rules['password_confirmation'] = 'required|min:5';

				$validator = Validator::make($e,$rules,$messages);

				$validator->after(function($validator) use($e){
					if($e['password'] == session('change_password.password')){
						$validator->errors()->add('password', trans('admin.change_password.alerts.old_password'));
					}
				});

				if(!$validator->fails()){
					if(auth()->guard('admin')->attempt(['email' => session('change_password.email'), 'password' => session('change_password.password')])) {
						Admins::where('id', auth()->guard('admin')->id())->update(['password' => bcrypt($e['password']), 'wrong' => 0, 'first_login' => 0]);
						session()->forget('change_password');

						return redirect()->intended('throne/dashboard');
					}

					session()->put('error', trans('admin.auth.wrong'));
					session()->forget('change_password');
					return redirect()->route('throne.login');
				}

				return redirect()->route('throne.login')->withErrors($validator);
			}
		}
		return redirect()->route('throne.login');
	}

	public function logout() {
		auth()->guard('admin')->logout();
		session()->flush();
		return redirect()->route('throne.login');
	}

	public function selectAdminLanguage($lang = 'hu', $url = 'dashboard'){
		session()->put('adminLang', $lang);
		return redirect()->route('throne.'.$url);
	}
}
