<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration{
    public $name = 'translator_languages';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->increments('id');
                $table->string('locale', 6)->unique();
                $table->string('name', 60)->unique();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
