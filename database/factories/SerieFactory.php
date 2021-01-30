<?php

namespace Database\Factories;

use App\Models\Serie;
use Illuminate\Database\Eloquent\Factories\Factory;

class SerieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Serie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->realText(250, 2),
            'image' => $this->faker->imageUrl(400, 400, 'cats'),
            'speaker_id' => function() {
                return \App\Models\Speaker::all()->random();
            },
            'category_id' => function() {
                return \App\Models\Category::all()->random();
            }
        ];
    }
}
