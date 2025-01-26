<?php namespace App\Http\Controllers\Throne;

use App\Models\Permissions;
use Illuminate\Support\Facades\View;

class PermissionController extends Controller 
{
    public function __construct(Permissions $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->edit = function($data){
            $data['permission'] = json_decode($data['permissions'], true);
        };
    }

    public function creation(){
        View::share('permissions', $this->getPermissions());
    }

    public function update(){
        View::share('permissions', $this->getPermissions());
    }

    public function getPermissions(){
        $files = glob(base_path('app/Models/*'));

        $permissions = [];
        foreach($files as $file){
            $class = str_replace([base_path('a'), '.php', '/'], ['A','','\\'], $file);

            if(isset($class::$name, $class::$permissions)){
                $permissions[$class::$name] = $class::$permissions;
            }
        }

        return $permissions;
    }
}
