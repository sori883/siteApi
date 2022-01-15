<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ArticleFactory extends Factory
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
            'image_id' => null,
            'title' => $this->faker->realText(10),
            'entry' => $this->faker->realText(500),
            'permalink' => $this->faker->unique()->userName(),
            'publish_at' => $this->faker->date,
            'created_at' => $this->faker->date,
            'updated_at' => $this->faker->date
        ];
    }
}
