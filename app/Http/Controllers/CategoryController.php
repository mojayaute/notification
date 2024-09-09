<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogStoreRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\User;
use App\Models\Log;
use Illuminate\Support\Carbon;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Notifications\NotificationFactory;

class CategoryController extends Controller
{
    public function create()
    {
        return Inertia::render('Category/Create', [
            'categories' => Category::all()
        ]);
    }

    public function store(LogStoreRequest $request)
    {
        $validated = $request->validated();
            $params = Request::all();
            $categoryId = $validated['category_id'];
             $message = $validated['message'];
             $userChannels = User::whereHas('categories', function($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            })->with('channels')->get()->map(function($user) use ($categoryId, $message) {
                return $user->channels->map(function($channel) use ($user, $categoryId, $message) {
                    return [
                        'user_id' => $user->id,
                        'category_id' => $categoryId,
                        'channel_id' => $channel->id,
                        'message' => $message,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                });
            })->flatten(1)->all();
        
            $logIds = DB::table('logs')->insert($userChannels);
            
            $logs = Log::whereIn('id', function ($query) use ($userChannels) {
                $query->select('id')
                      ->from('logs')
                      ->whereIn('channel_id', array_column($userChannels, 'channel_id'));
            })->get();
            
            $logs->each(function ($log) {
                $notification = NotificationFactory::create($log->channel->name, $log->message);
                $notification->send($log->message);
            });

           
            return redirect()->back()->with('success', 'Log entries have been created successfully.');
        
    }
}
