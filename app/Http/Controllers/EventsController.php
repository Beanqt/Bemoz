<?php namespace App\Http\Controllers;

use App\Models\Cache;
use App\Models\EventCategory;
use App\Models\Events;
use App\Services\Breadcrumbs;
use Illuminate\Support\Facades\View;

class EventsController extends Controller {

	public $breadcrumbs;

	public function __construct(){
		$this->breadcrumbs = new Breadcrumbs();
	}

	public function index($category = null){
		if(is_null($category)) {
			$events = Events::auth()->lang()->public()->where('event_end','>=',date('Y-m-d'))->orderBy('event_start','asc')->with('categories')->has('categories')->orderBy('title','asc')->paginate(4);
		}else{
			$categories = explode('_', $category);
			$categories = EventCategory::lang()->whereIn('slug', $categories)->where('active', 1)->pluck('id')->all();

			$events = Events::auth()->lang()->public()->whereIn('category', $categories)->where('event_end','>=',date('Y-m-d'))->with('categories')->has('categories')->orderBy('event_start','asc')->orderBy('title','asc')->paginate(4);
		}

		View::share('breadcrumbs', $this->breadcrumbs->add(trans('public.events.title'), route('events'))->render());
		View::share('events', $events);
		View::share('category', $category);
		return View::make('layouts.event.index');
	}

	public function item($category, $slug){
		$category = Cache::remember('event_categories.'.$this->lang.'.'.$category, 60, function() use($category){
			return EventCategory::lang()->where('slug', $category)->where('active', 1)->first();
		});

		if($category){
			$event = Events::auth()->lang()->public()->where('slug', $slug)->first();

			if($event) {
				$event['content'] = $this->parseContent($event['content']);

				$meta = getSeoData($event);

				$this->breadcrumbs->add(trans('public.events.title'), route('events'));
				$this->breadcrumbs->add($category['title'], route('events', $category['slug']));
				$this->breadcrumbs->add($event['title'], route('event.item', ['category'=>$category['slug'], 'item'=>$event['slug']]));

				View::share('breadcrumbs', $this->breadcrumbs->render());
				View::share('meta',$meta);
				View::share('event', $event);
				return View::make('layouts.event.item');
			}
		}

		abort(404);
		return false;
	}

	public function events($category = null){
		if(is_null($category)) {
			$events = Events::auth()->lang()->public()->orderBy('event_start', 'asc')->with('categories')->get();
		}else{
			$categories = explode('_', $category);
			$category = EventCategory::lang()->whereIn('slug', $categories)->public()->pluck('id')->all();

			$events = Events::auth()->lang()->public()->whereIn('category', $category)->orderBy('event_start', 'asc')->with('categories')->get();
		}
		$calendar['success'] = 1;
		$calendar['result'] = array();

		foreach($events as $event) {
			if($event['categories']) {
				$calendar['result'][] = [
					"id" => $event['id'],
					"title" => $event['title'],
					"class" => 'event-info',
					"color" => $event['categories']['color'],
					"color2" => $event['categories']['color2'],
					"url" => route('event.item', ['category' => $event['categories']['slug'], 'slug' => $event['slug']]),
					"start" => strtotime($event['event_start']) * 1000,
					"end" => strtotime($event['event_end']) * 1000,
				];
			}
		}

		return $calendar;
	}
}
