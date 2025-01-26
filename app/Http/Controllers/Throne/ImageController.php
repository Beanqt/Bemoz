<?php namespace App\Http\Controllers\Throne;

use App\Http\Controllers\Api\MediaManagerController;
use App\Models\Gallery;
use App\Models\Images;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class ImageController extends MediaManagerController
{
    public $deleteCache = [
        'gallery_images.{category}',
        'images.{id}',
    ];

    public function __construct(Images $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->boss = ['boss', $this->getRouteParameter()];

        View::share('boss', $this->boss[1]);
    }

    public function edit(Request $request) {
        $id = $this->getRouteParameter('id');
        $folder = Gallery::find($this->boss[1]);
        $return['title'] = trans('admin.'.$this->default.'.edit');
        $return['content'] = trans('admin.gallery.alerts.not');

        if($folder || $this->boss[1] == 0) {
            $document = $this->model->find($id);
            $return['content'] = trans('admin.'.$this->default.'.alerts.not');

            if($document){
                View::share('edit', $id);
                View::share('data', $document);

                if ($request->isMethod('post')) {
                    $e = request()->all();
                    $e['boss'] = $this->boss[1];

                    if($this->model->isValid($e, $document)){
                        $model = $this->model->saveData($e, $document);

                        $this->deleteCache($model);

                        if($e['submit'] == 1){
                            View::share('data', $model);
                        }else {
                            $return['close'] = true;
                        }

                        $return['message'] = ['type' => 'success', 'msg' => trans('admin.alert.save')];
                        $return['element_id'] = $model['id'];
                        $return['type'] = 'file';
                        $return['item'] = view('throne.widgets.media_manager.gallery._item')->with('item', $model)->render();
                    }else{
                        $return['message'] = ['type' => 'error', 'msg' => trans('admin.alert.haveError')];
                        $e['image'] = $document['image'];
                        $e['image_crop'] = $document['image_crop'];
                        View::share('data', $e);
                    }
                }

                if(!isset($return['close'])){
                    $return['content'] = view('throne.layouts.'.$this->default.'.form')->withErrors($this->model->validator)->render();
                }
            }
        }

        return $return;
    }
}
