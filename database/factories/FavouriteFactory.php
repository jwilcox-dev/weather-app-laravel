<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavouriteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random(),
            'post_code' => $this->faker->postcode(),
            'description' => $this->faker->company(),
        ];
    }

    public function testFavourite(): static
    {
        return $this->state(fn (array $attributes) => [
            'user_id' => 1,
            'post_code' => 'ST18 0WP',
            'description' => 'Stafford Office',
            'notifications' => true
        ]);
    }
}
