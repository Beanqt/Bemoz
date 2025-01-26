<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'popup';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('lang');
                $table->string('title');
                $table->integer('type');
                $table->integer('second');
                $table->longText('pages');
                $table->longText('data');
                $table->string('image');
                $table->string('image_crop');
                $table->boolean('active');
                $table->dateTime('public_at');
                $table->dateTime('finish_at');
                $table->integer('order');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('active');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
