<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEditionsTable extends Migration
{
    function up()
    {
        Schema::create('editions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('translation_id');
            $table->text('text');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('translation_id')
                  ->references('id')
                  ->on('translations')
                  ->onDelete('cascade');
        });
    }

    function down()
    {
        Schema::dropIfExists('editions');
    }
}
