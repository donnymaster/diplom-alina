<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRefTypeWorkCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('type-works', function (Blueprint $table) {
            $table->foreign('category_name_id')->references('id')->on('category_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('type-works', function (Blueprint $table) {
            $table->dropForeign(['category_name_id']);
        });
    }
}
