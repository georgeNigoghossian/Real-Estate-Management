<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class VerifySMS
{
    public function handle($request, Closure $next)
    {
        // Check if the user has a verified SMS (add your verification logic here)

        if (Auth::check() && Auth::user()->sms_verified_at === null) {
            if ($request->expectsJson()){

                return response()->json(["success" => false, "data" =>null , "message" => __("api.messages.verify_sms_number"), "status" => 403]);

            }

            else
                return redirect()->route('sms.verify');
        }


        return $next($request);
    }
}
