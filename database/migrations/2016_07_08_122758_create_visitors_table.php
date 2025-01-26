<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'visitors';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->increments('id');
                $table->string('page');
                $table->string('hash');
                $table->integer('device');
                $table->integer('browser');
                $table->timestamps();

                $table->index('page');
                $table->index('hash');
                $table->index('device');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
