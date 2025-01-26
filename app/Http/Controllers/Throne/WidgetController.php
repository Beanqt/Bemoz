<?php namespace App\Http\Controllers\Throne;

use App\Http\Controllers\Slim\Slim;
use App\Models\Widget;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class WidgetController extends Controller
{
    public $widget;

    public function __construct(Widget $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->id = $this->getRouteParameter('id');

        $this->getLang();
    }

    public function create(Request $request) {
        $validator = [];
        if ($request->isMethod('post')) {
            $e = request()->all();

            $messages = [
                'required' => trans('admin.alert.required'),
            ];
            $rules = [
                'title' => 'required',
                'type' => 'required',
            ];

            $validator = Validator::make($e,$rules,$messages);

            if(!$validator->fails()) {
                $model = new Widget();
                $model->lang = $this->lang;
                $model->title = $e['title'];
                $model->type = $e['type'];
                $model->save();

                session()->flash('change_url', route('throne.' . $this->default . '.edit', $model->id));
                return redirect()->route('throne.' . $this->default . '.edit', $model->id);
            }
            View::share('data', $e);
        }

        return $this->renderView('new', $validator);
    }

    public function edit(Request $request) {
        $data = $this->model->find($this->id);
        if($data) {
            $array = json_decode($data['data'], true);
            $data['data'] = isset($array['data']) ? $array['data'] : [];
            $data['option'] = isset($array['option']) ? $array['option'] : [];
            $data['style'] = isset($array['style']) ? $array['style'] : [];

            if ($request->isMethod('post')) {
                $e = request()->all();

                $messages = [
                    'required' => trans('admin.alert.required'),
                ];
                $rules = [
                    'title' => 'required',
                ];

                $validator = Validator::make($e,$rules,$messages);

                if(!$validator->fails()) {
                    $e['data'] = isset($e['data']) ? json_decode($e['data'], true) : [];

                    if(in_array($data['type'], ['box_list','category','parallax','map','counter'])){
                        $e = $this->checkImages($e, $data, $data['type']);
                    }

                    $array['data'] = $e['data'];
                    $array['option'] = isset($e['option']) ? $e['option'] : [];
                    $array['style'] = isset($e['style']) ? $e['style'] : [];

                    $model = $this->model->find($this->id);
                    $model->title = $e['title'];
                    $model->data = json_encode($array);
                    $model->save();

                    return $this->checkRedirect($e['submit'], $model->id);
                }

                $e['data'] = isset($e['data']) ? json_decode($e['data'], true) : [];
                View::share('data', $e);
            }
            $elements = null;

            View::share('elements', $elements);
            View::share('edit', $this->id);
            View::share('widget', $data['type']);
            View::share('data', $data);

            return $this->renderView('edit');
        }

        return request()->ajax() ? response(trans('admin.ajax.error'), 400) : redirect()->route('throne.'.$this->default);
    }

    public function checkImages($e, $edit, $widget){
        if(isset($e['option']['slim']) || isset($e['style']['slim'])){
            $type = isset($e['option']['slim']) ? 'option' : 'style';

            $image = new Slim($e[$type]['slim'], false);

            if($image->hasImage()){
                $image->save('widget/'.$widget);
                $e[$type]['image'] = $image->getName();
                $e[$type]['image_crop'] = $image->getCrop();

                if(isset($edit[$type]['image']) && !empty($edit[$type]['image'])){
                    $image->remove('widget/'.$widget, $edit[$type]['image']);
                }
            }else{
                if(isset($edit[$type]['image']) && isset($edit[$type]['image_crop'])) {
                    $e[$type]['image'] = $edit[$type]['image'];
                    $e[$type]['image_crop'] = $edit[$type]['image_crop'];
                }
            }

            if(isset($e['removeImage']) && $e['removeImage']==1){
                if(isset($edit[$type]['image']) && !empty($edit[$type]['image'])){
                    $image->remove('widget/'.$widget, $edit[$type]['image']);
                }
                $e[$type]['image'] = '';
                $e[$type]['image_crop'] = '';
            }
            unset($e[$type]['slim']);
        }

        foreach($e['data'] as $key => $item){
            if(isset($item['slim'])){
                $image = new Slim($item['slim'], false);

                if($image->hasImage()){
                    if(isset($e['data'][$key]['image']) && !empty($e['data'][$key]['image'])){
                        $image->remove('widget/'.$widget, $e['data'][$key]['image']);
                    }

                    $image->save('widget/'.$widget);
                    $e['data'][$key]['image'] = $image->getName();
                    $e['data'][$key]['image_crop'] = $image->getCrop();
                }

                unset($e['data'][$key]['slim']);
            }elseif(isset($item['removeImage_item_'.$key]) && $item['removeImage_item_'.$key]){
                $image = new Slim();
                if(isset($edit['data'][$key]['image']) && !empty($edit['data'][$key]['image'])){
                    $image->remove('widget/'.$widget, $edit['data'][$key]['image']);
                }

                $e['data'][$key]['image'] = '';
                $e['data'][$key]['image_crop'] = '';
            }
        }

        return $e;
    }
}
