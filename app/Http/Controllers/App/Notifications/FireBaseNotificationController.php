<?php

namespace App\Http\Controllers\App\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationRequest;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class FireBaseNotificationController extends Controller
{
    public function send(NotificationRequest $request): JsonResponse
    {
        $notification = [];
        $data = $request->validated();
        $body = $data['body'];
        $title = $data['title'];
        if (array_key_exists('image', $data)) {
            $image = $request->$data['image'];
            $notification['image'] = $image;
        }
        $notification['body'] = $body;
        $notification['title'] = $title;
        $notification['android_channel_id'] = "nostra_casa";
        $notification['icon'] = "app_icon";
        $notification['content_available'] = "true";
        $notification['sound'] = "default";
        $notification['color'] = "#333333";

        $data = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => env('FIREBASE_TOKEN'),
                'Content-Type' => 'application/json'
            ])->
            post('https://fcm.googleapis.com/fcm/send', [
                "to" => "/topics/Public",
                "priority" => "High",
                'notification' => $notification
            ]);

        $db_notification = Notification::create([
            'head' => $title,
            'body' => $body
        ]);
        $users = User::all();
        $db_notification->users()->attach($users);
        return $this->response([
            "success" => true,
            "data" => $data,
        ]);
    }
}
