<?php namespace App\Http\Controllers\Api;

use App\Models\Widget;

class WidgetController {
    public function refresh($widget){
        $widgets = Widget::where('type',$widget)->get();
        $options = '';

        foreach($widgets as $item){
            $options .= '<option value="'.$item['id'].'">'.$item['title'].'</option>';
        }

        return $options;
    }
}
