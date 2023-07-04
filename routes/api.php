<?php

use App\Http\Controllers\App\Property\PropertyController;
use App\Http\Controllers\App\UserController;
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
    Route::post('/reset-password', [PassportAuth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('resetpassword.api');
    Route::post('/register', [PassportAuth\RegisterController::class, 'register'])->name('register.api');
    Route::post('/login', [PassportAuth\LoginController::class, 'login'])->name('login.api');


});

Route::group(['middleware' => ['cors', 'json.response', 'oauth']], function () {
    Route::post('/oauth/token', [Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken']);

});

Route::group(['middleware' => ['auth:api', 'api', 'cors']], function () {
    Route::post('/logout', [PassportAuth\LoginController::class, 'logout'])->name('logout.api');
    Route::get('/resend-verification', [PassportAuth\VerificationController::class, 'resend'])->name('resend.api');
    Route::post('/report-client', [UserController::class, 'reportClient'])->name('user.report_client');
    Route::get('/delete', [UserController::class, 'delete'])->name('user.delete_account');

});
//Property Endpoints
Route::apiResource('/properties', PropertyController::class);
