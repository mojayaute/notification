<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Channel;

class ChannelSeeder extends Seeder
{
    public function run()
    {
        Channel::factory()->createMany([
            ['name' => 'SMS'],
            ['name' => 'E-mail'],
            ['name' => 'Push notification'],
        ]);
    }
}
