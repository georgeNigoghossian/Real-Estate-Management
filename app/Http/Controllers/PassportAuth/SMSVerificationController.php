<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SMSVerificationController extends Controller
{
    public function showVerificationForm()
    {
        return view('auth.sms_verification');
    }

    public function verify(Request $request)
    {
        $user = auth()->user();
        $submittedverificationCode = $request->input('verification_code');
        $verificationCode = $user->sms_verification_code;
        if($submittedverificationCode==$verificationCode){
            $user->sms_verified_at = now();
            $user->save();
        }

        return redirect()->route('home');
    }
}
