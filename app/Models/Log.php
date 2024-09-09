<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Notifications\NotificationFactory;

use App\Models\Channel;

class Log extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'channel_id', 'message', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    public function notify()
    {
        $notification = NotificationFactory::create($this->notification_type);
        $notification->send($this->message);
    }

    public function scopeFilter($query, $filters)
    {
        if (isset($filters['search']) && $filters['search']) {
            $query->where('message', 'like', '%' . $filters['search'] . '%')
                ->orWhereHas('user', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['search'] . '%');
                })
                ->orWhereHas('category', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['search'] . '%');
                })
                ->orWhereHas('channel', function ($query) use ($filters) {
                    $query->where('name', 'like', '%' . $filters['search'] . '%');
                });
        }

        return $query;
    }
}