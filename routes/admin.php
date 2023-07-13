<?php
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\LoginController;
use \App\Http\Controllers\Admin\UserController;
use \App\Http\Controllers\Admin\HomeController;

Route::get('admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login'])->name('admin.post_login');

Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/User', [UserController::class, 'index'])->name('admin.user.list');
    Route::get('/User/switch-block', [UserController::class, 'switchBlock'])->name('admin.user.switch_block');

});
