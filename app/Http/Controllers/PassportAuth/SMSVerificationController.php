<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\MobileVerification;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SMSVerificationController extends Controller
{
    use RegistersUsers;
    public function showVerificationForm()
    {
        return view('auth.sms_verification');
    }

    public function verify(Request $request)
    {

        $verificationCode = rand(1000, 9999);
        $gsm = $request->mobile;
        $record = MobileVerification::where('mobile',$gsm)->first();
        if($record){
            $record->update([
                'verification_code'=>$verificationCode,
            ]);
        }else {
            MobileVerification::create([
                'mobile'=>$gsm,
                'verification_code'=>$verificationCode,
            ]);
        }
        if (substr($gsm, 0, 1) === "0") {
            $gsm = "963" . substr($gsm, 1);
        } elseif (substr($gsm, 0, 4) === "+963") {
            $gsm = "963" . substr($gsm, 4);
        }
        $message = "\"Your verification code is: $verificationCode\"";

        $url = "https://services.mtnsyr.com:7443/general/MTNSERVICES/ConcatenatedSender.aspx?User=ppa277&Pass=dnat121717&From=Road Ride&Gsm=$gsm&Msg=$message&Lang=1";

        //$response = Http::post($url);

        $appController = new AppController();
        return $request->wantsJson()
            ? $appController->response(true,null,"SMS Verification Code Sent",200)
            : redirect($this->redirectPath());
    }


}
