<?php

namespace App\Http\Controllers;

use App\Http\Resources\RecordCollection;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Models\Log;
use App\Http\Resources\LogCollection;

class LogController extends Controller
{
    public function index(Request $request)
    {   
        $user = Auth::user();
        $logs = Log::with(['user', 'category', 'channel'])
        ->orderBy('created_at', 'DESC')
        ->filter(Request::only('search'))  
        ->paginate(10)
        ->appends(Request::all());

        return Inertia::render('Log/Index', [
            'filters' => Request::all('search'),
            'logs' => new LogCollection($logs),
        ]);
    }
}
