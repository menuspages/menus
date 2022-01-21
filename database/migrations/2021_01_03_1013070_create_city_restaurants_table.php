<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCityRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cityrestaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->longText('image');
            $table->string('menu_link');
            $table->string('map_link');
            $table->string('phone');

            $table->boolean('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cityrestaurants');
    }
}
