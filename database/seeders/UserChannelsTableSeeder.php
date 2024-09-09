<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Channel;

class UserChannelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $channels = Channel::all();

        if ($channels->isEmpty()) {
            $channels = Channel::factory(3)->create();
        }
        
        $users = User::all();
        $users->each(function ($user) use ($channels) {
            $user->channels()->attach(
                $channels->random(rand(1, $channels->count()))->pluck('id')
            );
        });
    }
}
