<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $dispatcher = Type::getEventDispatcher();
    Type::unsetEventDispatcher($dispatcher);
    Type::factory(10)->create();
    Type::setEventDispatcher($dispatcher);
  }
}
