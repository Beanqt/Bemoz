<?php namespace App\Services;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class WidgetService extends Controller
{
   public function get($id, $layout = 1){
      $content = $this->parseWidget($id, $layout);

      View::share('styles', $this->styles);
      return $content;
   }

   public function form($id, $layout = 1) {
      return $this->parseForms($id, $layout);
   }
}