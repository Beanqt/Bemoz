<?php namespace App\Http\Controllers\Throne;

use App\Models\EventCategory;
use App\Models\Events;
use Illuminate\Support\Facades\View;

class EventsController extends Controller
{
    public $deleteCache = [
        'events.{main_lang}.{slug}',
    ];

    public function __construct(Events $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->archive = 3;
        $this->clear_inputs = ['image', 'image_crop'];
        $this->query = function($sql){
            return $sql->with('throneCategories');
        };
        $this->edit = function($data){
            $data['layout'] = json_decode($data['content'], true);
        };

        $this->getLang();
    }

    public function lists() {
        View::share('categories', EventCategory::where('lang', $this->lang)->get());
    }

    public function creation() {
        View::share('categories', EventCategory::where('lang', $this->lang)->get());
    }

    public function update() {
        View::share('categories', EventCategory::where('lang', $this->lang)->get());
    }
}
