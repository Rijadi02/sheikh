<?php

namespace Database\Seeders;

use App\Models\Serie;
use App\Models\User;
use Carbon\Carbon;
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
        $users = User::factory(50)->create();
        \App\Models\Category::factory(10)->create();
        $speakers = \App\Models\Speaker::factory(50)->create();
        $series = Serie::factory(200)->create();
        $episodes = \App\Models\Episode::factory(3000)->create();


        $users->each(function (User $r) use ($series) {
            $array = [];
            for($i = 0; $i < rand(5,20); $i++)
            {
                $x = rand(1,200);
                while(in_array($x, $array))
                {
                    $x = rand(1,200);
                }
                $r->series()->attach($x);
                array_push($array,$x);
            }
        });

        $users->each(function (User $r) use ($speakers) {
            $array = [];
            for($i = 0; $i < rand(3,10); $i++)
            {
                $x = rand(1,50);
                while(in_array($x, $array))
                {
                    $x = rand(1,50);
                }
                $r->speakers()->attach($x);
                array_push($array,$x);
            }
        });

        $users->each(function (User $r) use ($episodes) {
            $array = [];
            for($i = 0; $i < rand(200,1000); $i++)
            {
                $x = rand(0,3000);
                while(in_array($x, $array))
                {
                    $x = rand(1,3000);
                }
                $r->episodes()->attach($x, ["history" => Carbon::now(), "watch_later" => Carbon::now(), "download" => Carbon::now()]);
                array_push($array,$x);
            }
        });

        // \App\Models\Serie::All()->each(function ($serie) use ($users){
        //     $serie->subscribed()->attach((rand(1,200)));
        // });

        // \App\Models\Episode::All()->each(function ($episode) use ($users){
        //     $episode->activity()->attach((rand(1,500)));
        // });

        // \App\Models\Speaker::All()->each(function ($speaker) use ($users){
        //     $speaker->subscribed()->attach((rand(1,200)));
        // });
    }
}
