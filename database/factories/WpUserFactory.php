<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;



 /**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WpUser>
 */
class WpUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'userName' => fake()->name,
            'firstName' => fake()->name,
            'lastName' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('secret')
        ];
    }
}
