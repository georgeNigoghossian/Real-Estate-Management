<?php
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\LoginController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\HomeController;
use \App\Http\Controllers\Admin\ReportedClientController;
use \App\Http\Controllers\Admin\TagController;
use \App\Http\Controllers\Admin\AmenityController;

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.post_login');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/User', [UserController::class, 'index'])->name('admin.user.list');
    Route::get('/User/{id}/details', [UserController::class, 'details'])->name('admin.user.details');
    Route::get('/BlockedUser', [UserController::class, 'blocked_users'])->name('admin.user.blocked_list');
    Route::post('/User/switch-block', [UserController::class, 'switchBlock'])->name('admin.user.switch_block');
    Route::get('/ReportedUser', [ReportedClientController::class, 'index'])->name('admin.reported_users');
    Route::get('/Tag', [TagController::class, 'index'])->name('admin.tags');
    Route::get('/Tag/create', [TagController::class, 'create'])->name('admin.tags.create');
    Route::get('/Tag/edit', [TagController::class, 'edit'])->name('admin.tags.edit');
    Route::get('/Tag/delete/{id}', [TagController::class, 'delete'])->name('admin.tags.delete');
    Route::post('/Tag', [TagController::class, 'store'])->name('admin.tags.store');
    Route::post('/Tag/update/{id}', [TagController::class, 'update'])->name('admin.tags.update');
    Route::post('/Tag/storePhoto', [TagController::class, 'storePhoto'])->name('admin.tags.storePhoto');
    Route::get('/Amenties', [AmenityController::class, 'index'])->name('admin.amenities');
    Route::post('/update-priority',[UserController::class, 'updatePriority'])->name('admin.user.update_priority');

});
