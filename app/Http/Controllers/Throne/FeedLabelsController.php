<?php namespace App\Http\Controllers\Throne;

use App\Models\FeedLabels;

class FeedLabelsController extends Controller
{
    public $deleteCache = [
        'feed_items.{main_lang}',
        'feed_labels.{main_lang}',
        'feed_labels.{main_lang}.{slug}',
    ];

    public function __construct(FeedLabels $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order','asc'];

        $this->getLang();
    }
}