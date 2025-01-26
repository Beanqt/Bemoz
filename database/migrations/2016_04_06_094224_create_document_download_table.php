<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public $name = 'document_download';

    public function up(){
        if(!Schema::hasTable($this->name)){
            Schema::create($this->name, function(Blueprint $table){
                $table->id();
                $table->integer('document_id');
                $table->timestamps();
                $table->softDeletes();

                $table->index('document_id');
            });
        }
	}

    public function down(){
        Schema::dropIfExists($this->name);
    }
};
