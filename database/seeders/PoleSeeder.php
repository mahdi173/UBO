<?php

namespace Database\Seeders;

use App\Models\Pole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dispatcher = Pole::getEventDispatcher();
        Pole::unsetEventDispatcher($dispatcher);
        Pole::factory(10)->create();
        Pole::setEventDispatcher($dispatcher);
    }
}
