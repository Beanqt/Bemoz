<?php namespace App\Http\Controllers\Throne;

use App\Models\FeedCategory;

class FeedCategoriesController extends Controller
{
    public $deleteCache = [
        'feed_items.{main_lang}',
        'feed_categories.{main_lang}',
        'feed_categories.{main_lang}.{slug}',
    ];

    public function __construct(FeedCategory $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order','asc'];

        $this->getLang();
    }
}
