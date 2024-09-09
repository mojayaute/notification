<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia as Assert;
use App\Models\Log;
use App\Models\User;
use Tests\TestCase;
use App\Models\Account;
class LogsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $account = Account::create(['name' => 'Notification Test']);

        $this->user = User::factory()->create([
            'account_id' => $account->id,
            'name' => 'John',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);
    }

    public function test_it_displays_logs()
    {
        User::factory()->count(1)->create(['account_id' => 1]);
        Log::factory()->create(['user_id' => $this->user->id, 'message' => 'Test log 1']);
        Log::factory()->create(['user_id' => $this->user->id, 'message' => 'Test log 2']);


        $this->actingAs($this->user)
            ->get('/')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->component('Log/Index');
                $page->has('logs.data.logs', 2, function (Assert $page) {
                    $page->hasAll(['id', 'message', 'user','category', 'channel' ,'created_at']);
                });
            });
    }

    public function test_can_search_for_logs()
    {
        User::factory()->count(1)->create(['account_id' => 1]);

        Log::factory()->create(['user_id' => $this->user->id, 'message' => 'Test log 1']);

        $this->actingAs($this->user)
            ->get('/?search=Test log 1')
            ->assertStatus(200)
            ->assertInertia(function (Assert $page) {
                $page->where('filters.search', 'Test log 1');
                $page->has('logs.data.logs', 1, function (Assert $page) {
                    $page->where('message', 'Test log 1')->etc();
                });
            });
    }

}
