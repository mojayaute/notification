<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class EmailNotification extends Notification
{
    protected $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function send($notifiable)
    {
        //Add your logic here instead og logs
        Log::channel('notification')->info('Email notification sent.', [
            'message' => $this->message,
        ]);
    }
}
