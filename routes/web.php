<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Survey\CustomerSurveyController;
use App\Http\Controllers\Survey\StaffSurveyController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\User\UsersProfileController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
| Only guests can access login / forgot password / reset password.
| If already logged in, redirect to dashboard.
*/

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });

    Route::get('/login',  [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');

    // Forgot password OTP flow
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPassword'])
        ->name('password.request');

    Route::post('/forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp'])
        ->name('password.sendOtp')
        ->middleware('throttle:5,1');

    Route::get('/verify-otp',  [ForgotPasswordController::class, 'showVerifyOtp'])->name('password.verifyOtp');
    Route::post('/verify-otp', [ForgotPasswordController::class, 'verifyOtp'])
        ->name('password.checkOtp')
        ->middleware('throttle:10,1');

    Route::post('/verify-otp/resend', [ForgotPasswordController::class, 'resendOtp'])
        ->name('password.resendOtp')
        ->middleware('throttle:5,1');

    Route::get('/reset-password',  [ForgotPasswordController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Logout route
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated routes
|--------------------------------------------------------------------------
| All other routes require login.
*/

Route::middleware('auth')->group(function () {

    Route::redirect('/', '/dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',          [UsersProfileController::class, 'show'])->name('profile');
    Route::put('/profile',          [UsersProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [UsersProfileController::class, 'updatePassword'])->name('profile.password');

    Route::resource('users', UsersController::class)->except(['show']);

    Route::prefix('forms')->name('forms.')->group(function () {
        Route::view('/',           'pages.forms')->name('index');
        Route::view('/abc',        'pages.form-abc')->name('abc');
        Route::view('/incident',   'pages.form-incident')->name('incident');
        Route::view('/medication', 'pages.form-medication')->name('medication');
        Route::view('/{form}',     'pages.form-view')->name('show')->whereAlphaNumeric('form');
    });

    Route::prefix('service-providers')->name('providers.')->group(function () {
        Route::view('/',       'pages.service-providers')->name('index');
        Route::view('/create', 'pages.service-provider-create')->name('create');
    });

    Route::prefix('surveys')->name('surveys.')->group(function () {
        Route::get('/customer', [CustomerSurveyController::class, 'index'])->name('customer');
        Route::get('/staff',    [StaffSurveyController::class, 'index'])->name('staff');
        // Route::view('/create',        'pages.survey-create')->name('create');
        // Route::view('/{survey}/fill', 'pages.survey-fill')->name('fill')->whereNumber('survey');
    });

    Route::view('/reports',          'pages.reports')->name('reports.index');
    Route::view('/activity-logs',    'pages.activity-logs')->name('activity.index');
    Route::view('/signature-banner', 'pages.signature-banner')->name('banner.index');
});
