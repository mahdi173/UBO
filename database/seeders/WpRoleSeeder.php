<?php

namespace Database\Seeders;

use App\Models\WpRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class WpRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dispatcher = WpRole::getEventDispatcher();
        WpRole::unsetEventDispatcher($dispatcher);
        WpRole::factory(10)->create();
        WpRole::setEventDispatcher($dispatcher);
    }
}
