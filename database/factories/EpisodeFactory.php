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
            'file_size' => $this->faker->numberBetween(0,100), // 48.8932
            'file_length' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'serie_id' => function() {
                return \App\Models\Serie::all()->random();
            }
        ];
    }
}
