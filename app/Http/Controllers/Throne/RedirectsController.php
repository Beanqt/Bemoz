<?php namespace App\Http\Controllers\Throne;

use App\Models\Redirects;

class RedirectsController extends Controller
{
    public function __construct(Redirects $model){
        $this->model = $model;
        $this->default = $model::$name;
    }
}
