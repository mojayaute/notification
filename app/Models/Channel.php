<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function logs()
    {
        return $this->hasMany(Log::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_channels');
    }
}