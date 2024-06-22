<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobsController;
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

Route::group(['prefix' => 'jobs'], function () {
    Route::get('/', [JobsController::class, 'index'])->name('jobs');
    Route::get('/detail/{id}', [JobsController::class, 'detail'])->name('job.detail');
    Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('job.apply')->middleware('auth');
});

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
        Route::post('/update-profile-picture', [AccountController::class, 'updateProfilePicture'])->name('profilePicture.update');

        Route::group(['as' => 'job.'], function () {
            Route::get('/create-job', [AccountController::class, 'createJob'])->name('create');
            Route::post('/save-job', [AccountController::class, 'saveJob'])->name('store');
            Route::get('/my-jobs/edit/{id}', [AccountController::class, 'editJob'])->name('edit');
            Route::post('/update-job/{id}', [AccountController::class, 'updateJob'])->name('update');
            Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('delete');
            Route::post('/remove-job-application', [AccountController::class, 'removeJob'])->name('application.remove');
            Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('my');
            Route::get('/applied-jobs', [AccountController::class, 'myJobApplications'])->name('applied');
        });

        Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    });
});