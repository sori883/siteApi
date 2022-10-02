<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
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
            'name' => $this->faker->unique()->realText(10),
            'slug' => $this->faker->unique()->regexify('[a-z]{4}[0-9]{4}'),
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date
        ];
    }
}
