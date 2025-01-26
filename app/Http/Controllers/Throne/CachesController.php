<?php namespace App\Http\Controllers\Throne;

use App\Models\Cache;
use Illuminate\Support\Facades\View;

class CachesController extends Controller
{
    public function __construct(Cache $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->dir = $model::$dir;
    }

    public function index(){
        $keys = [];

        foreach(glob(storage_path($this->dir).'*') as $file) {
            $name = str_replace(storage_path($this->dir), '', $file);
            $keys[] = [
                'key' => $name,
                'created_at' => date('Y-m-d H:i:s', filemtime($file)),
            ];
        }

        View::share($this->default, $keys);
        return $this->renderView('index');
    }

    public function delete(){
        $id = $this->getRouteParameter('id');

        if(file_exists(storage_path($this->dir.$id))){
            unlink(storage_path($this->dir.$id));
        }

        session()->flash('success', trans('admin.alert.delete'));
        return redirect()->route('throne.'.$this->default, isset($this->boss) ? $this->boss[1] : []);
    }
}