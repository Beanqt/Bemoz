<?php namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use Illuminate\Support\Facades\Route;

class PopupService extends Controller
{
    public function get(){
        $route = Route::currentRouteName();
        $current_params = null;
        if(Route::current()){
            $current_params = Route::current()->parameters();
        }
        $popup = null;
        $string[] = 'all_page';

        switch($route){
            case 'index':
                    $string[] = 'home_page';
                break;
            case 'feeds.item':
                    $string[] = 'feeds_all';
                    $string[] = 'feed_'.$current_params['slug'];
                break;
            case 'feeds.lists':
                    $string[] = 'feed_categories_all';
                    if(isset($current_params['category'])) {
                        $string[] = 'feed_category_' . $current_params['category'];
                    }
                break;
            case 'feeds.label':
                    $string[] = 'labels_all';
                    $string[] = 'label_'.$current_params['label'];
                break;
            case 'pages':
                    $string[] = 'pages_all';
                    $string[] = 'page_'.$current_params['slug'];
                break;
        }

        $popup = $this->getData($string);

        if($popup){
            if($popup['value'] > 0 && session('popup.'.$popup['id']) && !session('popup.forever.'.$popup['id'])){
                $current = time();
                $popup_time = session('popup.'.$popup['id']);

                if($current < $popup_time+$popup['value']){
                    $popup = null;
                }else{
                    session()->forget('popup.'.$popup['id']);
                }
            }

            if(!is_null($popup['id']) && !session()->has('popup.'.$popup['id'])){
                session()->put('popup.'.$popup['id'], time());
            }

            if(isset($popup['forever'])){
                if(session('popup.forever.'.$popup['id'])){
                    $popup = null;
                }else{
                    session()->put('popup.forever.'.$popup['id'], true);
                }
            }
        }

        return $popup;
    }

    public function getData($string){
        $popup = Popup::lang()->public();
        if(is_array($string)){
            $popup = $popup->where(function($query) use($string){
                foreach($string as $item){
                    $query->orWhere('pages','LIKE','%"'.$item.'"%');
                }
            });
        }else{
            $popup = $popup->where('pages','LIKE','%"'.$string.'"%');
        }
        $popup = $popup->orderBy('order', 'asc')->first();

        if($popup){
            $popup['value'] = 0;
            $popup['data'] = json_decode($popup['data'], true);

            if(!$popup['type']){
                $popup['value'] = $popup['second'];
                session()->forget('popup.forever.'.$popup['id']);
            }else{
                $popup['forever'] = true;
            }
        }

        return $popup;
    }
}
