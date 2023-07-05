<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(Request $request)
    {


        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);


        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        $accessToken = Auth::user()->createToken('authToken')->accessToken;

        $response=[
            'user' => Auth::user(),
            'access_token' => $accessToken,
        ];
        return $request->wantsJson()
            ? new JsonResponse($response, 200)
            : redirect()->intended($this->redirectPath());

    }

    public function logout(Request $request)
    {
        $tokenId = $request->user()->token()->id;

        app(TokenRepository::class)->revokeAccessToken($tokenId);
        app(RefreshTokenRepository::class)->revokeRefreshTokensByAccessTokenId($tokenId);

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    protected function loggedOut(Request $request)
    {
        return response()->json(['message'=>'logged out successfuly.']);
    }

    protected function authenticated(Request $request, $user)
    {
        //
    }
}
