<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Property\Tag;
use App\Models\User;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use JsValidator;

class NotificationController extends Controller
{


    public function create()
    {


        $validation_rules = [
            "title" => "required",
            "body" => "required",
        ];

        $jsValidator = JsValidator::make($validation_rules);

        $breadcrumb = [
            '0' => [
                'title' => "Dashboard",
                'url' => route('admin.home'),
            ],
            '1' => [
                'title' => "Create Notification",
            ]
        ];

        $users = User::where('is_blocked', '!=', '1')->get();
        return view('admin.notification.create', compact('jsValidator', 'breadcrumb', 'users'));
    }

    public function send(Request $request)
    {
        $notification = [];

        $validation_rules = [
            "title" => "required",
            "body" => "required",
        ];

        $request->validate($validation_rules);
        $data = $request->toArray();


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

        if (array_key_exists("sendTo", $data) && $data["sendTo"] == "all") {
            $users = User::where('is_blocked', 0)->get();
            foreach ($users as $key => $user) {
                $data["registration_ids"][$key] = $user->fcm_token;
            }
        }

        if (array_key_exists("sendTo", $data) && $data["sendTo"] == "specific") {
            $users = User::where('is_blocked', 0)->whereIn('id', $data["selectedUsers"])->get();
            foreach ($users as $key => $user) {
                $data["registration_ids"][$key] = $user->fcm_token;
            }
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
        session()->flash('success', 'Notification sent successfully!');
        return redirect()->back();
    }


}
