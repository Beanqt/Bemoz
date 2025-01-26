<?php namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Cache;
use App\Models\Languages;
use Illuminate\Support\Facades\Request;

class LanguageService extends Controller
{
   public $languages = [];
   public $lang = null;
   public $locale_url;

   public function __construct(){
      $this->locale_url = Request::segment(1);

      if($this->locale_url == 'api'){
         $this->locale_url = Request::segment(2);
      }

      $this->languages = Cache::rememberForever('languages', function () {
         return Languages::where('active', 1)->orderBy('order', 'asc')->get();
      });
   }

   public function init(){
      if(count($this->languages)){
         $languages = $this->languages->pluck('locale')->all();

         if(in_array($this->locale_url, $languages) && $this->locale_url != env('DEFAULT_LANG')){
            app()->setLocale($this->locale_url);
         }else{
            app()->setLocale(env('DEFAULT_LANG'));
         }

         foreach($this->languages as $item){
            if(app()->getLocale() == $item['locale']){
               $this->lang = $item['id'];
               break;
            }
         }
      }

      if(env('TRANSLATION_SOURCE') == 'database'){
          $this->translations = \App\Models\Translates::where('locale', app()->getLocale())->pluck('text', 'item')->all();
      }
   }

   public function getLanguages(){
      return $this->languages;
   }

   public function getLangId(){
      return $this->lang;
   }
}