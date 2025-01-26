<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FormContent extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'form_content';
    public static $permissions = ['read', 'new', 'edit', 'delete'];
    public $validator = [];

    protected $table = 'form_content';
    public $lists = [
        'id',
        'created_at'
    ];

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'type' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('form', $e['form'])->where('type',$e['type'])->count();

            if(($edit && $result && $edit['type'] != $e['type']) || (!$edit && $result)){
                $validator->errors()->add('type', trans('admin.'.self::$name.'.alerts.have'));
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
            $model->form = $e['form'];
        }

        $model->subject = $e['subject'];
        $model->type = $e['type'];
        $model->emails = $e['emails'];
        $model->content = $e['content'];
        $model->save();

        return $model;
    }
}
