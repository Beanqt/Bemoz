<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'menu';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('lang');
                $table->string('title');
                $table->string('url');
                $table->integer('type');
                $table->integer('boss');
                $table->integer('order');
                $table->string('image');
                $table->string('image_crop');
                $table->boolean('external');
                $table->longText('data');
                $table->boolean('main_type');
                $table->boolean('active');
                $table->dateTime('public_at');
                $table->dateTime('finish_at');
                $table->boolean('auth');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('boss');
                $table->index('main_type');
                $table->index('active');
                $table->index('auth');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
