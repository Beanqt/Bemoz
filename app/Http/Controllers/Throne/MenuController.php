<?php namespace App\Http\Controllers\Throne;

use App\Models\Cache;
use App\Models\FeedCategory;
use App\Models\FeedItem;
use App\Models\FeedLabels;
use App\Models\Menu;
use App\Models\Pages;
use Illuminate\Support\Facades\View;

class MenuController extends Controller
{
    public function __construct(Menu $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order', 'asc'];
        $this->multi_order = true;
        $this->boss = ['main_type', $this->getRouteParameter('type'), $this->getType($this->getRouteParameter('type'))];
        $this->edit = function($data){
            $data['data'] = json_decode($data['data'], true);
        };

        $this->getLang();
        View::share('type', $this->boss[1]);
    }

    public function creation(){
        View::share('pages', Pages::where('lang',$this->lang)->get());
        View::share('feed_items', FeedItem::where('lang',$this->lang)->get());
        View::share('feed_labels', FeedLabels::where('lang',$this->lang)->get());
        View::share('feed_categories', FeedCategory::where('lang',$this->lang)->get());
    }

    public function update(){
        View::share('pages', Pages::where('lang',$this->lang)->get());
        View::share('feed_items', FeedItem::where('lang',$this->lang)->get());
        View::share('feed_labels', FeedLabels::where('lang',$this->lang)->get());
        View::share('feed_categories', FeedCategory::where('lang',$this->lang)->get());
    }

    public function getType($type){
        if($type == 'footer'){
            $type = 1;
        }elseif($type == 'side'){
            $type = 2;
        }else{
            $type = 0;
        }

        return $type;
    }

    public function clearCache(){
        $type = $this->boss[2];

        if($type == 1){
            Cache::forget('footerMenu-'.$this->lang);
        }elseif($type == 2){
            Cache::forget('leftMenu-'.$this->lang);
        }else{
            Cache::forget('mainMenu-'.$this->lang);
        }
    }
}
