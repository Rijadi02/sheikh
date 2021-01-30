<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Category::factory(10)->create();
        \App\Models\Speaker::factory(50)->create();
        \App\Models\Serie::factory(200)->create();
        \App\Models\Episode::factory(3000)->create();
    }
}
