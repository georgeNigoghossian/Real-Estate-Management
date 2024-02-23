<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class AppController extends Controller
{
    public static function response($success = false, $data = [], $message = null, $status = 200): JsonResponse
    {
        return response()->json(
            [
                "success" => $success,
                "data" => $data,
                "message" => $message,
                "status" => $status,
            ]
        );
    }
}
