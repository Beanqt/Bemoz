<?php namespace App\Http\Controllers\Throne;

use App\Models\FormContent;
use App\Models\Forms;
use App\Models\Logs;

class FormsController extends Controller
{
    public function __construct(Forms $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->query = function($sql){
            return $sql->with('users');
        };
        $this->edit = function($data){
            $data['data'] = json_decode($data['data'], true);
            $data['json'] = $data['data']['json'];
            $data['live'] = false;
        };

        $this->getLang();
    }

    public function live($id){
        $model = $this->model->find($id);
        if($model) {
            $model->live = 1;
            $model->save();

            session()->flash('success', trans('admin.forms.alerts.liveSuccess'));
        }else{
            session()->flash('error', trans('admin.forms.alerts.not'));
        }

        return redirect()->route('throne.'.$this->default);
    }

    public function copy($id, $lang){
        $form = $this->model->find($id);
        if($form) {
            $model = new Forms();
            $model->title = 'Copy '.$form['title'];
            $model->lang = $lang;
            $model->data = $form['data'];
            $model->save();

            $contents = FormContent::where('form', $id)->get();
            $form = $model;
            foreach($contents as $content){
                $model = new FormContent();
                $model->form = $form->id;
                $model->type = $content['type'];
                $model->subject = $content['subject'];
                $model->content = $content['content'];
                $model->emails = $content['emails'];
                $model->save();
            }

            Logs::saveData([
                'type' => $this->default,
                'element_id' => $model->id,
                'action' => 12,
                'data' => $model
            ]);

            session()->flash('success', trans('admin.forms.alerts.copySuccess'));
        }else{
            session()->flash('error', trans('admin.forms.alerts.copyError'));
        }

        return redirect()->route('throne.'.$this->default);
    }
}
