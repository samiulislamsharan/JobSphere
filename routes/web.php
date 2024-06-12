<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
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

Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
    // guest routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AccountController::class, 'login'])->name('login.index');
        Route::post('/auth', [AccountController::class, 'authenticate'])->name('auth');
        Route::get('/register', [AccountController::class, 'registration'])->name('registration.index');
        Route::post('/registerUser', [AccountController::class, 'registerUser'])->name('registerUser');
    });

    // authenticated routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile.show');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    });
});
