<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobApplicationController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\UserController;
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

/* TODO:
| convert the routes to resource routes
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['as' => 'users.'], function () {
        Route::get('/users', [UserController::class, 'index'])->name('index');
        Route::post('/users', [UserController::class, 'store'])->name('store');
        Route::get('/users/create', [UserController::class, 'create'])->name('create');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/user-delete', [UserController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::get('/', [JobController::class, 'index'])->name('index');
        Route::get('/{id}/edit', [JobController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JobController::class, 'update'])->name('update');
        Route::delete('/{id}', [JobController::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'job-applications', 'as' => 'job.applications.'], function () {
        Route::get('/', [JobApplicationController::class, 'index'])->name('index');
        Route::delete('/', [JobApplicationController::class, 'destroy'])->name('destroy');
    });
});

Route::group(['prefix' => 'jobs'], function () {
    Route::get('/', [JobsController::class, 'index'])->name('jobs');
    Route::get('/detail/{id}', [JobsController::class, 'detail'])->name('job.detail');

    Route::group(['middleware' => 'auth'], function () {
        Route::post('/apply-job', [JobsController::class, 'applyJob'])->name('job.apply');
        Route::post('/save-job', [JobsController::class, 'saveJob'])->name('job.save');
    });
});

Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
    // guest routes
    Route::group(['middleware' => 'guest'], function () {
        Route::get('/login', [AccountController::class, 'login'])->name('login.index');
        Route::post('/auth', [AccountController::class, 'authenticate'])->name('auth');
        Route::get('/register', [AccountController::class, 'registration'])->name('registration.index');
        Route::post('/register-user', [AccountController::class, 'registerUser'])->name('user.register');
        Route::get('/forgot-password', [AccountController::class, 'forgotPassword'])->name('forgot.password');
    });

    // authenticated routes
    Route::group(['middleware' => 'auth'], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('profile.show');
        Route::put('/update-profile', [AccountController::class, 'updateProfile'])->name('profile.update');
        Route::post('/update-profile-picture', [AccountController::class, 'updateProfilePicture'])->name('profilePicture.update');
        Route::post('/update-password', [AccountController::class, 'updatePassword'])->name('password.update');

        Route::group(['as' => 'job.'], function () {
            Route::get('/create-job', [AccountController::class, 'createJob'])->name('create');
            Route::post('/save-job', [AccountController::class, 'saveJob'])->name('store');
            Route::get('/my-jobs/edit/{id}', [AccountController::class, 'editJob'])->name('edit');
            Route::post('/update-job/{id}', [AccountController::class, 'updateJob'])->name('update');
            Route::post('/delete-job', [AccountController::class, 'deleteJob'])->name('destroy');
            Route::post('/remove-job-application', [AccountController::class, 'removeJob'])->name('application.remove');
            Route::get('/my-jobs', [AccountController::class, 'myJobs'])->name('my');
            Route::get('/applied-jobs', [AccountController::class, 'myJobApplications'])->name('applied');
            Route::get('/saved-jobs', [AccountController::class, 'savedJobs'])->name('saved');
            Route::post('/remove-saved-job', [AccountController::class, 'removeSavedJob'])->name('saved.remove');
        });

        Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    });
});