<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class LogCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'logs' => $this->collection->transform(function ($log) {
                return [
                    'id' => $log->id,
                    'message' => $log->message,
                    'created_at' => Carbon::parse($log->created_at)->format('Y-m-d'), 
                    'user' => [
                        'id' => $log->user->id,
                        'name' => $log->user->name,
                    ],
                    'category' => [
                        'id' => $log->category->id,
                        'name' => $log->category->name,
                    ],
                    'channel' => [
                        'id' => $log->channel->id,
                        'name' => $log->channel->name,
                    ],
                ];
            }),
            'pagination' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
            ],
        ];
    }
}
