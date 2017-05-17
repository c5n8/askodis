<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('translatable_id');
            $table->string('translatable_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('language_id')
                  ->references('id')
                  ->on('languages')
                  ->onDelete('cascade');
        });
    }

    function down()
    {
        Schema::dropIfExists('translations');
    }
}
