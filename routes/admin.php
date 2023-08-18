<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\LoginController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\HomeController;
use \App\Http\Controllers\Admin\ReportedClientController;
use \App\Http\Controllers\Admin\TagController;
use \App\Http\Controllers\Admin\AmenityController;
use \App\Http\Controllers\Admin\AmenityTypeController;
use \App\Http\Controllers\Admin\AdminController;
use \App\Http\Controllers\Admin\PropertyController;
use \App\Http\Controllers\Admin\AgencyController;
use \App\Http\Controllers\Admin\NotificationController;

Route::get('/', function () {
    return redirect('admin/dashboard');
});


Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.post_login');
Route::get('/run', [AdminController::class, 'run'])->name('admin.admins.run');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/User', [UserController::class, 'index'])->name('admin.user.list');
    Route::get('/User/{id}/details', [UserController::class, 'details'])->name('admin.user.details');
    Route::get('/BlockedUser', [UserController::class, 'blocked_users'])->name('admin.user.blocked_list');
    Route::post('/User/switch-block', [UserController::class, 'switchBlock'])->name('admin.user.switch_block');
    Route::get('/ReportedUser', [ReportedClientController::class, 'index'])->name('admin.reported_users');
    Route::get('/ReportedUser/{id}/details', [ReportedClientController::class, 'details'])->name('admin.reported_users.details');
    Route::post('/update-priority',[UserController::class, 'updatePriority'])->name('admin.user.update_priority');
    Route::get('/User/verify-agency/{id}', [AgencyController::class, 'verifyAgency'])->name('admin.user.verifyAgency');
    Route::get('/User/reject-agency/{id}', [AgencyController::class, 'rejectAgency'])->name('admin.user.rejectAgency');

    //Tag
    Route::get('/Tag', [TagController::class, 'index'])->name('admin.tags');
    Route::get('/Tag/create', [TagController::class, 'create'])->name('admin.tags.create');
    Route::get('/Tag/edit', [TagController::class, 'edit'])->name('admin.tags.edit');
    Route::get('/Tag/delete/{id}', [TagController::class, 'delete'])->name('admin.tags.delete');
    Route::post('/Tag', [TagController::class, 'store'])->name('admin.tags.store');
    Route::post('/Tag/update/{id}', [TagController::class, 'update'])->name('admin.tags.update');
    Route::post('/Tag/storePhoto', [TagController::class, 'storePhoto'])->name('admin.tags.storePhoto');
    Route::post('/Tag/switch-active', [TagController::class, 'switchActive'])->name('admin.tag.switch_active');

    //Amenity
    Route::get('/Amenity', [AmenityController::class, 'index'])->name('admin.amenities');
    Route::get('/Amenity/create', [AmenityController::class, 'create'])->name('admin.amenities.create');
    Route::get('/Amenity/edit', [AmenityController::class, 'edit'])->name('admin.amenities.edit');
    Route::get('/Amenity/delete/{id}', [AmenityController::class, 'delete'])->name('admin.amenities.delete');
    Route::post('/Amenity', [AmenityController::class, 'store'])->name('admin.amenities.store');
    Route::post('/Amenity/update/{id}', [AmenityController::class, 'update'])->name('admin.amenities.update');
    Route::post('/Amenity/storePhoto', [AmenityController::class, 'storePhoto'])->name('admin.amenities.storePhoto');
    Route::post('/Amenity/switch-active', [AmenityController::class, 'switchActive'])->name('admin.amenities.switch_active');

    Route::get('/AmenityType', [AmenityTypeController::class, 'index'])->name('admin.amenity_types');
    Route::get('/AmenityType/create', [AmenityTypeController::class, 'create'])->name('admin.amenity_types.create');
    Route::get('/AmenityType/edit', [AmenityTypeController::class, 'edit'])->name('admin.amenity_types.edit');
    Route::get('/AmenityType/delete/{id}', [AmenityTypeController::class, 'delete'])->name('admin.amenity_types.delete');
    Route::post('/AmenityType', [AmenityTypeController::class, 'store'])->name('admin.amenity_types.store');
    Route::post('/AmenityType/update/{id}', [AmenityTypeController::class, 'update'])->name('admin.amenity_types.update');


    Route::get('/Admin', [AdminController::class, 'index'])->name('admin.admins.list');
    Route::get('/Admin/create', [AdminController::class, 'create'])->name('admin.admins.create');
    Route::get('/Admin/edit', [AdminController::class, 'edit'])->name('admin.admins.edit');
    Route::get('/Admin/delete/{id}', [AdminController::class, 'delete'])->name('admin.admins.delete');
    Route::post('/Admin', [AdminController::class, 'store'])->name('admin.admins.store');
    Route::post('/Admin/update/{id}', [AdminController::class, 'update'])->name('admin.admins.update');



    Route::get('/Agency', [AgencyController::class, 'index'])->name('admin.agency.index');
    Route::get('/Agency/details/{id}', [AgencyController::class, 'agency_details'])->name('admin.agency.details');
    Route::get('/Property', [PropertyController::class, 'index'])->name('admin.property.index');
    Route::get('/Property/{id}/details', [PropertyController::class, 'details'])->name('admin.property.details');


    Route::get('/AgencyRequests', [AgencyController::class, 'requests_index'])->name('admin.agency_requests.index');
    Route::get('/AgencyRequests/details/{id}', [AgencyController::class, 'agency_request_details'])->name('admin.agency_requests.details');

    Route::get('/Notifaction/create', [NotificationController::class, 'create'])->name('admin.notification.create');
    Route::post('/Notifaction/send', [NotificationController::class, 'send'])->name('admin.notification.send');

    Route::get('/edit_profile', [AdminController::class, 'edit_profile'])->name('admin.edit_profile');
    Route::post('/update_profile/{id}', [AdminController::class, 'update_profile'])->name('admin.update_profile');
});
