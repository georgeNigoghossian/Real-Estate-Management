<?php

use App\Http\Controllers\App\Agency\AgencyController;
use App\Http\Controllers\App\Location\RegionController;
use App\Http\Controllers\App\NotificationController;
use App\Http\Controllers\App\Notifications\FireBaseNotificationController;
use App\Http\Controllers\App\Property\AgriculturalController;
use App\Http\Controllers\App\Property\AmenityController;
use App\Http\Controllers\App\Property\CommercialController;
use App\Http\Controllers\App\Property\PropertyController;
use App\Http\Controllers\App\Property\ResidentialController;
use App\Http\Controllers\App\Property\TagController;
use App\Http\Controllers\App\ReportCategoryController;
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
Route::group(['prefix' => 'properties', 'middleware' => ['auth:api', 'api', 'cors', 'is_sms_verified']], function () {
    Route::post('/enable', [PropertyController::class, 'enableProperty'])->name('property.enableProperty.api');
    Route::post('/disable', [PropertyController::class, 'disableProperty'])->name('property.disableProperty.api');
    Route::put('/{property}/change-status', [PropertyController::class, 'changeStatus']);
    Route::get('/my-properties', [PropertyController::class, 'myProperties']);

    //Favorites
    Route::get('/my-favorites', [PropertyController::class, 'myFavorites']);
    Route::get('/{property}/is-favorite', [PropertyController::class, 'isFavorite']);
    Route::post('/save', [PropertyController::class, 'saveFavorite'])->name('property.saveProperty.api');

    //Ratings
    Route::post('{property}/rate', [PropertyController::class, 'rateProperty']);
    Route::get('/my-ratings', [PropertyController::class, 'myRatings']);
    Route::get('{property}/my-rating', [PropertyController::class, 'myPropertyRating']);
});

// public routes
Route::post('/properties/near-by-places', [PropertyController::class, 'nearbyPlaces']);
Route::get('/regions/get-all', [RegionController::class, 'getAll'])->name('regions.getAll.api');
Route::get('/properties', [PropertyController::class, 'index']);
Route::get('/amenities', [AmenityController::class, 'index']);
Route::get('/tags', [TagController::class, 'index']);
Route::get('/agriculturals', [AgriculturalController::class, 'index']);
Route::get('/residentials', [ResidentialController::class, 'index']);
Route::get('/commercials', [CommercialController::class, 'index']);
Route::get('{property}/ratings', [PropertyController::class, 'propertyRatings']);


Route::group(['middleware' => ['auth:api', 'api', 'cors', 'is_sms_verified']], function () {
    Route::apiResource('/properties', PropertyController::class)->except(['index']);
    Route::apiResource('/amenities', AmenityController::class)->except(['index']);
    Route::apiResource('/tags', TagController::class)->except(['index']);
    Route::apiResource('/agriculturals', AgriculturalController::class)->except(['index']);
    Route::apiResource('/residentials', ResidentialController::class)->except(['index']);
    Route::apiResource('/commercials', CommercialController::class)->except(['index']);
    Route::apiResource('/regions', RegionController::class);
    Route::get('/agencies/request-status', [AgencyController::class, 'promoteRequestStatus'])->name('agencies.request-status.api');
    Route::apiResource('/agencies', AgencyController::class);

    //Notifications
    Route::post('/send-notification', [FireBaseNotificationController::class, 'send']);
    Route::get('users/{user}/notifications', [NotificationController::class, 'myNotifications']);

    //report categories
    Route::get('/report-categories', [ReportCategoryController::class, 'index']);

});


