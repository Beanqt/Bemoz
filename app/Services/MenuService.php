<?php namespace App\Services;

use App\Models\Cache;
use App\Models\FeedCategory;
use App\Models\FeedItem;
use App\Models\FeedLabels;
use App\Models\Menu;
use App\Models\Pages;
use Illuminate\Support\Facades\Request;

class MenuService
{
    public $url;
    public $lang;
    public $child;
    public $all = [];
    public $menu = [];
    public $current_name = '';

    public function init(){
        if(empty($this->lang)) {
            $url = Request::path();
            $this->url[] = '/' . trim($url, '/');
            $this->lang = app('LanguageService')->getLangId();
        }
    }

    public function get($type = 0){
        $this->all = Menu::select('id','boss','title','url','image','external','data','type','auth','main_type')->lang()->public()->where('main_type', $type)->orderBy('order','asc')->get()->toArray();
    }

    public function main(){
        $this->init();
        $this->current_name = 'main';

        if(Cache::has('mainMenu-'.$this->lang)){
            $this->menu = Cache::get('mainMenu-'.$this->lang);
        }else{
            $this->get();
            $this->menu = $this->loadMenu();
            Cache::rememberForever('mainMenu-'.$this->lang, $this->menu);
        }

        return $this->render();
    }

    public function left(){
        $this->init();
        $this->current_name = 'left';

        if(Cache::has('leftMenu-'.$this->lang)){
            $this->menu = Cache::get('leftMenu-'.$this->lang);
        }else{
            $this->get(2);
            $this->menu = $this->loadMenu();
            Cache::rememberForever('leftMenu-'.$this->lang, $this->menu);
        }

        return $this->render();
    }

    public function footer(){
        $this->init();
        $this->current_name = 'footer';

        if(Cache::has('footerMenu-'.$this->lang)){
            $this->menu = Cache::get('footerMenu-'.$this->lang);
        }else{
            $this->get(1);
            $this->menu = $this->loadMenu();
            Cache::rememberForever('footerMenu-'.$this->lang, $this->menu);
        }

        return $this->render();
    }

    public function render(){
        return empty($this->menu) ? '' : $this->createHtml($this->menu);
    }

    public function createHtml($array = [], $level = 0, $mega = false){
        return view('menu.'.$this->current_name.'.level-'.$level)->with('menu', $array)->with('menuService', $this)->with('mega', $mega)->render();
    }

    public function loadMenu($boss = 0, $array = [], $side = false, $url = ''){
        $data = array_filter($this->all, function($item) use($boss){
            return $item['boss'] == $boss;
        });

        if(count($data)){
            foreach($data as $item){
                $current_url = $url;
                $array[$item['id']] = $item;

                if($side == false) {
                    $array[$item['id']]['url'] = $this->setUrl($item);
                    $array[$item['id']]['data'] = json_decode($item['data'], true);
                }else{
                    $current_url .= (empty($current_url) ? '' : '/').$item['slug'];
                    $array[$item['id']]['url'] = route('products.index', $current_url);
                    $array[$item['id']]['groups'] = collect($item['groups']);
                }

                if($child = $this->loadMenu($item['id'], [], $side, $current_url)){
                    $array[$item['id']]['mega'] = $this->isMega($child);
                    $array[$item['id']]['items'] = $child;
                }
            }
        }

        return $array;
    }

    public function isMega($items){
        $mega = array_filter($items, function($item){
            return isset($item['items']);
        });

        return count($mega) ? true : false;
    }

    public function haveChild($ids, $type = 0){
        $menu = Menu::where('boss', $ids)->where('lang',$this->lang)->public()->where('main_type', $type)->get();
        $this->child = $menu;

        return count($menu) ? true : false;
    }

    public function addUrl($url){
        $this->url[] = str_replace(route('index'),'',$url);
    }

    public function isActive($row){
        if(in_array(str_replace(route('index'),'',$row), $this->url)){
            return true;
        }
        return false;
    }

    public function setUrl($row){
        if($row['main_type'] == 3){
            return $this->setPersonalUrl($row);
        }
        if($row['type']==2){
            $page = Pages::where('id', $row['url'])->public()->where('lang', $this->lang)->first();
            if($page){
                $row['url'] = route('pages',['slug'=>$page['slug']]);
            }else{
                $row['url'] = '';
            }
        }elseif($row['type']==3){
            if($row['url'] == 'all'){
                $row['url'] = route('feeds.lists');
            }else {
                $category = FeedCategory::lang()->where('slug', $row['url'])->where('active', 1)->first();

                if($category){
                    $row['url'] = route('feeds.lists', ['category' => $category['slug']]);
                }else{
                    $row['url'] = '';
                }
            }
        }elseif($row['type']==4){
            $feed = FeedItem::lang()->public()->where('id', $row['url'])->with('categories')->first();
            if($feed){
                if(count($feed->categories)){
                    $row['url'] = route('feeds.item', ['category' => $feed->categories->slug,'slug'=>$feed['slug']]);
                }else{
                    $row['url'] = '';
                }
            }else{
                $row['url'] = '';
            }
        }elseif($row['type']==5){
            $label = FeedLabels::lang()->where('id', $row['url'])->where('active', 1)->first();

            if($label){
                $row['url'] = route('feeds.label', ['label' => $label['slug']]);
            }else{
                $row['url'] = '';
            }
        }

        return $row['url'];
    }

    public function haveActive($items){
        $this->active = false;
        $this->checkActive([$items]);

        return $this->active;
    }

    public $active = false;
    public function checkActive($items){
        foreach($items as $item){
            if(array_key_exists('url', $item) && $this->isActive($item['url'])){
                $this->active = true;
                break;
            }elseif(array_key_exists('items', $item)){
                $this->checkActive($item['items']);
            }
        }
    }
}