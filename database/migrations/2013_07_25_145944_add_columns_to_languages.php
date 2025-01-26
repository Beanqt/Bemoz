<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration{
    public function up(){
        Schema::table('translator_languages', function (Blueprint $table) {
            $table->boolean('active')->after('name');
            $table->integer('order')->after('active');

            $table->index('active');
        });
    }

    public function down(){

    }
};
