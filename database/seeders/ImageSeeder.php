<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Image::factory()->count(20)
        ->create([
            'user_id' => \App\Models\User::first(),
        ]);
    }
}
