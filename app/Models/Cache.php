<?php namespace App\Models;

class Cache
{
    public static $name = 'caches';
    //public static $permissions = ['read'];
    public static $loaded = [];
    public static $dir = 'framework/cache/custom/';

    public $lists = [
        'key',
        'created_at',
    ];

    public static function has($key){
        if(file_exists(storage_path(self::$dir).$key.'.txt')){
            return true;
        }
        return false;
    }

    public static function getTime($key){
        return filemtime(storage_path(self::$dir).$key.'.txt');
    }

    public static function save($key, $value){
        $value = serialize($value);
        if(!file_exists(storage_path(self::$dir))){
            mkdir(storage_path(self::$dir), 0777, true);
        }
        file_put_contents(storage_path(self::$dir).$key.'.txt', $value);
    }

    public static function get($key){
        if(array_key_exists($key, self::$loaded)){
            return self::$loaded[$key];
        }else{
            return unserialize(file_get_contents(storage_path(self::$dir).$key.'.txt'));
        }
    }

    public static function remember($key, $time, $value){
        $dir = storage_path(self::$dir);

        if(file_exists($dir.$key.'.txt') && (time()-self::getTime($key))/60 < $time){
            return self::get($key);
        }else{
            $value = call_user_func($value);

            self::save($key, $value);
            return $value;
        }
    }

    public static function rememberForever($key, $value){
        if(file_exists(storage_path(self::$dir).$key.'.txt')){
            return self::get($key);
        }else{
            if(is_callable($value)){
                $value = call_user_func($value);
            }

            self::save($key, $value);
            return $value;
        }
    }

    public static function forget($key, $all = false){
        if(!$all && !is_array($key) && file_exists(storage_path(self::$dir).$key.'.txt')){
            unlink(storage_path(self::$dir).$key.'.txt');
        }elseif(is_array($key)){
            foreach($key[1] as $item){
                if(file_exists(storage_path(self::$dir).$key[0].$item.'.txt')){
                    unlink(storage_path(self::$dir).$key[0].$item.'.txt');
                }
            }
        }elseif($all){
            foreach(glob(storage_path(self::$dir).$key.'.txt') as $file){
                $name = str_replace(storage_path(self::$dir), '', $file);
                unlink(storage_path(self::$dir).$name);
            }
        }
    }
}
