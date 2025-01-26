<?php namespace App\Http\Controllers\Throne;

use App\Models\Admins;
use App\Models\Logs;
use Illuminate\Support\Facades\View;

class LogsController extends Controller
{
    public $default = 'logs';

    public function __construct(Logs $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->check_exception = ['name'];
        $this->check = function($sql, $e){
            if(isset($e['name']) && !empty($e['name'])){
                $users = Admins::where('name', 'LIKE', '%'.$e['name'].'%')->pluck('id')->all();
                $sql->whereIn('user', $users);
            }
        };
        $this->query = function($sql){
            return $sql->with('users');
        };
    }

    public function lists(){
        View::share('types', $this->model->groupBy('type')->pluck('type')->all());
        View::share('actions', $this->model->groupBy('action')->pluck('action')->all());
    }
}