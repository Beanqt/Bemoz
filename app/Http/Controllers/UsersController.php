<?php namespace App\Http\Controllers;

use App\Models\Emails;
use App\Models\Users;
use App\Services\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class UsersController extends Controller {
	public $breadcrumbs;

	public function __construct(){
		$this->breadcrumbs = new Breadcrumbs();
		$this->breadcrumbs->add(trans('public.profile.main.title'), route('profile'));
	}

	public function login(Request $request, Users $model) {
		if(auth()->guard('public')->check()){
			return redirect()->route('profile');
		}

		if($request->isMethod('post')){
			$e = request()->all();

			$messages = [
				'required' => trans('public.alerts.required'),
				'email' => trans('public.alerts.email'),
				'min' => trans('public.alerts.pass_min'),
			];

			$validator = Validator::make($e, [
				'email' => 'required|email',
				'password' => 'required|min:5',
			],$messages);

			if(!$validator->fails()) {
				if(auth()->guard('public')->attempt(['email' => $e['email'], 'password' => $e['password']])) {
					$user = auth()->guard('public')->user();
					$user->last_login = date('Y-m-d H:i:s');
					$user->save();

					return redirect()->route('profile');
				}else{
					session()->flash('login_error', trans('public.alerts.wrongLogin'));
				}
			}

			return redirect()->back()->withInput()->withErrors($validator);
		}

		View::share('breadcrumbs', $this->breadcrumbs->add(trans('public.login.title'), route('login'))->render());
		return view('layouts.auth.login');
	}

	public function logout(){
		auth()->guard('public')->logout();
		session()->flush();
		return redirect()->back();
	}

	public function registration(Request $request, Users $users) {
		if(auth()->guard('public')->check()){
			return redirect()->route('profile');
		}

		if($request->isMethod('post')) {
			$e = request()->all();

			if($users->isValid($e)){
				$users->saveData($e);

				if(auth()->guard('public')->attempt(['email' => $e['email'], 'password' => $e['password'], 'active' => 1])) {
					session()->flash('reg', true);
					return redirect()->route('profile');
				}
			}

			View::share('data', $e);
			return redirect()->back()->withErrors($users->validator)->withInput();
		}

		return view('layouts.auth.reg');
	}

	public function reminder() {
		if(auth()->guard('public')->check()){
			return redirect()->route('profile');
		}

		$e = request()->all();

		$messages = [
			'required' => trans('public.alerts.required'),
			'email' => trans('public.alerts.email'),
		];

		$validator = Validator::make($e, [
			'reminder_email' => 'required|email',
		],$messages);

		if(!$validator->fails()) {
			$user = Users::where('email', $e['reminder_email'])->first();

			if($user){
				$e['token'] = sha1($user->hash.time());
				$e['name'] = $user->name;

				$user->reminder = $e['token'];
				$user->save();

				Emails::find(1)->data($e)->template('default')->send($e['reminder_email']);

				session()->flash('reminder_success', trans('public.alerts.successReminder'));
				return redirect()->back()->withInput();
			}else{
				session()->flash('reminder_error', trans('public.alerts.wrongReminder'));
			}
		}
		return redirect()->back()->withInput()->withErrors($validator);
	}

	public function reminder_token($token, Request $request) {
		$user = Users::where('reminder', $token)->first();

		if($user){
			if($request->isMethod('post')){
				$e = request()->all();

				$messages = [
					'required' => trans('public.alerts.required'),
					'min' => trans('public.alerts.pass_min'),
					'reminder_password.confirmed' => trans('public.alerts.match'),
				];

				$validator = Validator::make($e, [
					'reminder_password' => 'required|confirmed|regex:/^[a-zA-Z0-9]{5,16}$/',
					'reminder_password_confirmation' => 'required',
				],$messages);

				if(!$validator->fails()) {
					$user->password = bcrypt($e['reminder_password']);
					$user->reminder = null;
					$user->save();

					if(auth()->guard('public')->attempt(['email' => $user['email'], 'password' => $e['reminder_password'], 'active' => 1])) {
						return redirect()->route('profile');
					}
				}
			}
			if(isset($validator)){
				return view('layouts.auth.reminder.new')->withErrors($validator);
			}
			return view('layouts.auth.reminder.new');
		}

		return redirect()->route('login');
	}

	public function profile_edit(Request $request){
		$data = auth()->guard('public')->user();
		$validator = [];

		if($request->isMethod('post')){
			$e = request()->all();

			$messages = [
				'required' => trans('public.alerts.required'),
				'regex' => trans('public.alerts.regex'),
				'password.confirmed' => trans('public.alerts.match'),
			];

			if(isset($e['pw'])){
				$rules = [
					'old_password' => 'required',
					'password' => 'required|confirmed|regex:/^[a-zA-Z0-9]{5,16}$/',
					'password_confirmation' => 'required',
				];
			}else{
				$rules = [
					'name' => 'required',
					'phone' => 'regex:/^06+[0-9]{9}$/'
				];
			}

			$validator = Validator::make($e, $rules,$messages);

			if(isset($e['pw'])){
				$validator->after(function ($validator) use($e, $data) {
					if(!Hash::check($e['old_password'], $data->password)){
						$validator->errors()->add('old_password', trans('public.alerts.old_password'));
					}
				});
			}

			if(!$validator->fails()) {
				$model = auth()->guard('public')->user();
				if(isset($e['pw'])){
					$model->password = bcrypt($e['password']);
				}else{
					$model->name = $e['name'];
					$model->phone = $e['phone'];
				}
				$model->save();

				session()->flash('success', isset($e['pw']) ? trans('public.profile.savePassword') : trans('public.profile.save'));
				return redirect()->route('profile');
			}
		}

		View::share('data', $data);
		return view('layouts.auth.profile.edit')->withErrors($validator);
	}
}
