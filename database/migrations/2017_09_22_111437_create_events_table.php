<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'events';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->increments('id');
                $table->integer('lang');
                $table->integer('category');
                $table->string('title');
                $table->string('slug');
                $table->string('place');
                $table->text('short');
                $table->longText('content');
                $table->string('image');
                $table->string('image_crop');
                $table->boolean('active');
                $table->dateTime('event_start');
                $table->dateTime('event_end');
                $table->dateTime('public_at');
                $table->dateTime('finish_at');
                $table->boolean('auth');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('category');
                $table->index('slug');
                $table->index('active');
                $table->index('auth');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
