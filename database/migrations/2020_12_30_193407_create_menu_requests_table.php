<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_requests', function (Blueprint $table) {
            $table->id();
            $table->string('restaurant_name');
            $table->string('subdomain');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->integer('status')->default(\App\Constants\MenuRequestStatus::NEW);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_requests');
    }
}
