<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Role::create(['name' => "admin",]);
        Role::create(['name' => "manager",]);
        Role::create(['name' => "user",]);

        $dispatcher = User::getEventDispatcher();
        User::unsetEventDispatcher($dispatcher);
        // Create Admin
        $adminRoleId = Role::where('name', 'admin')->first()->id;
        User::firstOrCreate(
            ['email' => "admin@email.com"],
            [
                'role_id' => $adminRoleId,
                'password' => bcrypt('admin')
            ]
        );

        User::factory()->count(3)->create();
        User::setEventDispatcher($dispatcher);

        $this->call(WpRoleSeeder::class);
        $this->call(WpUserSeeder::class);
        $this->call(PoleSeeder::class);
        $this->call(TypeSeeder::class);
        $this->call(WpSiteSeeder::class);
        $this->call(LogSeeder::class);
    }
}
