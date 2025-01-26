<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'search';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('key');
                $table->integer('user_id');
                $table->timestamps();

                $table->index('key');
                $table->index('user_id');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
