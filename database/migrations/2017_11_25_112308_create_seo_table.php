<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'seo';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->increments('id');
                $table->string('type');
                $table->integer('element');
                $table->string('title');
                $table->string('keywords');
                $table->string('desc');
                $table->string('image');
                $table->string('image_crop');
                $table->boolean('addthis');
                $table->boolean('nofollow');

                $table->index('type');
                $table->index('element');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
