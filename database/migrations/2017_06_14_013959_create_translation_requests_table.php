<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationRequestsTable extends Migration
{
    function up()
    {
        Schema::create('translation_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('origin_language_id');
            $table->unsignedInteger('target_language_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('translatable_id');
            $table->string('translatable_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('origin_language_id')
                  ->references('id')
                  ->on('languages')
                  ->onDelete('cascade');

            $table->foreign('target_language_id')
                  ->references('id')
                  ->on('languages')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    function down()
    {
        Schema::dropIfExists('translation_requests');
    }
}
