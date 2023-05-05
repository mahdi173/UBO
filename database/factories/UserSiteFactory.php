<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\WpSite;
use App\Models\WpUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserSite>
 */
class UserSiteFactory extends Factory
{
    protected $model = UserSite::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = Role::inRandomOrder()->limit(rand(1, 3))->get()->pluck('name')->toArray();

        return [
            'user_id' => WpUser::inRandomOrder()->first()->id,
            'site_id' => WpSite::inRandomOrder()->first()->id,
            'username' => fake()->userName(),
            'etat' => fake()->randomElement(['added', 'updated', 'deleted']),
            'roles' => json_encode($roles)
        ];
    }
}
