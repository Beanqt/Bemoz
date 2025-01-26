<?php namespace App\Http\Controllers\Throne;

use App\Models\FormContent;
use App\Models\Forms;
use Illuminate\Support\Facades\View;

class FormContentController extends Controller
{
    public function __construct(FormContent $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->boss = ['form', $this->getRouteParameter('form')];

        View::share('form', $this->boss[1]);
    }

    public function creation() {
        $form = Forms::find($this->boss[1]);
        $form['data'] = json_decode($form['data'], true);
        $form['json'] = $form['data']['json'];

        View::share('form', $form);
    }

    public function update() {
        $form = Forms::find($this->boss[1]);
        $form['data'] = json_decode($form['data'], true);
        $form['json'] = $form['data']['json'];

        View::share('form', $form);
    }
}
