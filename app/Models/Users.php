<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class Users extends Model implements AuthenticatableContract {
    use Authenticatable;
    use SoftDeletes;
    use LogTrait;

    public static $name = 'users';
    public static $permissions = ['read', 'new', 'edit', 'export', 'delete'];
    public $validator = [];

    protected $table = 'users';

    public function isValid($e, $edit = false){
        $throne = Request::segment(1) == 'throne';

        $messages = [
            'required' => trans('public.alerts.required'),
            'email' => trans('public.alerts.email'),
            'regex' => trans('public.alerts.regex'),
            'min' => trans('public.alerts.min'),
            'aszf.required' => trans('public.alerts.aszf'),
        ];
        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'regex:/^06+[0-9]{9}$/',
        ];

        if($throne){
            $rules['group'] = 'required';
        }else{
            $rules['aszf'] = 'required';
        }
        if(!$edit){
            $rules['password'] = 'required|confirmed|regex:/^[a-zA-Z0-9]{5,16}$/';
            $rules['password_confirmation'] = 'required';
        }else{
            $rules['password'] = 'confirmed|regex:/^[a-zA-Z0-9]{5,16}$/';
        }

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('email', $e['email'])->count();

            if(($edit && $result && $edit['email'] != $e['email']) || (!$edit && $result)){
                $validator->errors()->add('email', trans('public.alerts.unique'));
            }
        });

        if(!$validator->fails()){
            return true;
        }

        session()->flash('error', trans('admin.alert.haveError'));
        $this->validator = $validator;
        return false;
    }

    public function saveData($e, $data = null){
        $throne = Request::segment(1) == 'throne';

        if($data){
            $model = self::find($data['id']);
        }else{
            $model = new self();
            $model->active = 1;
            $model->hash = sha1($e['email'].time());
        }

        $model->name = $e['name'];
        $model->email = $e['email'];
        $model->phone = isset($e['phone']) ? $e['phone'] : '';
        $model->group = isset($e['group']) ? $e['group'] : 1;
        $model->newsletter = isset($e['newsletter']) ? 1 : 0;
        if(!empty($e['password'])){
            $model->password = bcrypt($e['password']);
        }
        $model->save();

        if($throne && isset($e['send_email']) && !empty($e['password'])){
            Emails::find(2)->data($e)->template('default')->send($model['email']);
        }

        if(isset($e['newsletter'])){
            $postdata = http_build_query([
                'name' => $e['name'],
                'email' => $e['email'],
                'list' => '',
                'referrer' => url()->full(),
                'gdpr' => 'true',
                'boolean' => true
            ]);

            $opts = ['http' => ['method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata]];
            $context = stream_context_create($opts);
            @file_get_contents(config('app.sendy').'/subscribe', false, $context);
        }

        return $model;
    }
}
