<?php namespace App\Http\Controllers\Throne;

use App\Models\Search;

class SearchController extends Controller
{
    public function __construct(Search $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->set_stats = [
            'hits' => function($sql){
                return $sql->count();
            },
            'hit_now' => function($sql){
                return $sql->whereRaw('DATE(created_at) = "'.date('Y-m-d').'"')->count();
            }
        ];
        $this->export = [
            'name' => 'kereses',
            'columns' => ['id','key','created_at'],
        ];
    }
}
