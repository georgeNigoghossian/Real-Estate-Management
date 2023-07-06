<?php

use App\Http\Controllers\PassportAuth\AuthenticatesUsersController;
use App\Http\Controllers\PassportAuth\LoginController;
use App\Http\Controllers\PassportAuth\RegisterController;
use App\Http\Controllers\PassportAuth\SMSVerificationController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::get('/sms/verify', [SMSVerificationController::class, 'showVerificationForm'])->name('sms.verify');
Route::post('/sms/verify', [SMSVerificationController::class, 'verify'])->name('sms.verify.post');

//Auth::routes(['verify' => true]);

Route::group(['middleware' => ['is_sms_verified']], function () {
    Route::post('/login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['auth', 'is_sms_verified']], function () {

    Route::post('/logout', [AuthenticatesUsersController::class, 'logout'])->name('logout');
    Route::get('/home', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('home');
});

