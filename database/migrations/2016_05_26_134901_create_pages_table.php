<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'pages';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('lang');
                $table->string('title');
                $table->string('slug');
                $table->longText('content');
                $table->boolean('active');
                $table->dateTime('public_at');
                $table->dateTime('finish_at');
                $table->boolean('auth');
                $table->timestamps();
                $table->softDeletes();

                $table->index('lang');
                $table->index('slug');
                $table->index('active');
                $table->index('auth');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
