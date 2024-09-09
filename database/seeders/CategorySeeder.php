<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::factory()->createMany([
            ['name' => 'Sports'],
            ['name' => 'Finance'],
            ['name' => 'Movies'],
        ]);
    }
}
