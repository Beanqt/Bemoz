<?php namespace App\Http\Controllers\Throne;

use App\Models\Admins;
use App\Models\Permissions;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct(Admins $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->query = function($sql){
            return $sql->with('permissions');
        };
    }

    public function creation() {
        View::share('permissions', Permissions::get());
    }

    public function update() {
        View::share('permissions', Permissions::get());
    }

    public function ban($id){
        $model = $this->model->find($id);
        $model->wrong = 0;
        $model->ban = null;
        $model->save();

        session()->flash('success',trans('admin.admins.alerts.ban'));
        return redirect()->route('throne.'.$this->default);
    }
}
