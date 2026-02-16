<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 3; $i++) {
            $postId = DB::table('posts')->insertGetId([
                'category_id' => 1,
                'is_highlighted' => $i === 1,
                'created_by' => 1,
                'is_published' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('post_translations')->insert([
                [
                    'post_id' => $postId,
                    'locale' => 'pt',
                    'title' => $faker->sentence(),
                    'body' => $faker->paragraph(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'post_id' => $postId,
                    'locale' => 'en',
                    'title' => $faker->sentence(),
                    'body' => $faker->paragraph(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);
        }
    }
}
