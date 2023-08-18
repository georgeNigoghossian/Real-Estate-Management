<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\App\AppController;
use App\Http\Controllers\App\Notifications\FireBaseNotificationController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\VerifyAndRegisterRequest;
use App\Models\MobileVerification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

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
        //   $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'gender' => ['required'],
            'mobile' => ['required', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'fcm_token' => ['required', 'string']
        ]);
    }

    //Has no use currently
    public function register(Request $request)
    {

        $this->validator($request->all())->validate();

        return $request->wantsJson()
            ? AppController::response(true, null, "User Needs Verification")
            : redirect($this->redirectPath());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'mobile' => $data['mobile'],
            'gender' => $data['gender'],
            'password' => Hash::make($data['password']),

        ]);
        $role = Role::find(2);
        $user->roles()->attach($role);
        return $user;
    }

    protected function registered(Request $request, $user)
    {
        return response()->json(['message' => 'created account successfuly.']);
    }

    public function verifyAndRegister(VerifyAndRegisterRequest $request)
    {
        $storedVerificationCode = MobileVerification::where('mobile', $request->mobile)->first();

        if ($storedVerificationCode["verification_code"] == $request->verification_code) {
            $user = $this->create($request->all());
            $this->guard()->login($user);
            $accessToken = $user->createToken('authToken')->accessToken;
            FireBaseNotificationController::welcomeNotificationTrigger($request->fcm_token);
            $user->sms_verified_at = now();
            $user->save();
            if ($request->wantsJson()) {
                $data = [
                    'user' => Auth::user(),
                    'access_token' => $accessToken,
                ];
                return response()->json(["success" => true, "data" => $data, "message" => __("api.messages.success_user_creation"), "status" => 200]);
            }
        } else {
            if ($request->wantsJson()) {
                return response()->json(["success" => false, "data" => null, "message" => __("api.messages.failure_sms_number"), "status" => 403]);
            }
        }
    }

}
