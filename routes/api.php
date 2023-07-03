<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors', 'json.response']], function () {
    Route::post('/resetpassword', [PassportAuth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('resetpassword.api');
    Route::post('/register', [PassportAuth\RegisterController::class, 'register'])->name('register.api');
    Route::post('/login', [PassportAuth\LoginController::class, 'login'])->name('login.api');


});

Route::group(['middleware' => ['cors', 'json.response', 'oauth']], function () {
    Route::post('/oauth/token', [Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);

});

Route::group(['middleware' => ['auth:api', 'api', 'cors']], function () {
    Route::post('/logout', [PassportAuth\LoginController::class, 'logout'])->name('logout.api');
    Route::get('/resendverification', [PassportAuth\VerificationController::class, 'resend'])->name('resend.api');
    Route::post('/reportClient', [\App\Http\Controllers\App\UserController::class, 'reportClient'])->name('user.report_client');
    Route::get('/delete', [\App\Http\Controllers\App\UserController::class, 'delete'])->name('user.delete_account');
});
