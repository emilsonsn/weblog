<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // categorias pra um blog de programação e portifolio
        $categories = [
            'Insights',
            'Tech',
            'Programming',
            'Career',
            'Personal Development',
            'Projects',
            'Tutorials',
            'Reviews',
            'Industry Trends',
            'Work-Life Balance',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'title' => $category,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
