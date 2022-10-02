<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Article::factory()->count(20)
            ->has(\App\Models\Tag::factory()->count(3))
            ->create([
                'user_id' => \App\Models\User::first(),
                'image_id' => \App\Models\Image::first(),
            ]);
    }
}
