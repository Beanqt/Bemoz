<?php namespace App\Http\Controllers\Throne;

use App\Models\PartnerCategory;

class PartnerCategoriesController extends Controller
{
    public $deleteCache = [
        'partner_categories.{main_lang}',
    ];
    
    public function __construct(PartnerCategory $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order','asc'];

        $this->getLang();
    }
}
