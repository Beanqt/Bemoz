<?php namespace App\Http\Controllers\Throne;

use App\Models\FeedCategory;
use App\Models\FeedItem;
use App\Models\FeedLabels;
use App\Models\Pages;
use App\Models\Popup;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    public function __construct(Popup $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order', 'asc'];
        $this->clear_inputs = ['image', 'image_crop'];
        $this->edit = function($data){
            $data['pages'] = json_decode($data['pages'], true);
            $data['data'] = json_decode($data['data'], true);
        };
        $this->all_queries = function(){
            View::share('pages', Pages::where('lang', $this->lang)->get());
            View::share('feeds', FeedItem::where('lang', $this->lang)->get());
            View::share('labels', FeedLabels::where('lang', $this->lang)->get());
            View::share('feed_categories', FeedCategory::where('lang', $this->lang)->get());
        };

        $this->getLang();
    }

    public function creation() {
        call_user_func($this->all_queries);
    }

    public function update() {
        call_user_func($this->all_queries);
    }
}
