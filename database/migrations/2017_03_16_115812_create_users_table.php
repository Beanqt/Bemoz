<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'users';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('name');
                $table->string('email', 100);
                $table->string('password');
                $table->string('remember_token');
                $table->string('phone');
                $table->string('hash');
                $table->string('reminder')->nullable();
                $table->integer('group');
                $table->boolean('active');
                $table->dateTime('last_login');
                $table->boolean('newsletter');
                $table->timestamps();
                $table->softDeletes();

                $table->index('name');
                $table->index('password');
                $table->index('active');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
