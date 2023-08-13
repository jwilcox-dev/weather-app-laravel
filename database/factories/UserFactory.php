<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class UserFactory extends Factory
{
    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $user->createToken('api', ['all']);
        });
    }

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(60),
        ];
    }

    public function testUser(): static
    {
        return $this->state(fn (array $attributes) => [
            'email' => 'test.user@email.com',
        ]);
    }
}
