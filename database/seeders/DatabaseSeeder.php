<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Account;
use App\Models\Contact;
use App\Models\Organization;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $account = Account::create(['name' => 'Notification Test']);

        User::factory()->create([
            'account_id' => $account->id,
            'name' => 'david',
            'email' => 'david@example.com',
            'phone' => '7773875505',
            'owner' => true,
        ]);

        User::factory()->count(5)->create([
            'account_id' => $account->id
        ]);

        $this->call([
        CategorySeeder::class,
        ChannelSeeder::class,
        UserCategoriesTableSeeder::class,
        UserChannelsTableSeeder::class,]);

    }
}
