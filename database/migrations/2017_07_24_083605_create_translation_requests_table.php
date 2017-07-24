<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationRequestsTable extends Migration
{
    function up()
    {
        Schema::create('translation_requests', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('language_id');
            $table->unsignedInteger('requestable_id');
            $table->string('requestable_type');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->foreign('language_id')
                  ->references('id')
                  ->on('languages')
                  ->onDelete('cascade');
        });
    }

    function down()
    {
        Schema::dropIfExists('translation_requests');
    }
}
