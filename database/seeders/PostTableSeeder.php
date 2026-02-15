<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('App\Models\Post');

        for($i = 1 ; $i <= 3 ; $i++) {
            DB::table('posts')->insert([
                'title' => $faker->sentence(),
                'category_id' => 1,
                'is_highlighted' => $i === 1,
                'body' => $faker->paragraph(),
                'created_by' => 1,
                'is_published' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
