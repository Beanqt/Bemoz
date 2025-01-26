<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class FormUsers extends Model {
    use SoftDeletes;

    public static $name = 'form_users';
    public static $permissions = ['read', 'show', 'export', 'delete'];

    protected $table = 'form_users';
    public static $allowed_input = [];
    public static $rules = [];
    public static $files = [];
    public static $email = null;
    public $lists = [
        'id',
        'page',
        'created_at',
    ];

    public static $validator = [];
    public static function isValid($form){
        $e = request()->all();
        $unique = false;

        $messages = [
            'required' => trans('public.alerts.required'),
            'email' => trans('public.alerts.email'),
            'min' => trans('public.alerts.min'),
            'max' => trans('public.alerts.max'),
            'numeric' => trans('public.alerts.numeric'),
            'regex' => trans('public.alerts.regex'),
        ];

        self::checkInput($form['json']);

        if(isset(self::$rules['unique-item'])){
            $unique = self::$rules['unique-item'];
            unset(self::$rules['unique-item']);
        }

        $validator = Validator::make($e,self::$rules,$messages);

        if($unique){
            $validator->after(function ($validator) use($form, $e, $unique) {
                $result = self::where('form', $form['id'])->where('data', 'LIKE', '%'.$e[$unique].'%')->count();

                if($result) {
                    $validator->errors()->add($unique, trans('public.alerts.unique'));
                }
            });
        }

        if(!empty(self::$files)){
            $validator->after(function ($validator) {
                foreach(self::$files as $key => $item){
                    $files = request()->file($item['name']);
                    $item['max_size'] = (isset($item['max_size']) && !empty($item['max_size']) ? $item['max_size'] : 3)*1024*1024;
                    $item['max'] = isset($item['max']) && !empty($item['max']) ? $item['max'] : 1;
                    $item['extension'] = isset($item['extension']) && !empty($item['extension']) ? explode(',',$item['extension']) : ['jpg','png','doc','pdf'];

                    if(is_array($files) && $item['max'] < count($files)){
                        $validator->errors()->add($item['name'], trans('public.alerts.max_file', ['s' => $item['max']]));
                    }elseif(is_array($files)){
                        foreach($files as $file) {
                            if(!in_array(strtolower($file->getClientOriginalExtension()), $item['extension'])){
                                $validator->errors()->add($item['name'], trans('public.alerts.mimes'));
                                break;
                            }elseif($item['max_size'] < $file->getSize()){
                                $validator->errors()->add($item['name'], trans('public.alerts.max_filesize', ['s' => $item['max_size']/1024/1024]));
                                break;
                            }
                        }
                    }elseif($files){
                        if(!in_array(strtolower($files->getClientOriginalExtension()), $item['extension'])){
                            $validator->errors()->add($item['name'], trans('public.alerts.mimes'));
                        }elseif($item['max_size'] < $files->getSize()){
                            $validator->errors()->add($item['name'], trans('public.alerts.max_filesize', ['s' => $item['max_size']/1024/1024]));
                        }
                    }
                }
            });
        }

        if(!$validator->fails()){
            return true;
        }

        self::$validator = $validator;
        return false;
    }

    public static function checkInput($data){
        foreach($data as $item){
            if(isset($item['grids'])){
                if(isset($item['grids'][0]['grid'])){
                    self::checkInput($item['grids'][0]['grid']);
                }
                if(isset($item['grids'][1]['grid'])){
                    self::checkInput($item['grids'][1]['grid']);
                }
            }else{
                if(isset($item['name']) && request()->get($item['name'])) {
                    self::$allowed_input[$item['name']] = request()->get($item['name']);

                    if($item['type'] == 'email' && is_null(self::$email)){
                        self::$email = self::$allowed_input[$item['name']];
                    }
                }
                if(isset($item['required']) && $item['required']) {
                    self::$rules[$item['name']] = 'required';
                }
                if($item['type'] == 'email') {
                    self::$rules[$item['name']] = isset(self::$rules[$item['name']]) ? self::$rules[$item['name']].'|email' : 'email';

                    if(isset($item['unique']) && $item['unique']){
                        self::$rules['unique-item'] = $item['name'];
                    }
                }
                if($item['type'] == 'file') {
                    self::$files[$item['name']] = $item;
                }
                if($item['type'] == 'number') {
                    self::$rules[$item['name']] = isset(self::$rules[$item['name']]) ? self::$rules[$item['name']].'|numeric' : 'numeric';
                }
                if($item['type'] == 'range') {
                    self::$rules[$item['name']] = isset(self::$rules[$item['name']]) ? self::$rules[$item['name']].'|numeric' : 'numeric';
                }
                if(isset($item['date']) && !empty($item['date'])) {
                    $item['date'] = str_replace(['YYYY','MM','DD','HH','II','SS'],['Y','m','d','H','i','s'], $item['date']);
                    self::$rules[$item['name']] = isset(self::$rules[$item['name']]) ? self::$rules[$item['name']].'|date_format:'.$item['date'] : 'date_format:'.$item['date'];
                }
                if(isset($item['min']) && !empty($item['min'])) {
                    self::$rules[$item['name']] = isset(self::$rules[$item['name']]) ? self::$rules[$item['name']].'|min:'.$item['min'] : 'min:'.$item['min'];
                }
                if(isset($item['max']) && !empty($item['max']) && $item['type'] != 'file') {
                    self::$rules[$item['name']] = isset(self::$rules[$item['name']]) ? self::$rules[$item['name']].'|max:'.$item['max'] : 'max:'.$item['max'];
                }
                if(isset($item['regex']) && !empty($item['regex'])) {
                    self::$rules[$item['name']] = isset(self::$rules[$item['name']]) ? self::$rules[$item['name']].'|regex:/'.$item['regex'].'/' : 'regex:/'.$item['regex'].'/';
                }
            }
        }
    }

    public static function saveData($form = null){
        $model = new self();
        $model->page = str_replace(url('/'), '', URL::previous());
        $model->form = $form['id'];
        $model->data = json_encode(self::$allowed_input);
        $model->save();

        $names = [];

        foreach(self::$files as $key => $item) {
            $files = request()->file($item['name']);
            if(is_array($files)){
                foreach($files as $file) {
                    $name = microtime(true).'.'.$file->getClientOriginalExtension();
                    $file->move(storage_path('form_users/'.$model->id), $name);
                    $names[] = $name;
                }
            }elseif($files){
                $name = microtime(true).'.'.$files->getClientOriginalExtension();
                $files->move(storage_path('form_users/'.$model->id), $name);
                $names[] = $name;
            }
        }

        $data = json_decode($model->data, true);
        $data['files'] = $names;
        $model->data = json_encode($data);
        $model->save();

        if(isset($form['data']['option']['sendy']) && !empty($form['data']['option']['sendy']) && !is_null(self::$email)){
            $array = [
                'email' => self::$email,
                'list' => $form['data']['option']['sendy'],
                'referrer' => url()->previous(),
                'gdpr' => 'true',
                'boolean' => 'true'
            ];

            foreach(self::$allowed_input as $key => $item){
                $array[$key] = $item;
            }

            $postdata = http_build_query($array);

            $opts = ['http' => ['method' => 'POST', 'header' => 'Content-type: application/x-www-form-urlencoded', 'content' => $postdata]];
            $context = stream_context_create($opts);
            @file_get_contents(config('app.sendy').'/subscribe', false, $context);
        }

        return $model;
    }
}
