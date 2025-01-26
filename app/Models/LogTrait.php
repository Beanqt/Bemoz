<?php namespace App\Models;

trait LogTrait {
    public static function bootLogTrait() {
        static::created(function ($item) {
            Logs::saveData([
                'type' => self::$name == 'widget' ? 'widget_'.$item->type : self::$name,
                'element_id' => $item->id,
                'action' => 1,
                'data' => $item
            ]);
        });

        static::updated(function($item) {
            if(isset($item->exception_update_event)){
                foreach($item->exception_update_event as $name){
                    if($item->isDirty($name)){
                        return false;
                    }
                }
            }

            if($item->isDirty('order')){
                return false;
            }

            if($item->isDirty('active')){
                $action = 4;
            }elseif($item->isDirty('featured')){
                $action = 9;
            }elseif($item->isDirty('live')){
                $action = 10;
            }else{
                $action = 2;
            }

            Logs::saveData([
                'type' => self::$name == 'widget' ? 'widget_'.$item->type : self::$name,
                'element_id' => $item->id,
                'action' => $action,
                'data' => $action == 2 ? $item : ''
            ]);
        });

        static::deleted(function ($item) {
            if(method_exists($item, 'isForceDeleting') && $item->isForceDeleting()) {
                $action = 7;
            }else {
                $action = 3;
            }

            Logs::saveData([
                'type' => self::$name == 'widget' ? 'widget_'.$item->type : self::$name,
                'element_id' => $item->id,
                'action' => $action,
                'data' => $action == 7 ? $item : ''
            ]);
        });

        if(in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses(self::class))){
            static::restored(function ($item) {
                Logs::saveData([
                    'type' => self::$name == 'widget' ? 'widget_'.$item->type : self::$name,
                    'element_id' => $item->id,
                    'action' => 8,
                    'data' => $item
                ]);
            });
        }
    }
}
