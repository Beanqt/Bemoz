<?php namespace App\Http\Controllers;

use App\Models\Cache;
use App\Models\FeedItem;
use App\Models\Slider;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\View;

class HomeController extends Controller {

    public $lang;

    public function __construct() {
        $this->lang = app('LanguageService')->getLangId();
    }

    public function index()
    {
        if (setting('service') && !auth()->guard('admin')->user()) {
            return View('layouts.welcome');
        }

        $slider = Cache::remember('slider.' . $this->lang, 60, function () {
            return Slider::lang()->public()->orderBy('order', 'asc')->get()->toArray();
        });

        $feeds = Cache::remember('home_feed_items.'.$this->lang, 60, function() {
            return FeedItem::lang()->public()->with('categories')->with('labels')->orderBy('public_at', 'desc')->limit(3)->get()->toArray();
        });

        View::share('feeds', $feeds);
        View::share('slider',$slider);
        return View::make('layouts.home');
    }

    public function deleteCookie() {
        $cookies = Cookie::get();

        foreach(array_keys($cookies) as $cookieName){
            setcookie($cookieName, null, -1, '/');
            setcookie($cookieName, null, -1, '/', $_SERVER['SERVER_NAME']);
        }

        return redirect()->route('index');
    }
}