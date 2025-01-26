<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Input;

class Settings extends Model {
    use LogTrait;

    public static $name = 'settings';
    public static $permissions = ['edit'];

    protected $table = 'pageoption';
    public static $allowKeys = [
        'seo' => [
            'title',
            'keywords',
            'desc',
        ],
        'social' => [
            'facebook',
            'youtube',
            'instagram',
            'linkedin',
            'google',
            'twitter',
        ],
        'cookie' => [
            'title',
            'desc',
            'btn',
            'link',
            'ok',
        ],
        'ga',
        'gtm',
        'ga4',
        'pixel',
        'javascript',
        'service',
        'upload_image',
        'upload_document',
        'upload_video',
        'map',
    ];

    public static function saveData(){
        $e = request()->all();

        if(isset($e['data']['javascript'])){
            $e['data']['javascript'] = preg_replace('/<script.*?>/', '', $e['data']['javascript']);
            $e['data']['javascript'] = preg_replace('/<\/script>/', '', $e['data']['javascript']);
        }

        foreach($e['data'] as $key => $data){
            if(array_key_exists($key, self::$allowKeys)){
                $array = [];
                foreach($data as $name => $item){
                    if(is_array($item)){
                        $sub_array = [];
                        foreach($item as $element_key => $element){
                            $sub_array[$element_key] = $element;
                            Cache::forget('settings_'.$key.'.'.$element_key.$name);
                        }

                        Cache::forget('settings_'.$key.$name);
                        self::saveOption($key, json_encode($sub_array), $name);
                    }else{
                        if(in_array($name, self::$allowKeys[$key])){
                            $array[$name] = $item;
                            Cache::forget('settings_'.$key.'.'.$name);
                        }
                    }
                }
                if(!empty($array)) {
                    Cache::forget('settings_'.$key);
                    self::saveOption($key, json_encode($array));
                }
            }elseif(in_array($key, self::$allowKeys)){
                self::saveOption($key, $data);
                Cache::forget('settings_'.$key);
            }
        }
    }

    public static function saveOption($key, $data, $lang = 0){
        $model = self::where('name', $key)->where('lang', $lang)->first();
        if(!$model){
            $model = new self();
            $model->name = $key;
            $model->lang = $lang;
        }
        $model->timestamps = false;
        $model->value = $data;
        $model->save();
    }
}
