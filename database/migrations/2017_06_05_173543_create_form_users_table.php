<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'form_users';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('form');
                $table->text('page');
                $table->longText('data');
                $table->timestamps();
                $table->softDeletes();

                $table->index('form');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
