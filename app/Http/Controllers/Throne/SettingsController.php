<?php namespace App\Http\Controllers\Throne;

use App\Models\Cache;
use App\Models\Languages;
use App\Models\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public $default = 'settings';

    public function edit() {
        $languages = Languages::get();
        $settings = Settings::get();
        $data = [];

        foreach($settings as $setting){
            $value = json_decode($setting['value'], true);
            $value = is_array($value) ? $value : $setting['value'];

            if(!$setting['lang']){
                $data[$setting['name']] = $value;
            }else{
                $data[$setting['name']][$setting['lang']] = $value;
            }
        }

        View::share('data', $data);
        View::share('languages', $languages);

        if(request()->isMethod('post')) {
            Settings::saveData();

            foreach($languages as $language) {
                Cache::forget('home_feed_items.'.$language['id']);
                Cache::forget('home_tender_items.'.$language['id']);
            }

            session()->flash('success', trans('admin.alert.save'));

            return redirect()->route('throne.settings.edit');
        }

        return $this->renderView('edit');
    }
}
