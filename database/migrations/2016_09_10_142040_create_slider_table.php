<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'slider';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('lang');
                $table->string('title');
                $table->boolean('type');
                $table->string('image');
                $table->string('image_crop');
                $table->string('mp4');
                $table->string('webm');
                $table->dateTime('public_at');
                $table->dateTime('finish_at');
                $table->longText('data');
                $table->integer('order');
                $table->boolean('auth');
                $table->boolean('active');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('auth');
                $table->index('active');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
