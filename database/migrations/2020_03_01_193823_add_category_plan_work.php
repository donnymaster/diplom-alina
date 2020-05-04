<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoryPlanWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('plan_works', function (Blueprint $table) {
            $table->foreign('category_id')->references('id')->on('category_work');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plan_works', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }
}
