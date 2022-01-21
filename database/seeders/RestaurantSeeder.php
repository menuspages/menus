<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Database\Factories\RestaurantFactory;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return Restaurant::factory()->count(10)->make();
    }
}
