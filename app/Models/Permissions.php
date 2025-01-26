<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Permissions extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'permissions';
    public static $permissions = ['read', 'new', 'edit', 'delete'];
    public $validator = [];

    protected $table = 'permission';
    public $lists = [
        'title',
    ];

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required'),
        ];
        $rules = [
            'title' => 'required',
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('title',$e['title'])->count();

            if(($edit && $result && $edit['title'] != $e['title']) || (!$edit && $result)){
                $validator->errors()->add('title', trans('admin.'.self::$name.'.alerts.have'));
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
        if($data){
            $model = self::find($data['id']);
        }else{
            $model = new self();
        }
        $model->title = $e['title'];
        $model->permissions = json_encode(isset($e['permission']) ? $e['permission'] : []);
        $model->save();

        session()->flash('reload', true);
        return $model;
    }
}
