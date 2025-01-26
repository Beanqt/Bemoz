<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'partner_items';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('category');
                $table->string('title');
                $table->string('url');
                $table->boolean('target');
                $table->string('image');
                $table->string('image_crop');
                $table->boolean('active');
                $table->integer('order');
                $table->dateTime('public_at');
                $table->dateTime('finish_at');
                $table->timestamps();
                $table->softDeletes();

                $table->index('category');
                $table->index('active');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
