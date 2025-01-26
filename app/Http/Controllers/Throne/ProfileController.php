<?php namespace App\Http\Controllers\Throne;

use App\Models\Admins;
use App\Models\Tutorial;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public $default = 'profile';

    public function edit(Request $request) {
        $validator = [];
        if($request->isMethod('post')) {
            $e = request()->all();

            $messages = [
                'min' => trans('admin.alert.min', ['c' => 5]),
                'regex' => trans('admin.alert.password_regex'),
                'password.confirmed' => trans('admin.alert.password_confirmed'),
            ];

            $rules['password'] = 'min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).[A-Za-z0-9%_]{5,}$/|confirmed';

            $validator = Validator::make($e,$rules,$messages);

            if(!$validator->fails()){
                $model = Admins::find(auth()->guard('admin')->user()->id);
                if(!empty($e['password'])){
                    $model->password = bcrypt($e['password']);
                }
                $model->tutorial = isset($e['tutorial']) ? 1 : 0;
                $model->save();

                $model = Tutorial::where('user', auth()->guard('admin')->user()->id)->first();
                if(!$model){
                    $model = new Tutorial();
                    $model->user = auth()->guard('admin')->user()->id;
                }
                $model->tutorial = json_encode(isset($e['tutorials']) ? $e['tutorials'] : []);
                $model->timestamps = false;
                $model->save();

                session()->flash('success', trans('admin.alert.save'));
                return redirect()->route('throne.profil');
            }

            session()->flash('error', trans('admin.alert.haveError'));
        }

        $tutorial = Tutorial::where('user', auth()->guard('admin')->user()->id)->first();
        $tutorial['tutorial'] = json_decode($tutorial['tutorial'], true);

        View::share('tutorials', $tutorial['tutorial']);
        return $this->renderView('edit', $validator);
    }

    public function saveStep($name){
        $tutorials = [];
        $tutorial = Tutorial::where('user', auth()->guard('admin')->id())->first();

        if(!$tutorial){
            $tutorial = new Tutorial();
            $tutorial->user = auth()->guard('admin')->id();
        }else{
            $tutorials = json_decode($tutorial['tutorial'], true);
        }

        $tutorials[$name] = 'on';

        $tutorial->tutorial = json_encode($tutorials);
        $tutorial->timestamps = false;
        $tutorial->save();
    }
}
