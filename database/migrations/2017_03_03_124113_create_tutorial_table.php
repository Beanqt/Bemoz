<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'tutorial';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('user');
                $table->longText('tutorial');

                $table->index('user');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
