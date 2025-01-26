<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'form_content';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('form');
                $table->integer('type');
                $table->string('subject');
                $table->text('emails');
                $table->longText('content');
                $table->timestamps();
                $table->softDeletes();

                $table->index('form');
                $table->index('type');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
