<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::create(
            [
                'name' => "admin",
            ]
        );
        // \App\Models\User::factory(10)->create();
        // \App\Models\WpRole::factory(3)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
       $this->call(WpRoleSeeder::class);
       $this->call(WpUserSeeder::class);
       $this->call(WpSiteSeeder::class);
     
    }
}
