<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\Property\Tag;
use App\Models\User;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use JsValidator;

class NotificationController extends Controller
{


    public function create()
    {


        $validation_rules = [
            "message" => "required",
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

        $users = User::where('is_blocked','!=','1')->get();
        return view('admin.notification.create', compact('jsValidator', 'breadcrumb','users'));
    }

    public function send(Request $request)
    {

        $validation_rules = [
            "message" => "required",
        ];
        $request->validate($validation_rules);

        //To be implemented
        return redirect()->back();
    }


}
