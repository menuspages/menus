<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('logo_path');
            $table->integer('manager_id')->nullable();
            $table->integer('is_order')->default(0);
            $table->integer('is_active')->default(1);
            $table->integer('current_theme')->default(1);
            $table->string('available_themes')->default("[1]");
            $table->time('open_from')->nullable();
            $table->time('open_to')->nullable();
            $table->string('phone')->nullable();
            $table->string('google_map_location_link')->nullable();
            $table->string('facebook_link')->nullable();
            $table->string('twitter_link')->nullable();
            $table->string('instagram_link')->nullable();
            $table->string('snapchat_link')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('restaurants');
    }
}
