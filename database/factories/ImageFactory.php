<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => null,
            'title' => $this->faker->unique()->realText(20),
            'path' => $this->faker->unique()->slug(3),
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date
        ];
    }
}
