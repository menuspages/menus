<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNoticedAtFinishedAtRestaurantIdColumnsToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('noticed_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->integer('restaurant_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('noticed_at');
            $table->dropColumn('finished_at');
            $table->dropColumn('restaurant_id');
        });
    }
}
