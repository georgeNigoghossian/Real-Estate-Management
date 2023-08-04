<?php

namespace App\Http\Controllers\App\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;

class FireBaseNotificationController extends Controller
{
    public function send(NotificationRequest $request): JsonResponse
    {
        $notification = [];
        $data = $request->validated();
        $body = $request->$data['body'];
        $title = $request->$data['title'];
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

        return $this->response([
            "success" => true,
            "data" => $data,
        ]);
    }
}
