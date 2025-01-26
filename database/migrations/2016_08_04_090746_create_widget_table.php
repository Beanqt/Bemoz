<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'widget';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('title');
                $table->string('type');
                $table->integer('lang');
                $table->longText('data');
                $table->boolean('active');
                $table->timestamps();
                $table->softDeletes();

                $table->index('type');
                $table->index('lang');
                $table->index('active');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
