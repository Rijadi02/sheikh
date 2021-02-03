<?php

namespace Database\Factories;

use App\Models\Episode;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'number' => $this->faker->numberBetween(0,100),
            'file' => $this->faker->word,
            'file_size' => $this->faker->numberBetween(7147435,141474350), // 48.8932
            'file_length' => $this->faker->numberBetween(300, 5000),
            'serie_id' => function() {
                return \App\Models\Serie::all()->random();
            }
        ];
    }
}
