<?php namespace App\Http\Controllers\Throne;

use App\Models\EventCategory;

class EventCategoriesController extends Controller
{
    public $deleteCache = [
        'event_categories.{main_lang}',
        'event_categories.{main_lang}.{slug}',
    ];

    public function __construct(EventCategory $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order','asc'];

        $this->getLang();
    }
}