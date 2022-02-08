<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text' => $this->faker->unique()->realText(20),
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date
        ];
    }
}
