<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'fixed_content';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->longText('title');
                $table->longText('content');
                $table->longText('seo_title');
                $table->longText('seo_keywords');
                $table->longText('seo_desc');
                $table->timestamps();
                $table->softDeletes();
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
