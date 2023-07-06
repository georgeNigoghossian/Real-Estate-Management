<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            //'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'gender'=>['required'],
            'mobile'=>['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        $this->guard()->login($user);

        $verificationCode = rand(1000, 9999);
        $user->sms_verification_code=$verificationCode;
        $user->save();

        $gsm = $request->mobile;
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
            ? $appController->response(true,$user,"User Created But Needs Verification",200)
            : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        return User::create([
            'name' => $data['name'],
            'email' => $data['email']??null,
            'mobile' => $data['mobile'],
            'gender'=>$data['gender'],
            'password' => Hash::make($data['password']),

        ]);
    }

    protected function registered(Request $request, $user)
    {
        return response()->json(['message'=>'created account successfuly.']);
    }


}
