<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'admins';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('name');
                $table->string('email');
                $table->string('password');
                $table->string('remember_token');
                $table->boolean('tutorial')->default(1);
                $table->integer('group');
                $table->integer('wrong');
                $table->boolean('first_login');
                $table->dateTime('ban')->nullable();
                $table->timestamps();
                $table->softDeletes();

                $table->index('email');
                $table->index('password');
                $table->index('group');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
