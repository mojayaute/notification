<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;

class UserCategoriesTableSeeder extends Seeder
{
    public function run()
    {
        
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $categories = Category::factory(5)->create();
        }
        
        $users = User::all();

        $users->each(function ($user) use ($categories) {
            $user->categories()->attach(
                $categories->random(rand(1, $categories->count()))->pluck('id')
            );
        });
    }
}
