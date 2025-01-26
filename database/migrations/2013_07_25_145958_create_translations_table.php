<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'translator_translations';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->string('locale', 6);
                $table->string('namespace', 150)->default('*');
                $table->string('group', 150);
                $table->string('item', 150);
                $table->text('text');
                $table->boolean('unstable')->default(false);
                $table->boolean('locked')->default(false);
                $table->timestamps();
                $table->unique(['locale', 'namespace', 'group', 'item']);
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
