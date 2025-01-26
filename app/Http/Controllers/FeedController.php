<?php namespace App\Http\Controllers;

use App\Models\Cache;
use App\Models\FeedCategory;
use App\Models\FeedItem;
use App\Models\FeedItemLabels;
use App\Models\FeedLabels;
use App\Services\Breadcrumbs;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;

class FeedController extends Controller {

	public $lang;
	public $breadcrumbs;

	public function __construct(){
		$this->lang = app('LanguageService')->getLangId();
		$this->breadcrumbs = new Breadcrumbs();
		$this->breadcrumbs->add(trans('public.feeds.title'), route('feeds.lists'));
	}

	public function lists($category = null) {
		session()->put('feeds.labels', '');

		$categories = Cache::remember('feed_categories.'.$this->lang.(is_null($category) ? '' : '.'.$category), 60, function() use($category){
			return FeedCategory::where('slug', $category)->lang()->where('active',1)->first();
		});

		if($categories || is_null($category)) {
			if(is_null($category)) {
				session()->put('feeds.category', '');
			}else {
				session()->put('feeds.category', $categories['id']);
				$this->breadcrumbs->add($categories['title'], route('feeds.lists', $categories['slug']));
			}

			Paginator::currentPageResolver(function() {
				return session('feeds.'.session('feeds.category').'.page');
			});

			$feed_items = $this->getAll();

			View::share('breadcrumbs', $this->breadcrumbs->render());
			View::share('feeds', $feed_items);
			View::share('category', $categories);
			return View::make('layouts.feed.lists');
		}
		abort(404);
		return false;
	}

	public function label($label) {
		session()->put('feeds.category', '');

		$label = Cache::remember('feed_labels.'.$this->lang.(is_null($label) ? '' : '.'.$label), 60, function() use($label){
			return FeedLabels::where('slug', $label)->lang()->where('active',1)->first();
		});

		if($label) {
			$meta['title'] = $label['title'];
			session()->put('feeds.labels', $label['id']);

			$feeds = $this->getAll();

			View::share('feeds', $feeds);
			View::share('meta', $meta);
			View::share('breadcrumbs', $this->breadcrumbs->add(trans('public.feeds.labels.title'), route('feeds.label', $label['slug']))->render());
			View::share('category', $label);
			return View::make('layouts.feed.lists');
		}

		session()->put('feeds.labels', '');

		abort(404);
		return false;
	}

	public function item($category, $slug = null)
	{
		if(auth()->guard('admin')->check()) {
			$item = FeedItem::where('slug', $slug)->with('categories')->lang()->first();
			$categories = FeedCategory::first();
		}else{
			$item = Cache::remember('feed_items.'.$this->lang.'.'.$slug, 60, function() use($slug){
				return FeedItem::where('slug', $slug)->with('categories')->with('labels')->has('categories')->lang()->public()->first();
			});
			$categories = Cache::remember('feed_categories.'.$this->lang.'.'.$category, 60, function() use($category){
				return FeedCategory::where('slug', $category)->where('active',1)->first();
			});
		}

		if($item && $categories){
			$item['content'] = $this->parseContent($item['content']);

			$meta = getSeoData($item, 'feed_items/');

			$this->breadcrumbs->add($categories['title'], route('feeds.lists', ['category'=>$categories['slug']]));
			$this->breadcrumbs->add($item['title'], route('feeds.item', ['category'=>$categories['slug'], 'slug'=>$item['slug']]));

			View::share('breadcrumbs', $this->breadcrumbs->render());

			View::share('meta',$meta);
			View::share('data',$item);
			return View::make('layouts.feed.item');
		}
		abort(404);
		return false;
	}

	public function view(){
		$e = request()->all();

		$return['return'] = false;

		if(isset($e['limit']))
		{
			$this->limit($e['limit']);

			$return['limit'] = session('limit');
		}

		if(isset($e['action']) && !empty($e['action'])){
			session()->put('view', $e['action'] == 'list' ? 1 : 2);
			Paginator::currentPageResolver(function() {
				return session('feeds.'.session('feeds.category').'.page');
			});

			$return['type'] = $e['action'] == 'list' ? 1 : 2;
		}

		$feed_items = $this->getAll();

		$return['return'] = true;
		$return['content'] = view('layouts.feed._content')->with('feeds', $feed_items)->render();

		return $return;
	}

	public function getAll(){
		$feeds = FeedItem::auth()->lang()->public()->with('categories')->has('categories')->with('labels')->orderBy('public_at', 'desc');

		if(!empty(session('feeds.category'))){
			$feeds = $feeds->where('category', session('feeds.category'));
		}
		if(!empty(session('feeds.labels')) ) {
			$ids = FeedItemLabels::where('label', session('feeds.labels'))->pluck('item')->all();
			$feeds = $feeds->whereIn('id', $ids);
		}

        return $feeds->paginate(8);
	}

	public function page() {
		session()->put('feeds.'.session('feeds.category').'.page', isset($_GET['page']) ? $_GET['page'] : 1);
		$feeds = $this->getAll();

		return view('layouts.feed._content')->with('feeds', $feeds)->render();
	}
}
