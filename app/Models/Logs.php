<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;

class Logs extends Model {
    use SoftDeletes;

    public static $name = 'logs';
    public static $permissions = ['read'];

    public static $actions = [
        1 => 'New',
        2 => 'Edit',
        3 => 'Delete',
        4 => 'Status',
        5 => 'Sort',
        6 => 'Export',
        7 => 'DeleteForce',
        8 => 'DeleteRestore',
        9 => 'Featured',
        10 => 'Live',
    ];

    public static function saveData($e){
        $throne = Request::segment(1) == 'throne';

        if(!$throne){
            return false;
        }

        $e['data'] = is_array($e['data']) ? $e['data'] : $e['data'];

        $model = new self();
        $model->type = $e['type'];
        $model->element_id = $e['element_id'];
        $model->action = $e['action'];
        $model->user = auth()->guard('admin')->id();
        $model->data = $e['data'] ? json_encode($e['data']) : '';
        $model->save();

        return $model;
    }

    public static function getName($id){
        if(array_key_exists($id, self::$types)){
            $class = self::$types[$id];

            if(substr($class, 0, 3) == 'App' && isset($class::$name)){
                return trans('admin.'.$class::$name.'.title');
            }elseif(substr($class, 0, 7) == 'widget_'){
                return trans('admin.widget.'.str_replace('widget_', '', $class).'.title');
            }else{
                return trans('admin.logs.table.types.'.$class);
            }
        }

        return '-';
    }

    public function users(){
        return $this->belongsTo(Admins::class, 'user', 'id');
    }
}
