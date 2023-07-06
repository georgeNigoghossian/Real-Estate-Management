<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
