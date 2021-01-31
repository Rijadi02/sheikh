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
        $users = \App\Models\User::factory(1000)->create();
        \App\Models\Category::factory(10)->create();
        \App\Models\Speaker::factory(50)->create();
        \App\Models\Serie::factory(200)->create();
        \App\Models\Episode::factory(3000)->create();

        \App\Models\Serie::All()->each(function ($serie) use ($users){
            $serie->subscribed()->attach((rand(1,200)));
        });

        \App\Models\Episode::All()->each(function ($episode) use ($users){
            $episode->activity()->attach((rand(1,500)));
        });

        \App\Models\Speaker::All()->each(function ($speaker) use ($users){
            $speaker->subscribed()->attach((rand(1,200)));
        });
    }
}
