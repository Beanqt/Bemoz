<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'feed_items';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('lang');
                $table->integer('category');
                $table->string('title');
                $table->string('slug');
                $table->string('short');
                $table->longText('content');
                $table->string('image');
                $table->string('image_crop');
                $table->string('bg_image');
                $table->string('bg_image_crop');
                $table->boolean('active');
                $table->boolean('featured');
                $table->dateTime('public_at');
                $table->dateTime('finish_at');
                $table->boolean('auth');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('slug');
                $table->index('category');
                $table->index('active');
                $table->index('featured');
                $table->index('auth');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
