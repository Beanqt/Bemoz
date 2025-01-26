<?php namespace App\Http\Controllers\Throne;

use App\Http\Controllers\Api\MediaManagerController;
use App\Models\Gallery;
use App\Models\Images;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class GalleryController extends MediaManagerController
{
    public $deleteCache = [
        'gallery_all',
        'gallery.{id}',
        'gallery_images.{id}',
        'gallery.folder.{boss}',
    ];

    public function __construct(Gallery $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->boss = ['boss', $this->getRouteParameter()];

        if(is_null($this->boss[1])){
            $this->boss[1] = 0;
        }

        View::share('boss', $this->boss[1]);
    }

    public function index() {
        $folders = $this->model->where('boss', $this->boss[1])->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        $files = Images::where('category', $this->boss[1])->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        $this->getBreadCrumbs($this->boss[1], 'gallery');

        View::share('folders', $folders);
        View::share('files', $files);
        View::share('breadcrumbs', $this->breadcrumbs);

        View::share('trash', $this->model->onlyTrashed()->count());
        return $this->renderView('index');
    }

    public function create(Request $request) {
        $return['title'] = trans('admin.gallery.new');

        if($request->isMethod('post')) {
            $e = request()->all();
            $e['boss'] = $this->boss[1];

            if($this->model->isValid($e)){
                $model = $this->model->saveData($e);

                $this->deleteCache($model);

                if($e['submit'] == 1){
                    $return['title'] = trans('admin.gallery.edit');
                    View::share('edit', $model['id']);
                    View::share('data', $model);
                }elseif($e['submit'] != 3){
                    $return['close'] = true;
                }

                $return['message'] = ['type' => 'success', 'msg' => trans('admin.alert.save')];
                $return['type'] = 'folder';
                $return['item'] = view('throne.widgets.media_manager.gallery._folder_item')->with('folder', $model)->render();
            }else{
                $return['message'] = ['type' => 'error', 'msg' => trans('admin.alert.haveError')];
                unset($e['image']);
                View::share('data', $e);
            }
        }

        if(!isset($return['close'])){
            $return['content'] = view('throne.layouts.'.$this->default.'.form')->with('boss', $this->boss[1])->withErrors($this->model->validator)->render();
        }

        return $return;
    }

    public function edit(Request $request) {
        $id = $this->getRouteParameter('id');
        $gallery = $this->model->find($id);
        $return['title'] = trans('admin.gallery.edit');
        $return['content'] = trans('admin.gallery.alerts.not');

        if($gallery) {
            View::share('edit', $id);
            View::share('data', $gallery);

            if($request->isMethod('post')) {
                $e = request()->all();
                $e['boss'] = $this->boss[1];

                if($this->model->isValid($e, $gallery)){
                    $model = $this->model->saveData($e, $gallery);

                    $this->deleteCache($model);

                    if($e['submit'] == 1){
                        View::share('data', $model);
                    }else {
                        $return['close'] = true;
                    }

                    $return['message'] = ['type' => 'success', 'msg' => trans('admin.alert.save')];
                    $return['element_id'] = $model['id'];
                    $return['type'] = 'folder';
                    $return['item'] = view('throne.widgets.media_manager.gallery._folder_item')->with('folder', $model)->render();
                }else{
                    $return['message'] = ['type' => 'error', 'msg' => trans('admin.alert.haveError')];
                    $e['image'] = $gallery['image'];
                    $e['image_crop'] = $gallery['image_crop'];
                    View::share('data', $e);
                }
            }

            if(!isset($return['close'])){
                $return['content'] = view('throne.layouts.'.$this->default.'.form')->with('boss', $this->boss[1])->withErrors($this->model->validator)->render();
            }
        }

        return $return;
    }
}
