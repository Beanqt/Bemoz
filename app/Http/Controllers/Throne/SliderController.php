<?php namespace App\Http\Controllers\Throne;

use App\Models\Slider;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public $deleteCache = [
        'slider.{main_lang}',
    ];

    public function __construct(Slider $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order','asc'];
        $this->clear_inputs = ['image','image_crop','mp4','webm'];
        $this->delete_files = ['mp4','webm'];
        $this->edit = function($data){
            $data['data'] = json_decode($data['data'], true);
        };

        $this->getLang();
    }

    public function text($id, Request $request) {
        $slider = $this->model->find($id);
        if($slider){
            $slider['data'] = json_decode($slider['data'], true);
            View::share('data', $slider);

            if ($request->isMethod('post')) {
                $e = request()->all();

                $text = $e['data'];
                $e['data'] = $slider['data'];
                $e['data']['text'] = $text['text'];

                $model = $this->model->find($id);
                $model->data = json_encode($e['data']);
                $model->save();

                session()->flash('success', trans('admin.alert.save'));

                if($e['submit'] == 1){
                    return redirect()->route('throne.'.$this->default.'.text', $id);
                }else{
                    return redirect()->route('throne.'.$this->default);
                }
            }
            return $this->renderView('text');
        }
        return redirect()->route('throne.'.$this->default);
    }
}
