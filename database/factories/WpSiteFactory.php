<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Pole;
use App\Models\Type;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WpSite>
 */
 
class WpSiteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'domain' => $this->faker->text(),
        
        ];
    }
}
