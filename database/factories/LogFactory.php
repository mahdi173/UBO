<?php

namespace Database\Factories;

use App\Models\Log;
use App\Models\Pole;
use App\Models\Role;
use App\Models\Type;
use App\Models\User;
use App\Models\WpRole;
use App\Models\WpSite;
use App\Models\WpUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition()
    {
        $loggable = fake()->randomElement([
            Pole::inRandomOrder()->first(),
            Role::inRandomOrder()->first(),
            Type::inRandomOrder()->first(),
            User::inRandomOrder()->first(),
            WpSite::inRandomOrder()->first(),
            WpRole::inRandomOrder()->first(),
            WpUser::inRandomOrder()->first()
        ]);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'user_name' => fake()->userName,
            'action' => fake()->randomElement(['created', 'updated', 'deleted']),
            'status' => fake()->randomElement(['success', 'failed']),
            'json_detail' => json_encode(['key' => fake()->text(10)]),
            'loggable_type' => get_class($loggable),
            'loggable_id' => $loggable->id
        ];
    }
}
