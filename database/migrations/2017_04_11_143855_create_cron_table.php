<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'cron';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('type');
                $table->longText('content');
                $table->dateTime('run')->nullable();

                $table->index('type');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
