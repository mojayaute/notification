<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Account;
use Inertia\Testing\AssertableInertia as Assert;

class UsersTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $account = Account::create(['name' => 'Notification Test']);

        $this->user = User::factory()->make([
            'account_id' => $account->id,
            'name' => 'John',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);
    }

    public function test_can_view_users()
    {
        User::factory()->count(5)->create(['account_id' => 1]);

        $this->actingAs($this->user)
            ->get('/users')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->component('Users/Index');
                $page->has('users.data', 5, function (Assert $page) {
                    $page->hasAll(['id', 'name', 'phone','email', 'owner', 'deleted_at']);
                });
            });
    }

    public function test_can_search_for_users()
    {
        User::factory()->count(5)->create(['account_id' => 1]);

        User::first()->update([
            'name' => 'david',
        ]);

        $this->actingAs($this->user)
            ->get('/users?search=david')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->where('filters.search', 'david');
                $page->has('users.data', 1, function (Assert $page) {
                    $page->where('name', 'david')->etc();
                });
            });
    }

    public function test_cannot_view_deleted_users()
    {
        User::factory()->count(5)->create(['account_id' => 1]);
        User::first()->delete();

        $this->actingAs($this->user)
            ->get('/users')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->has('users.data', 4);
            });
    }

    public function test_can_filter_to_view_deleted_users()
    {
        User::factory()->count(5)->create(['account_id' => 1]);
        User::first()->delete();

        $this->actingAs($this->user)
            ->get('/users?trashed=with')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->where('filters.trashed', 'with');
                $page->has('users.data', 5);
            });
    }
}
