<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFkCategories extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('category_parent', function (Blueprint $table) {
            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('cat_pa_id')->references('id')->on('categories')->onDelete('cascade');
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
