<?php namespace App\Http\Controllers\Throne;

use App\Http\Controllers\Api\MediaManagerController;
use App\Models\Video;
use App\Models\VideoGallery;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class VideoController extends MediaManagerController
{
    public $deleteCache = [
        'video.{id}',
        'video_items.{category}',
    ];

    public function __construct(Video $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->boss = ['boss', $this->getRouteParameter()];

        View::share('boss', $this->boss[1]);
    }

    public function create(Request $request) {
        $folder = VideoGallery::find($this->boss[1]);
        $return['title'] = trans('admin.'.$this->default.'.new');
        $return['content'] = trans('admin.videocategory.alerts.not');

        if($folder || $this->boss[1] == 0) {
            if ($request->isMethod('post')) {
                $e = request()->all();
                $e['boss'] = $this->boss[1];

                if($this->model->isValid($e)){
                    $model = $this->model->saveData($e);
                    $model['active'] = 0;

                    if($e['submit'] == 1){
                        $return['title'] = trans('admin.'.$this->default.'.edit');
                        View::share('edit', $model['id']);
                        View::share('data', $model);
                    }elseif($e['submit'] != 3){
                        $return['close'] = true;
                    }

                    $return['message'] = ['type' => 'success', 'msg' => trans('admin.alert.save')];
                    $return['type'] = 'file';
                    $return['item'] = view('throne.widgets.media_manager.video._item')->with('item', $model)->render();
                }else{
                    $return['message'] = ['type' => 'error', 'msg' => trans('admin.alert.haveError')];
                    unset($e['image']);
                    View::share('data', $e);
                }
            }

            if(!isset($return['close'])){
                $return['content'] = view('throne.layouts.'.$this->default.'.form')->with('boss', $this->boss[1])->withErrors($this->model->validator)->render();
            }
        }

        return $return;
    }

    public function edit(Request $request) {
        $id = $this->getRouteParameter('id');
        $folder = VideoGallery::find($this->boss[1]);
        $return['title'] = trans('admin.'.$this->default.'.edit');
        $return['content'] = trans('admin.videocategory.alerts.not');

        if($folder || $this->boss[1] == 0) {
            $document = $this->model->find($id);
            $return['content'] = trans('admin.'.$this->default.'.alerts.not');

            if($document){
                if($document['type'] == 4){
                    $document['gif'] = $document['video_id'];
                }elseif($document['type'] == 5){
                    $document['sound'] = $document['video_id'];
                }

                View::share('edit', $id);
                View::share('data', $document);

                if ($request->isMethod('post')) {
                    $e = request()->all();
                    $e['boss'] = $this->boss[1];

                    if($this->model->isValid($e, $document)){
                        $model = $this->model->saveData($e, $document);

                        $this->deleteCache($model);

                        if($e['submit'] == 1){
                            if($model['type'] == 4){
                                $model['gif'] = $model['video_id'];
                            }elseif($document['type'] == 5){
                                $model['sound'] = $model['video_id'];
                            }

                            View::share('data', $model);
                        }else {
                            $return['close'] = true;
                        }

                        $return['message'] = ['type' => 'success', 'msg' => trans('admin.alert.save')];
                        $return['element_id'] = $model['id'];
                        $return['type'] = 'file';
                        $return['item'] = view('throne.widgets.media_manager.video._item')->with('item', $model)->render();
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
