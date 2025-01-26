<?php
namespace App\Services;

class Breadcrumbs
{
    public $breadcrumbs = [];

    public function add($title = '', $slug = ''){
        if(!empty($title)){
            $array['title'] = $title;
        }
        if(!empty($slug)){
            $array['slug'] = $slug;
        }

        if(isset($array)) {
            $this->breadcrumbs[] = $array;
        }
        return $this;
    }

    public function flash(){
        $this->breadcrumbs = [];
        return $this;
    }

    public function render(){
        return $this->breadcrumbs;
    }
}