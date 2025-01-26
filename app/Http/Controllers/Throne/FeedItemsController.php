<?php namespace App\Http\Controllers\Throne;

use App\Models\FeedCategory;
use App\Models\FeedItem;
use App\Models\FeedItemLabels;
use App\Models\FeedLabels;
use App\Models\Translates;
use Illuminate\Support\Facades\View;

class FeedItemsController extends Controller
{
    public $deleteCache = [
        'feed_items.{main_lang}',
        'home_feed_items.{main_lang}',
        'feed_items.{main_lang}.{slug}',
        'feed_labels.{main_lang}',
        'feed_categories.{main_lang}',
        'footerFeeds.{main_lang}',
    ];

    public function __construct(FeedItem $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->archive = 2;
        $this->clear_inputs = ['image', 'image_crop','bg_image', 'bg_image_crop'];
        $this->delete_files = ['bg_image' => ['path' => 'bg/', 'small' => true]];
        $this->check_exception = ['label'];
        $this->check = function($sql, $e){
            if(isset($e['label']) && !empty($e['label'])){
                $labels = FeedItemLabels::where('label', $e['label'])->pluck('item')->all();
                $sql->whereIn('id', $labels);
            }
        };
        $this->query = function($sql){
            return $sql->with('throneCategories')->with('throneLabels');
        };
        $this->edit = function($data){
            $data['layout'] = json_decode($data['content'], true);
            $data['label'] = FeedItemLabels::where('item', $data['id'])->get()->pluck('label')->all();
        };
        $this->all_queries = function(){
            View::share('categories', FeedCategory::where('lang', $this->lang)->get());
            View::share('labels', FeedLabels::where('lang', $this->lang)->get());
        };

        $this->getLang();
    }

    public function lists() {
        View::share('categories', FeedCategory::where('lang', $this->lang)->get());
        View::share('labels', FeedLabels::where('lang', $this->lang)->get());
    }

    public function creation() {
        call_user_func($this->all_queries);
    }

    public function update() {
        call_user_func($this->all_queries);
    }

    public function preview($id, $form = null) {
        $feed = $this->model->find($id);
        $code = session('moduleLang')==env('DEFAULT_LANG') || !session('moduleLang') ? '' : session('moduleLang').'/';
        $blog = Translates::where('item', 'feeds.slug')->where('group', 'public')->where('locale', session('moduleLang'))->first();
        $url = '/'.$code.(isset($blog['text']) ? $blog['text'] : trans('public.feeds.slug')).'/'.($feed->throneCategories ? $feed->throneCategories->slug : 'preview').'/'.$feed['slug'];

        if($form){
            return '<script>window.open("'.$url.'", "_blank")</script>';
        }

        return redirect()->to($url);
    }
}
