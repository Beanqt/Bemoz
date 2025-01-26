<?php namespace App\Http\Controllers;

use App\Models\EventCategory;
use App\Models\Events;
use App\Models\FeedCategory;
use App\Models\FeedItem;
use App\Models\FeedLabels;
use App\Models\Pages;
use App\Models\Search;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class SearchController extends Controller {
	public $lang = null;

	public function __construct() {
		$this->lang = app('LanguageService')->getLangId();
	}

	public function index() {
		$e = request()->all();
		$array = [];
		$hit = [];

		$default_string = isset($e['search']) ? $e['search'] : '';
		$string = slug(str_replace(['ú','ű','ő','ó'], ['u','u','o','o'], $default_string));
		$string = str_replace("-", "%", $string);

		if($string && strlen($string) >= 3){
			$search = new Search();
			$search->key = $default_string;
			$search->save();


			$pages = $this->getPages($string);
			$feeds = $this->getFeeds($string);
			$labels = $this->getFeedLabels($string);
			$feed_categories = $this->getFeedCategories($string);
			$event_categories = $this->getEventCategories($string);
			$events = $this->getEvents($string);

			$pagesTitle = trans('public.search.result.pages');
			$feedsTitle = trans('public.search.result.feeds');
			$labelsTitle = trans('public.search.result.labels');
			$feed_categoriesTitle = trans('public.search.result.feed_categories');
			$event_categoriesTitle = trans('public.search.result.event_categories');
			$eventsTitle = trans('public.search.result.events');

			$count = [
				$feedsTitle => count($feeds),
				$feed_categoriesTitle => count($feed_categories),
				$labelsTitle => count($labels),
				$pagesTitle => count($pages),
				$eventsTitle => count($events),
			];

			foreach($pages as $item) {
				$hit[$pagesTitle][] = [
					'title' => $item['title'],
					'content' => str_limit(strip_tags(removeShortCode(getLayoutContent($item['content']))), 200),
					'url' => route('pages',['slug'=>$item['slug']]),
					'color' => 'page'
				];
			}
			foreach($feeds as $item) {
				$hit[$feedsTitle][] = [
					'title' => $item['title'],
					'content' => str_limit(strip_tags(!empty($item['short']) ? $item['short'] : removeShortCode(getLayoutContent($item['content']))), 200),
					'url' => route('feeds.item',['category'=>$item->categories->slug,'slug'=>$item['slug']]),
					'color' => 'feed-item'
				];
			}
			foreach($labels as $item) {
				$hit[$labelsTitle][] = [
					'title' => $item['title'],
					'content' => '',
					'url' => route('feeds.label',['slug'=>$item['slug']]),
					'color' => 'label'
				];
			}
			foreach($feed_categories as $item) {
				$hit[$feed_categoriesTitle][] = [
					'title' => $item['title'],
					'content' => '',
					'url' => route('feeds.lists',['slug'=>$item['slug']]),
					'color' => 'feed-category'
				];
			}
			foreach($event_categories as $item) {
				$hit[$event_categoriesTitle][] = [
					'title' => $item['title'],
					'content' => '',
					'url' => route('events',['category'=>$item['slug']]),
					'color' => 'event-category'
				];
			}
			foreach($events as $item) {
				$hit[$eventsTitle][] = [
					'title' => $item['title'],
					'content' => '<div><small>'.$item['categories']['title'].'</small></div>',
					'url' => route('event.item',['category'=>$item->categories->slug,'slug'=>$item['slug']]),
					'color' => 'event'
				];
			}

			foreach($count as $key => $item) {
				$array[$key]['count'] = $item;
				if(isset($hit[$key])) {
					foreach($hit[$key] as $i) {
						$array[$key]['color'] = $i['color'];
						$array[$key]['items'][] = [
							'title' => $i['title'],
							'content' => str_limit(removeShortCode($i['content']), 200),
							'url' => $i['url'],
							'type' => isset($i['type']) ? 2 : '',
							'image' => isset($i['image']) ? $i['image'] : '',
							'code' => isset($i['code']) ? $i['code'] : '',
						];
					}
				}
			}

			View::share('value', $default_string);
		}

		View::share('array', $array);
		return view('layouts.search.index');
	}

	public function search(){
		$e = request()->all();

		$default_string = isset($e['val']) ? $e['val'] : '';
		$string = slug(str_replace(['�','�','�','�'], ['u','u','o','o'], $default_string));
		$string = str_replace("-", "%", $string);

		$pages = $this->getPages($string);
		$feeds = $this->getFeeds($string);
		$labels = $this->getFeedLabels($string);
		$feed_categories = $this->getFeedCategories($string);
		$event_categories = $this->getEventCategories($string);
		$events = $this->getEvents($string);

		$result['searched'] = [];
		foreach($feeds as $feed) {
			$result['searched'][] = ['url'=>route('feeds.item',['category'=>$feed->categories->slug,'slug'=>$feed['slug']]), 'title'=>$feed['title'], 'tag'=>trans('public.search.tags.feeds'), 'color' => 'feed-item'];
		}
		foreach($feed_categories as $category) {
			$result['searched'][] = ['url'=>route('feeds.lists',['category'=>$category['slug']]), 'title'=>$category['title'], 'tag'=>trans('public.search.tags.feed_categories'), 'color' => 'feed-category'];
		}
		foreach($labels as $label) {
			$result['searched'][] = ['url'=>route('feeds.label',['label'=>$label['slug']]), 'title'=>$label['title'], 'tag'=>trans('public.search.tags.labels'), 'color' => 'label'];
		}
		foreach($pages as $page) {
			$result['searched'][] = ['url'=>route('pages',['slug'=>$page['slug']]), 'title'=>$page['title'], 'tag'=>trans('public.search.tags.page'), 'color' => 'page'];
		}
		foreach($event_categories as $category) {
			$result['searched'][] = ['url'=>route('events',['category'=>$category['slug']]), 'title'=>$category['title'], 'tag'=>trans('public.search.tags.event_categories'), 'color' => 'event-category'];
		}
		foreach($events as $item) {
			$result['searched'][] = ['url'=>route('event.item',['category'=>$item->categories->slug,'slug'=>$item['slug']]), 'title'=>$item['title'], 'tag'=>trans('public.search.tags.events'), 'color' => 'event'];
		}

		if(empty($result['searched'])){
			$result['searched'][] = ['url'=>'', 'title'=>trans('public.search.mini.not'), 'tag'=>''];
		}

		return $result;
	}

	public function searchSave(){
		$e = request()->all();

		$string = isset($e['val']) ? $e['val'] : '';

		if($string){
			$search = new Search();
			$search->key = $string;
			$search->save();
		}
	}

	public function getPages($string){
		return Pages::lang()->public()->where(function($query) use ($string){
			$query->where(DB::raw("REPLACE(slug, '-', '')"),'LIKE','%'.$string.'%')->orWhere('content', 'LIKE', '%content":"%'.$string.'%"%');
		})->orderBy(DB::raw("CASE
			 WHEN REPLACE(slug, '-', '') LIKE '%".$string."%' THEN 1
			 WHEN content LIKE '%".$string."%' THEN 2
		ELSE 3 END"))->get();
	}
	public function getFeedCategories($string){
		return FeedCategory::lang()->where('active', 1)->where(DB::raw("REPLACE(slug, '-', '')"),'LIKE','%'.$string.'%')->orderBy('order', 'asc')->get();
	}
	public function getFeedLabels($string){
		return FeedLabels::lang()->where('active', 1)->where(DB::raw("REPLACE(slug, '-', '')"),'LIKE','%'.$string.'%')->orderBy('order', 'asc')->get();
	}
	public function getFeeds($string){
		return FeedItem::lang()->public()->with('categories')->has('categories')->with('labels')->where(function($query) use ($string){
			$query->where(DB::raw("REPLACE(slug, '-', '')"),'LIKE','%'.$string.'%')->orWhere('short','LIKE','%'.$string.'%')->orWhere('content', 'LIKE', '%content":"%'.$string.'%"%');
		})->orderBy(DB::raw("CASE
			 WHEN REPLACE(slug, '-', '') LIKE '%".$string."%' THEN 1
			 WHEN short LIKE '%".$string."%' THEN 2
			 WHEN content LIKE '%".$string."%' THEN 3
		ELSE 4 END"))->get();
	}
	public function getEventCategories($string){
		return EventCategory::lang()->where('active', 1)->where(DB::raw("REPLACE(slug, '-', '')"),'LIKE','%'.$string.'%')->orderBy('order', 'asc')->get();
	}
	public function getEvents($string){
		return Events::lang()->public()->with('categories')->has('categories')->where(function($query) use ($string){
			$query->where(DB::raw("REPLACE(slug, '-', '')"),'LIKE','%'.$string.'%')->orWhere('content', 'LIKE', '%content":"%'.$string.'%"%');
		})->orderBy('public_at', 'desc')->get();
	}
}
