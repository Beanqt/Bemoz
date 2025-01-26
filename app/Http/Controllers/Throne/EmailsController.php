<?php namespace App\Http\Controllers\Throne;

use App\Models\Emails;
use App\Models\Languages;
use Illuminate\Support\Facades\View;

class EmailsController extends Controller
{
    public function __construct(Emails $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->edit = function($data){
            $data['subject'] = json_decode($data['subject'], true);
            $data['content'] = json_decode($data['content'], true);
        };
    }

    public function update() {
        View::share('throne_languages', Languages::get());
    }
}
