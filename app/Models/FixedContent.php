<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class FixedContent extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'fixedcontent';
    public static $permissions = ['read', 'edit'];

    protected $table = 'fixed_content';

    public function isValid($e, $edit = null){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
        ];

        $validator = Validator::make($e,$rules,$messages);

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
            $model->lang = $e['lang'];
        }

        $model->title = json_encode($e['title']);
        $model->content = json_encode($e['content']);
        $model->seo_title = json_encode($e['seo_title']);
        $model->seo_keywords = json_encode($e['seo_keywords']);
        $model->seo_desc = json_encode($e['seo_desc']);
        $model->save();

        return $model;
    }
}