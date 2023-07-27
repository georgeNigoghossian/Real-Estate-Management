<?php


namespace App\Services;

use App\Models\User;
use App\Models\UserNotification;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\ApnsConfig;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationSender
{
    public static function send(User $user, array $message): void
    {

        $messaging = app('firebase.messaging');

        // creating a notification
        $notification = Notification::fromArray([
            'title' => $message['title'],
            'body' => $message['body'],

        ]);

        UserNotification::create([
         'title' => $message['title'],
         'body' => $message['body'],
        ]);

       // for having notification sound on Apple devices
        $apn = ApnsConfig::fromArray([
            'sound' => "default"
        ]);

        $service_account = config('firebase.projects.app.credentials.file');
         (new Factory)->withServiceAccount($service_account);

         // attaching the notification to the message
        $message = CloudMessage::new()->withNotification($notification)
        ->withData([
            'user_id' => $user->id,
        ])->withApnsConfig($apn);

        if($user->fcm_token){
            $messaging->send(
                $message,
                $user->fcm_token
            );
        }
    }
}
