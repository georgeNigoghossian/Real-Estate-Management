<?php

namespace App\Http\Controllers\PassportAuth;

use App\Http\Controllers\App\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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
