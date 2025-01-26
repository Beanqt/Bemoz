<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'feed_labels';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('lang');
                $table->string('title');
                $table->string('slug');
                $table->boolean('active');
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
