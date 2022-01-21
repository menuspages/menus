<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCaloriesIsVisibleIsAvailableToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table){
            $table->float('calories')->nullable();
            $table->boolean('is_visible')->default(1);
            $table->boolean('is_available')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table){
            $table->dropColumn('calories');
            $table->dropColumn('is_visible');
            $table->dropColumn('is_available');
        });
    }
}
