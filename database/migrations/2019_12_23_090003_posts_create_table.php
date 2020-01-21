<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PostsCreateTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('title', 255);
            $table->text('content');
            $table->string('video')->nullable();
            $table->string('slug')->unique();
            $table->text('the_excerpt')->nullable();
            $table->unsignedBigInteger('author_id');
            $table->string('type_thumb', 50);
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            $table->foreign('author_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        //
    }
}
