<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'activity';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('hash');
                $table->timestamps();

                $table->index('hash');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
