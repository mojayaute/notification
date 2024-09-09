<?php

namespace Tests\Feature;


use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Channel;
use App\Models\Log;
use App\Models\Account;
use App\Http\Requests\LogStoreRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {

        parent::setUp();

        $account = Account::create(['name' => 'Notification Test']);

        $this->user = User::factory()->create([
            'account_id' => $account->id,
            'name' => 'John',
            'email' => 'johndoe@example.com',
            'owner' => true,
        ]);
        $this->category = Category::factory()->create();
        $this->channel = Channel::factory()->create();

        $this->user->categories()->attach($this->category->id);
        $this->user->channels()->attach($this->channel->id);
    }

    public function test_create_category_view()
    {
        $response = $this->actingAs($this->user)->get('/category');
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page->component('Category/Create'));
    }

    public function test_it_stores_logs()
    {
        
        Notification::fake();

        $request = [
            'category_id' => $this->category->id,
            'message' => 'Test log message'
        ];

        $this->mock(LogStoreRequest::class, function ($mock) use ($request) {
            $mock->shouldReceive('validated')->once()->andReturn($request);
        });

        $response = $this->actingAs($this->user)->post(route('category.store'), $request);

        $this->assertDatabaseHas('logs', [
            'user_id' => $this->user->id,
            'category_id' => $this->category->id,
            'channel_id' => $this->channel->id,
            'message' => 'Test log message',
        ]);

    }

    public function test_fails_to_store_logs_with_invalid_category_id()
    {
        Notification::fake();
        $invalidCategoryId = 999;
        $request = [
            'category_id' => $invalidCategoryId,
            'message' => 'Test log message'
        ];

        $response = $this->actingAs($this->user)->post(route('category.store'), $request);

        $response->assertRedirect();
        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $response->assertSessionHasErrors('category_id');

        $errors = session()->get('errors');
        $this->assertTrue($errors->has('category_id'));
        $this->assertEquals('The selected category does not exist.', $errors->first('category_id'));

    }

    public function test_fails_to_store_logs_with_empty_message()
    {
        Notification::fake();
        $emptyMessage = '';

        $request = [
            'category_id' => $this->category->id,
            'message' => $emptyMessage
        ];

        $response = $this->actingAs($this->user)->post(route('category.store'), $request);

        $response->assertRedirect();
        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $response->assertSessionHasErrors('message');

        $errors = session()->get('errors');
        $this->assertTrue($errors->has('message'));
        $this->assertEquals('The message is required.', $errors->first('message'));

    }
}
