<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'document_item';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('title');
                $table->string('slug');
                $table->string('file');
                $table->string('image');
                $table->string('image_crop');
                $table->string('size');
                $table->integer('category');
                $table->integer('order');
                $table->boolean('active');
                $table->boolean('auth');
                $table->timestamps();
                $table->softDeletes();

                $table->index('slug');
                $table->index('category');
                $table->index('active');
                $table->index('auth');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
