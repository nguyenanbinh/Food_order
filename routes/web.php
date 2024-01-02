<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

/** Admin Auth Routes */
Route::group(['middleware' => 'guest'], function () {
    Route::get('admin/login', [AuthController::class, 'index'])->name('admin.login');
    Route::get('admin/forget-password', [AuthController::class, 'forgetPassword'])->name('admin.forget-password');
});
// Dashboard
Route::group(['middleware' => 'auth'], function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::put('profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::put('profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');

});



require __DIR__.'/auth.php';

;
