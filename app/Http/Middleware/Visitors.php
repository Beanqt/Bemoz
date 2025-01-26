<?php namespace App\Http\Middleware;

use App\Models\Activity;
use App\Models\Visitor;
use Closure;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Route;

class Visitors {
	protected $auth;

	public function __construct(Guard $auth){
		$this->auth = $auth;
	}

	public function handle($request, Closure $next){
		if(setting('service') && !auth()->guard('admin')->user() && Route::currentRouteName() != 'index') {
			return redirect()->route('index');
		}

		if(!in_array($_SERVER['USER_DATA']['device'], [4,5])){
			$hash = $this->getHash();
			$page = $request->path();

			$result = Activity::select('id')->where('hash', $hash)->first();

			if($result){
				$result->updated_at = date('Y-m-d H:i:s');
				$result->save();
			}else{
				$model = new Activity();
				$model->hash = $hash;
				$model->save();
			}

			if(!session('visitorUrl.'.$page)){
				session('visitorUrl.'.$page,$page);

				$result = Visitor::select('id')->where('hash', $hash)->where('page', $page)->where('device', $_SERVER['USER_DATA']['device'])->first();

				if(!$result){
					$model = new Visitor();
					$model->hash = $hash;
					$model->page = $page;
					$model->browser = $_SERVER['USER_DATA']['browser'];
					$model->device = $_SERVER['USER_DATA']['device'];
					$model->save();
				}
			}
		}

		return $next($request);
	}

	public function getHash(){
		$data['hash'] = sha1('Fkl!12'.(isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'not set').'34!HgL');

		if(Cookie::get('visitor')){
			$data['hash'] = Cookie::get('visitor');
		}elseif(session('visitorHash')){
			$data['hash'] = session('visitorHash');
		}else{
			Cookie::queue('visitor', $data['hash'], 360000);
			session()->put('visitorHash',$data['hash']);
		}

		return $data['hash'];
	}
}
