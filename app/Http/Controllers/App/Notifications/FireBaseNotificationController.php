<?php

namespace App\Http\Controllers\App\Notifications;

use App\Http\Controllers\Controller;
use App\Http\Requests\Notification\NotificationRequest;
use App\Models\Notification;
use App\Models\User;
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
            'title' => $data['title'],
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
            $users = User::whereIn('fcm_token', $registration_ids)->get();

        }
        $db_notification->users()->attach($users);
        return $this->response([
            "success" => true
        ]);
    }


    public static function welcomeNotificationTrigger($user_fcm_token)
    {
        $notification = [];
        $notification['title'] = __("Welcome to Nostra Casa!");
        $notification['body'] = __("Find your perfect home with us");
        $notification['android_channel_id'] = "nostra_casa";
        $notification['icon'] = "app_icon";
        $notification['content_available'] = "true";
        $notification['sound'] = "default";
        $notification['color'] = "#333333";
        $db_notification = [
            'title' => $notification['title'],
            'body' => $notification['body']
        ];
        $registration_ids = [];
        $registration_ids[0] = $user_fcm_token;
        Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => env('FIREBASE_TOKEN'),
                'Content-Type' => 'application/json'
            ])->post('https://fcm.googleapis.com/fcm/send', [
                "registration_ids" => $registration_ids,
                'notification' => $notification,
                "priority" => "High"
            ]);
        $user = User::where('fcm_token', $user_fcm_token)->get();
        $db_notification = Notification::create($db_notification);
        $db_notification->users()->attach($user);
    }


    public static function changesNotificationTrigger($property)
    {
        $notification = [];
        $notification['title'] = __("GOOD NEWS");
        $notification['body'] = __("A property you are interested in has made some changes");
        $notification['android_channel_id'] = "nostra_casa";
        $notification['icon'] = "app_icon";
        $notification['content_available'] = "true";
        $notification['sound'] = "default";
        $notification['color'] = "#333333";
        $db_notification = [
            'title' => $notification['title'],
            'body' => $notification['body']
        ];
        $topic = '/topics/Property' . $property->id;
        Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => env('FIREBASE_TOKEN'),
                'Content-Type' => 'application/json'
            ])->post('https://fcm.googleapis.com/fcm/send', [
                "to" => $topic,
                'notification' => $notification,
                "priority" => "High"
            ]);
        $users = User::whereHas('savedProperties', function ($q) use ($property) {
            return $q->where('properties.id', '=', $property->id);
        })->get();
        $db_notification = Notification::create($db_notification);
        $db_notification->users()->attach($users);
    }

    public static function PromoteAgencyNotificationTrigger($user_fcm_token)
    {
        $notification = [];
        $notification['title'] = __("Agency Promotion");
        $notification['body'] = __("Your promotion request to an agency has been recorded");
        $notification['android_channel_id'] = "nostra_casa";
        $notification['icon'] = "app_icon";
        $notification['content_available'] = "true";
        $notification['sound'] = "default";
        $notification['color'] = "#333333";
        $db_notification = [
            'title' => $notification['title'],
            'body' => $notification['body']
        ];
        $registration_ids = [];
        $registration_ids[0] = $user_fcm_token;
        Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => env('FIREBASE_TOKEN'),
                'Content-Type' => 'application/json'
            ])->post('https://fcm.googleapis.com/fcm/send', [
                "registration_ids" => $registration_ids,
                'notification' => $notification,
                "priority" => "High"
            ]);

        $user = User::where('fcm_token', $user_fcm_token)->get();
        $db_notification = Notification::create($db_notification);
        $db_notification->users()->attach($user);
    }
}
