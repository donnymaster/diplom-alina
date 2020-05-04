<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefCategWorkCatId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_work', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('category_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_work', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
}
