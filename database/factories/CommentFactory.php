<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'article_id' => null,
            'name' => $this->faker->name(),
            'comment_entry' => $this->faker->unique()->realText(30),
            'publish_at' => $this->faker->date,
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date
        ];
    }
}
