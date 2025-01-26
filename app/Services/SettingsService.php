<?php namespace App\Services;

use App\Models\Cache;
use App\Models\Settings;

class SettingsService
{
   public $settings = [];

   public function get($name, $lang = false){
      $fullname = $name;
      if($lang){
         $lang = app('LanguageService')->getLangId();
         $fullname = $name.$lang;
      }

      if(!array_key_exists($fullname, $this->settings)){
         $explode = explode('.', $name);

         $setting = Cache::rememberForever('settings_'.$fullname, function() use($lang,$explode){
            $setting = Settings::where('name', $explode[0]);
            if($lang){
               $setting = $setting->where('lang', $lang);
            }

            return $setting->first();
         });

         $value = '';
         if($setting){
            $array = json_decode($setting['value'], true);
            $value = $setting['value'];

            if(is_array($array)){
               if(isset($explode[1])){
                  if(array_key_exists($explode[1], $array)){
                     $value = $array[$explode[1]];
                  }
               }else{
                  $value = $array;
               }
            }
         }

         $this->settings[$fullname] = $value;
      }

      return $this->settings[$fullname];
   }
}