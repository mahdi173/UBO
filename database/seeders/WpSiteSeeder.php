<?php

namespace Database\Seeders;

use App\Models\WpSite;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WpSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dispatcher = WpSite::getEventDispatcher();
        WpSite::unsetEventDispatcher($dispatcher);
        WpSite::factory(50)->create();
        WpSite::setEventDispatcher($dispatcher);
    }
}
