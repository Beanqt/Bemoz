<?php namespace App\Http\Controllers\Throne;

use App\Models\Users;

class UsersController extends Controller
{
    public function __construct(Users $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->set_stats = [
            'reg' => function($sql){
                return $sql->count();
            },
            'login_now' => function($sql){
                return $sql->whereRaw('DATE(last_login) = "'.date('Y-m-d').'"')->count();
            },
        ];
        $this->export = [
            'name' => 'users',
            'columns' => ['id','name','email','phone','newsletter','last_login','created_at'],
        ];
    }
}