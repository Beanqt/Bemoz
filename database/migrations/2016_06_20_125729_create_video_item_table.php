<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'video_item';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->string('image');
                $table->string('image_crop');
                $table->string('video_id');
                $table->string('mp4');
                $table->string('webm');
                $table->integer('type');
                $table->integer('category');
                $table->integer('order');
                $table->boolean('autoplay');
                $table->boolean('loop');
                $table->boolean('mute');
                $table->boolean('active');
                $table->timestamps();
                $table->softDeletes();

                $table->index('slug');
                $table->index('category');
                $table->index('active');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
