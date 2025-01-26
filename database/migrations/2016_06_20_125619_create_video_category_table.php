<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'video_category';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->string('image');
                $table->string('image_crop');
                $table->integer('boss');
                $table->integer('order');
                $table->boolean('active');
                $table->timestamps();
                $table->softDeletes();

                $table->index('slug');
                $table->index('boss');
                $table->index('active');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
