<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Validator;

class Forms extends Model {
    use SoftDeletes;
    use LogTrait;

    public static $name = 'forms';
    public static $permissions = ['read', 'new', 'edit', 'delete', 'trash'];
    public $validator = [];

    protected $table = 'forms';
    public $inputs = [];
    public $files = [];
    public $lists = [
        'id',
        'title',
    ];

    public function isValid($e, $edit = false){
        $messages = [
            'required' => trans('admin.alert.required')
        ];
        $rules = [
            'title' => 'required'
        ];

        $validator = Validator::make($e,$rules,$messages);

        $validator->after(function ($validator) use($edit, $e) {
            $result = self::where('title', $e['title'])->where('lang',$e['lang'])->count();

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
            $model->lang = $e['lang'];
        }
        $e['data'] = ['option' => (isset($e['option']) ? $e['option'] : []), 'json' => json_decode($e['json'], true)];
        $model->title = $e['title'];
        if($data && !$data['live']) {
            $model->data = json_encode($e['data']);
        }elseif(is_null($data)){
            $model->data = json_encode($e['data']);
        }
        $model->save();

        return $model;
    }
    
    public function getInputs($data, $without = []){
        foreach($data as $item){
            if(isset($item['grids'])){
                if(isset($item['grids'][0]['grid'])){
                    $this->getInputs($item['grids'][0]['grid']);
                }
                if(isset($item['grids'][1]['grid'])){
                    $this->getInputs($item['grids'][1]['grid']);
                }
            }elseif(!count($without) || (!in_array($item['type'], $without))){
                if($item['type'] == 'file'){
                    $this->files[$item['name']] = $item;
                }elseif(isset($item['name'])) {
                    $this->inputs[$item['name']] = $item;
                }
            }
        }
    }

    public function hasFileInput(){
        return !empty($this->files);
    }

    public function replaceValue($value, $input){
        if(isset($input['options']) && array_key_exists($value, $input['options'])){
            return $input['options'][$value]['title'];
        }

        return $value;
    }

    public function scopeLang($query) {
        return $query->where('lang', app('LanguageService')->getLangId());
    }

    public function scopePublic($query) {
        return $query->where('active', 1)->where('live', 1);
    }

    public function users() {
        return $this->hasMany(FormUsers::class, 'form', 'id');
    }
}
