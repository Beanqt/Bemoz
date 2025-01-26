<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'forms';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('title');
                $table->string('lang');
                $table->longText('data');
                $table->boolean('active');
                $table->boolean('live');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('active');
                $table->index('live');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
