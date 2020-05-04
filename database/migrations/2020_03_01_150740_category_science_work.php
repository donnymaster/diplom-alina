<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CategoryScienceWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_work', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('category_name');
            $table->unsignedBigInteger('category_id');

            $table->softDeletesTz();
            $table->timestampsTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_work');
    }
}
