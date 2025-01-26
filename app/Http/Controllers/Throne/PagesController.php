<?php namespace App\Http\Controllers\Throne;

use App\Models\Pages;

class PagesController extends Controller
{
    public $deleteCache = [
        'pages.{main_lang}.{slug}',
    ];

    public function __construct(Pages $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->archive = true;
        $this->edit = function($data){
            $data['layout'] = json_decode($data['content'], true);
        };

        $this->getLang();
    }

    public function preview($id, $form = null) {
        $page = $this->model->find($id);
        $url = '/'.(session('moduleLang')==env('DEFAULT_LANG') || !session('moduleLang') ? '' : session('moduleLang').'/').$page['slug'];

        if($form){
            return '<script>window.open("'.$url.'", "_blank")</script>';
        }

        return redirect()->to($url);
    }
}