<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'feed_item_labels';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->integer('item');
                $table->integer('label');

                $table->index('item');
                $table->index('label');
            });
        }
    }

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
