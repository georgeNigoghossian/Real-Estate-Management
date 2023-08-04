<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
