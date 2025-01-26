<?php namespace App\Http\Controllers\Throne;

use App\Http\Controllers\Api\MediaManagerController;
use App\Models\Video;
use App\Models\VideoGallery;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class VideoGalleryController extends MediaManagerController
{
    public $deleteCache = [
        'video_category_all',
        'video_category.{id}',
        'video_items.{id}',
        'video_category.folder.{boss}',
    ];

    public function __construct(VideoGallery $model){
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
        $files = Video::where('category', $this->boss[1])->orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        $this->getBreadCrumbs($this->boss[1], 'video');

        View::share('folders', $folders);
        View::share('files', $files);
        View::share('breadcrumbs', $this->breadcrumbs);

        View::share('trash', $this->model->onlyTrashed()->count());
        return $this->renderView('index');
    }

    public function create(Request $request) {
        $return['title'] = trans('admin.'.$this->default.'.new');

        if($request->isMethod('post')) {
            $e = request()->all();
            $e['boss'] = $this->boss[1];

            if($this->model->isValid($e)){
                $model = $this->model->saveData($e);

                $this->deleteCache($model);

                if($e['submit'] == 1){
                    $return['title'] = trans('admin.'.$this->default.'.edit');
                    View::share('edit', $model['id']);
                    View::share('data', $model);
                }elseif($e['submit'] != 3){
                    $return['close'] = true;
                }

                $return['message'] = ['type' => 'success', 'msg' => trans('admin.alert.save')];
                $return['type'] = 'folder';
                $return['item'] = view('throne.widgets.media_manager.video._folder_item')->with('folder', $model)->render();
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
        $category = $this->model->find($id);
        $return['title'] = trans('admin.'.$this->default.'.edit');
        $return['content'] = trans('admin.'.$this->default.'.alerts.not');

        if($category) {
            View::share('edit', $id);
            View::share('data', $category);

            if ($request->isMethod('post')) {
                $e = request()->all();
                $e['boss'] = $this->boss[1];

                if($this->model->isValid($e, $category)){
                    $model = $this->model->saveData($e, $category);

                    $this->deleteCache($model);

                    if($e['submit'] == 1){
                        View::share('data', $model);
                    }else {
                        $return['close'] = true;
                    }

                    $return['message'] = ['type' => 'success', 'msg' => trans('admin.alert.save')];
                    $return['element_id'] = $model['id'];
                    $return['type'] = 'folder';
                    $return['item'] = view('throne.widgets.media_manager.video._folder_item')->with('folder', $model)->render();
                }else{
                    $return['message'] = ['type' => 'error', 'msg' => trans('admin.alert.haveError')];
                    $e['image'] = $category['image'];
                    $e['image_crop'] = $category['image_crop'];
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
