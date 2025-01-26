<?php namespace App\Http\Controllers\Throne;

use App\Models\FixedContent;
use App\Models\Languages;
use Illuminate\Support\Facades\View;

class FixedContentController extends Controller
{
    public $deleteCache = [
        'fixed_content.{id}',
    ];
    
    public function __construct(FixedContent $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->edit = function($data){
            $data['title'] = json_decode($data['title'], true);
            $data['content'] = json_decode($data['content'], true);
            $data['seo_title'] = json_decode($data['seo_title'], true);
            $data['seo_keywords'] = json_decode($data['seo_keywords'], true);
            $data['seo_desc'] = json_decode($data['seo_desc'], true);
        };
    }

    public function update() {
        $lang = Languages::get();
        View::share('throne_languages', $lang);
    }
}
