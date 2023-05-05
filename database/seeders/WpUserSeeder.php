<?php

namespace Database\Seeders;

use App\Models\WpUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WpUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dispatcher = WpUser::getEventDispatcher();
        WpUser::unsetEventDispatcher($dispatcher);
        WpUser::factory(10)->create();
        WpUser::setEventDispatcher($dispatcher);
    }
}
