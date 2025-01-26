<?php namespace App\Http\Controllers\Throne;

use App\Models\PartnerCategory;
use App\Models\PartnerItem;
use Illuminate\Support\Facades\View;

class PartnerItemsController extends Controller
{
    public $deleteCache = [
        'partner_items',
    ];

    public function __construct(PartnerItem $model){
        $this->model = $model;
        $this->default = $model::$name;
        $this->order = ['order', 'asc'];
        $this->clear_inputs = ['image', 'image_crop'];
    }

    public function lists() {
        View::share('categories', PartnerCategory::get());
    }
    public function creation() {
        View::share('categories', PartnerCategory::get());
    }
    public function update() {
        View::share('categories', PartnerCategory::get());
    }
}
