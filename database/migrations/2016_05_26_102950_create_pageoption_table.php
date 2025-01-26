<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'pageoption';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('lang');
                $table->string('name');
                $table->longText('value');

                $table->index('lang');
                $table->index('name');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
