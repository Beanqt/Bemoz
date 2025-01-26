<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'logs';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('type');
                $table->integer('element_id');
                $table->integer('action');
                $table->integer('user');
                $table->longText('data');
                $table->timestamps();
                $table->softDeletes();

                $table->index('type');
                $table->index('action');
                $table->index('element_id');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
