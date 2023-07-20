<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function login(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        //$this->validateLogin($request);
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.

//        if (method_exists($this, 'hasTooManyLoginAttempts') &&
//            $this->hasTooManyLoginAttempts($request)) {
//            $this->fireLockoutEvent($request);
//            return $this->sendLockoutResponse($request);
//        }
        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }
            return $this->sendLoginResponse($request, $data);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function sendFailedLoginResponse(Request $request): JsonResponse
    {

        return response()->json(["success" => false, "data" => null, "message" => __('auth.failed'), "status" => 422]);
    }

    protected function credentials(Request $request): array
    {
        return $request->only('mobile', 'password');
    }

    /**
     * @throws ValidationException
     */
    protected function sendLoginResponse(Request $request, $data): JsonResponse|RedirectResponse
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($this->authenticated($request, $this->guard()->user())) {

            $accessToken = Auth::user()->createToken('authToken')->accessToken;

            $response = [
                'user' => Auth::user(),
                'access_token' => $accessToken,
            ];

            return $request->wantsJson()
                ? response()->json(["success" => true, "data" => $response, "message" => __("api.messages.log_in_successfully"), "status" => 200])
                : redirect()->intended($this->redirectPath());
        }
        return $this->sendFailedLoginResponse($request);
    }

    public function logout(Request $request): JsonResponse|Redirector|RedirectResponse|Application
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

    protected function loggedOut(Request $request): JsonResponse
    {
        return response()->json(["success" => true, "data" => null, "message" => __("api.messages.logged_out_successfuly"), "status" => 200]);

    }

    protected function authenticated(Request $request, $user): bool
    {
        return Hash::check($request->password, $user->password);
    }
}
