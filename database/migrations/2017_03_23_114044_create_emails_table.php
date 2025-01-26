<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'emails';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('title');
                $table->longText('subject');
                $table->longText('content');
                $table->timestamps();
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
