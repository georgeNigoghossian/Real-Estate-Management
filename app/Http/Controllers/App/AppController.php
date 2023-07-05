<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    public function response($success = false, $data = [], $message = null, $status = null)
    {
        $return = array(
            "success" => $success,
            "data" => $data,
            "message" => $message ,
            "status" => $status,
        );

        return $return;
    }
}
