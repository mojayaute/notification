<?php

namespace App\Notifications;

class NotificationFactory
{
    public static function create(string $type, string $message)
    {
        switch ($type) {
            case 'SMS':
                return new SMSNotification($message);
            case 'E-mail':
                return new EmailNotification($message);
            case 'Push notification':
                return new PushNotification($message);
            default:
                throw new \Exception("Unknown notification type: $type");
        }
    }
}
