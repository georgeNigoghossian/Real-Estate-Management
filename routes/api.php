<?php

use App\Http\Controllers\App\Agency\AgencyController;
use App\Http\Controllers\App\Location\CityController;
use App\Http\Controllers\App\Location\RegionController;
use App\Http\Controllers\App\Notifications\FireBaseNotificationController;
use App\Http\Controllers\App\Property\AgriculturalController;
use App\Http\Controllers\App\Property\AmenityController;
use App\Http\Controllers\App\Property\CommercialController;
use App\Http\Controllers\App\Property\PropertyController;
use App\Http\Controllers\App\Property\ResidentialController;
use App\Http\Controllers\App\Property\TagController;
use App\Http\Controllers\App\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PassportAuth;
use App\Http\Controllers\PassportAuth\SMSVerificationController;

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
    Route::post('/sms/verify', [SMSVerificationController::class, 'verify'])->name('sms.verify.post.api');
    Route::post('/sms/verify-and-register', [PassportAuth\RegisterController::class, 'verifyAndRegister'])->name('sms.verify_and_register.post.api');
});
Route::post('/send-notification', [FireBaseNotificationController::class,'send']);
Route::group(['middleware' => ['cors', 'json.response', 'is_sms_verified']], function () {
    Route::post('/oauth/token', [Laravel\Passport\Http\Controllers\AccessTokenController::class, 'issueToken'])->middleware(['oauth']);
    Route::post('/login', [PassportAuth\LoginController::class, 'login'])->name('login.api');
});

Route::group(['prefix' => 'user', 'middleware' => ['auth:api', 'api', 'cors', 'is_sms_verified']], function () {
    Route::get('/logout', [PassportAuth\LoginController::class, 'logout'])->name('logout.api');
    Route::get('/resend-verification', [PassportAuth\VerificationController::class, 'resend'])->name('resend.api');
    Route::post('/report-client', [UserController::class, 'reportClient'])->name('user.report_client');
    Route::get('/delete', [UserController::class, 'delete'])->name('user.delete_account');
    Route::get('/view', [UserController::class, 'show'])->name('user.show_account');
    Route::post('/update', [UserController::class, 'update'])->name('user.update_account');
    Route::get('/user-by-token', [UserController::class, 'getUserByToken']);

});

//Property Endpoints
Route::group(['prefix'=>'properties', 'middleware' => ['auth:api', 'api', 'cors', 'is_sms_verified']], function () {
    Route::get('/show', [PropertyController::class, 'display_property'])->name('property.displayProperty.api');
    Route::get('/delete', [PropertyController::class, 'delete_property'])->name('property.deleteProperty.api');
    Route::post('/save', [PropertyController::class, 'saveFavorite'])->name('property.saveProperty.api');
    Route::post('/enable', [PropertyController::class, 'enableProperty'])->name('property.enableProperty.api');
    Route::post('/disable', [PropertyController::class, 'disableProperty'])->name('property.disableProperty.api');
    Route::put('/{property}/change-status', [PropertyController::class, 'changeStatus']);
    Route::get('/my-properties', [PropertyController::class, 'myProperties']);
    Route::get('/my-favorites', [PropertyController::class, 'myFavorites']);

});

Route::group(['middleware' => ['auth:api', 'api', 'cors', 'is_sms_verified']], function () {
    Route::get('/regions/get-all', [RegionController::class, 'getAll'])->name('regions.getAll.api');
});

Route::group(['middleware' => ['auth:api', 'api', 'cors', 'is_sms_verified']], function () {
    Route::post('/properties/near-by-places', [PropertyController::class, 'nearbyPlaces']);
    Route::apiResource('/properties', PropertyController::class);
    Route::apiResource('/amenities', AmenityController::class);
    Route::apiResource('/tags', TagController::class);
    Route::apiResource('/agriculturals', AgriculturalController::class);
    Route::apiResource('/residentials', ResidentialController::class);
    Route::apiResource('/commercials', CommercialController::class);
    Route::apiResource('/regions', RegionController::class);

});

Route::group(['middleware' => ['auth:api', 'api', 'cors', 'is_sms_verified']], function () {
    Route::apiResource('/agencies', AgencyController::class);
});

