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
        $notification['title'] = $data['title'];
        $notification['body'] = $data['body'];
        $notification['android_channel_id'] = "nostra_casa";
        $notification['icon'] = "app_icon";
        $notification['content_available'] = "true";
        $notification['sound'] = "default";
        $notification['color'] = "#333333";
        $db_notification = [
            'head' => $data['title'],
            'body' => $data['body']
        ];
        if (array_key_exists('image', $data)) {
            $notification['image'] = $data['image'];
            $db_notification['image'] = $data['image'];
        }
        $db_notification = Notification::create($db_notification);
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => env('FIREBASE_TOKEN'),
                'Content-Type' => 'application/json'
            ]);
        if (array_key_exists('to', $data)) {
            $to = $data['to'];
            $response->post('https://fcm.googleapis.com/fcm/send', [
                "to" => $to,
                "priority" => "High",
                'notification' => $notification
            ]);
            $users = User::all();
        }
        if (array_key_exists('registration_ids', $data)) {
            $registration_ids = $data['registration_ids'];
            $response->post('https://fcm.googleapis.com/fcm/send', [
                "registration_ids" => $registration_ids,
                'notification' => $notification,
                "priority" => "High"
            ]);
            $users = User::whereIn('fcm_token', $registration_ids);

        }
        $db_notification->users()->attach($users);
        return $this->response([
            "success" => true
        ]);
    }
}
