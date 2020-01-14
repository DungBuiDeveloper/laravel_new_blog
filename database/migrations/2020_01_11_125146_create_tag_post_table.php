<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagPostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (Schema::hasTable('tag_post')) {
            Schema::dropIfExists('tag_post');
        }
        Schema::create('tag_post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('tag_id');
            $table->unsignedBigInteger('post_id');
            $table->timestamps();
        });

        Schema::table('tag_post', function (Blueprint $table) {
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tag_post');
    }
}
