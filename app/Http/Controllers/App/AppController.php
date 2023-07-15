<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public static function response($success = false, $data = [], $message = null, $status = 200): array
    {
        return array(
            "success" => $success,
            "data" => $data,
            "message" => $message ,
            "status" => $status,
        );
    }
}
