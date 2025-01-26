<?php namespace App\Http\Controllers;

use App\Models\Cache;
use App\Models\Pages;
use App\Services\Breadcrumbs;
use Illuminate\Support\Facades\View;

class PagesController extends Controller {

	public $lang;
	public $breadcrumbs;

	public function __construct(){
		$this->lang = app('LanguageService')->getLangId();
		$this->breadcrumbs = new Breadcrumbs();
	}

	public function index($slug){
		if(auth()->guard('admin')->check()) {
			$page = Pages::where('slug', $slug)->lang()->first();
		}else{
			$page = Cache::remember('pages.'.$this->lang.'.'.$slug, 60, function() use($slug){
				return Pages::where('slug', $slug)->lang()->public()->auth()->first();
			});
		}
		if($page){
			$page['content'] = $this->parseContent($page['content']);

			$this->breadcrumbs->add($page['title'], route('pages', ['slug'=>$page['slug']]));
			$meta = getSeoData($page);

			View::share('breadcrumbs', $this->breadcrumbs->render());
			View::share('meta',$meta);
			View::share('page',$page);
			return View::make('layouts.page');
		}

		abort(404);
		return false;
	}
}
