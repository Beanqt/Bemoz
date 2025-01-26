<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Redirects extends Model {
    use LogTrait;

    public static $name = 'redirects';
    public static $permissions = ['read', 'new', 'edit', 'delete'];

    protected $table = 'redirects';
    public $lists = [
        'old',
        'new',
    ];

    public static $validator = [];
    public static function isValid($e, $edit = null){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'old' => 'required',
            'new' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        if(!$validator->fails()){
            return true;
        }

        session()->flash('error', trans('admin.alert.haveError'));
        self::$validator = $validator;
        return false;
    }

    public static function saveData($e, $data = null){
        if($data){
            $model = self::find($data['id']);
        }else{
            $model = new self();
        }

        $model->old = $e['old'];
        $model->new = $e['new'];
        $model->save();

        Cache::forget('redirects');

        return $model;
    }
}
