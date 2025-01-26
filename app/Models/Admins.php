<?php namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Admins extends Model implements AuthenticatableContract {
    use Authenticatable;
    use SoftDeletes;
    use LogTrait;

    public static $name = 'admins';
    public static $permissions = ['read', 'new', 'edit', 'delete'];
    public $validator = [];

    protected $table = 'admins';
    public $permission = [];
    private $exception_update_event = [
        'remember_token'
    ];

    public function permissions(){
        return $this->belongsTo(Permissions::class, 'group', 'id');
    }

    public function loadPermission(){
        $group = Permissions::find($this->group);
        if($group) {
            $this->permission = json_decode($group['permissions'], true);
        }
    }

    public function havePermission($permission = null){
        if(!count($this->permission)){
            $this->loadPermission();
        }

        $return = false;
        if($permission){
            $permission = explode('.', $permission);
            if(isset($this->permission[$permission[0]][$permission[1]])){
                $return = true;
            }
        }
        return $return;
    }

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required'),
            'email' => trans('admin.alert.email'),
            'min' => trans('admin.alert.min', ['c' => 5]),
            'regex' => trans('admin.alert.password_regex'),
            'password.confirmed' => trans('admin.alert.password_confirmed'),
        ];
        $rules = [
            'name' => 'required',
            'group' => 'required'
        ];

        if(!$edit) {
            $rules['email'] = 'required|email';
            $rules['password'] = 'required|min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).[A-Za-z0-9%_]{5,}$/|confirmed';
            $rules['password_confirmation'] = 'required|min:5';
        }else{
            $rules['email'] = 'required|email';
            $rules['password'] = 'min:5|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9]).[A-Za-z0-9%_]{5,}$/|confirmed';
        }

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('email', $e['email'])->count();

            if(($edit && $result && $edit['email'] != $e['email']) || (!$edit && $result)){
                $validator->errors()->add('email', trans('admin.'.self::$name.'.alerts.exists'));
            }
        });

        if(!$validator->fails()){
            return true;
        }

        session()->flash('error', trans('admin.alert.haveError'));
        $this->validator = $validator;
        return false;
    }

    public static function saveData($e, $data = null){
        if($data){
            $model = self::find($data['id']);
        }else{
            $model = new self();
            $model->first_login = isset($e['first_login']) ? 1 : 0;
            $model->tutorial = isset($e['tutorial']) ? 1 : 0;
        }
        $model->name = $e['name'];
        $model->group = $e['group'];
        $model->email = $e['email'];

        if(!empty($e['password'])) {
            $model->password = bcrypt($e['password']);
        }

        $model->save();

        if(isset($e['send_email'])){
            $e['link'] = route('throne.login');
            $e['data'] = trans('admin.admins.data.emailData', ['link'=>route('throne.login'), 'email'=>$e['email'], 'password' => $e['password']]);

            $cron['template'] = 'emails.throne';
            $cron['send'] = $e['email'];
            $cron['subject'] = trans('admin.admins.data.subject');
            $cron['data'] = $e;

            Cron::saveData(1, $cron);
        }

        return $model;
    }

    public function getTutorial(){
        return $this->belongsTo(Tutorial::class, 'id', 'user');
    }
}
