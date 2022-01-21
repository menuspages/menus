<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->sentence,
            'logo_path' => 'burger.jpeg',
            'subdomain' => $this->faker->slug(),
            'manager_id' => User::factory(),
            'is_order' => $this->faker->boolean,
            'is_active' => $this->faker->boolean,
            'current_theme' => $this->faker->numberBetween(1,3),
            'available_themes' => "[1,2,3]",
            'open_from' => $this->faker->time(),
            'open_to' => $this->faker->time(),
            'phone' => $this->faker->phoneNumber,
            'google_map_location_link' => $this->faker->url,
            'facebook_link' => $this->faker->url,
            'twitter_link' => $this->faker->url,
            'instagram_link' => $this->faker->url,
            'snapchat_link' => $this->faker->url,
            'is_deleted' => $this->faker->boolean,
        ];
    }
}
