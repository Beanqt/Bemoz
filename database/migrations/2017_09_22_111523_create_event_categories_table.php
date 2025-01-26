<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'event_categories';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->increments('id');
                $table->integer('lang');
                $table->string('title');
                $table->string('slug');
                $table->string('color');
                $table->string('color2');
                $table->boolean('active');
                $table->integer('order');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('slug');
                $table->index('active');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
