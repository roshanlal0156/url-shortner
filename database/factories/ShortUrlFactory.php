<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShortUrl>
 */
class ShortUrlFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return
            [
                'long_url' => $this->faker->url(),
                'short_url' => $this->faker->unique()->word(),
                'hits' => $this->faker->numberBetween(0, 1000),
                'created_by' => User::inRandomOrder()->first()->id ?? User::factory(), // Ensure at least 1 user exists
        ];
    }
}
