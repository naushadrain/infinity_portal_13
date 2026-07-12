<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Forms\IncidentReportFormController;
use App\Http\Controllers\Forms\MedicationIncidentController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\Survey\CustomerSurveyController;
use App\Http\Controllers\Survey\StaffSurveyController;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\User\UsersProfileController;
use App\Http\Controllers\Forms\ABCMonitoringChart;
use App\Http\Controllers\Public\CreateIncidentController;
use App\Http\Controllers\Public\CreatePublicComplaintController;
use App\Http\Controllers\Forms\PublicComplaintController;
use App\Http\Controllers\Public\CustomerSatisfyController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SignatureBannerController;

/*
|--------------------------------------------------------------------------
| Public routes
|--------------------------------------------------------------------------
| Only guests can access login / forgot password / reset password.
| If already logged in, redirect to dashboard.
*/
// public route
Route::get('/customersatisfy/Perth', [CustomerSatisfyController::class, 'index']);
Route::post('/customersatisfy/Perth', [CustomerSatisfyController::class, 'store'])->name('customer-satisfy-perth.store');
Route::get('/customersatisfy/Victoria', [CustomerSatisfyController::class, 'getVictoria']);
Route::post('/customersatisfy/Victoria', [CustomerSatisfyController::class, 'storeVictoria'])->name('customer-satisfy-victoria.store');

Route::get('/incident/create-incident', [CreateIncidentController::class,'index'])->name('incident.public.create');
Route::post('/incident/create-incident', [CreateIncidentController::class,'store'])->name('incident.public.store');

Route::get('/complaint/create-complaint', [CreatePublicComplaintController::class,'index'])->name('complaint.public.create');
Route::post('/complaint/create-complaint', [CreatePublicComplaintController::class,'store'])->name('complaint.public.store');


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

    Route::get('/profile',                   [UsersProfileController::class, 'show'])->name('profile');
    Route::put('/profile',                   [UsersProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password',   [UsersProfileController::class, 'showChangePassword'])->name('password.change');
    Route::put('/profile/password',          [UsersProfileController::class, 'updatePassword'])->name('profile.password');

    Route::middleware('restrict.managers')
        ->group(function () {
            Route::resource('users', UsersController::class)->except(['show']);
        });

    Route::prefix('forms')->name('forms.')->group(function () {
        Route::get('incident/export', [IncidentReportFormController::class, 'export'])->name('incident.export');
        Route::resource('incident', IncidentReportFormController::class);
        Route::get('/reportpdf/{r_id}', [IncidentReportFormController::class, 'showPdf'])->name('reportpdf');
        Route::get('medication/export', [MedicationIncidentController::class, 'export'])->name('medication.export');
        Route::resource('medication', MedicationIncidentController::class);
        Route::get('abc-monitoring-chart/export', [ABCMonitoringChart::class, 'export'])->name('abc-monitoring-chart.export');
        Route::resource('abc-monitoring-chart', ABCMonitoringChart::class);
        Route::get('complaint/export', [PublicComplaintController::class, 'export'])->name('complaint.export');
        Route::resource('complaint', PublicComplaintController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
        // Route::view('/',           'pages.forms')->name('index');
        //Route::view('/abc',        'pages.form-abc')->name('abc');
        // Route::view('/incident',   'pages.form-incident')->name('incident');
        // Route::view('/medication', 'pages.form-medication')->name('medication');
        Route::view('/{form}',     'pages.form-view')->name('show')->whereAlphaNumeric('form');
    });

    // Route::prefix('service-providers')->name('providers.')->group(function () {
    //     Route::view('/',       'pages.service-providers')->name('index');
    //     Route::view('/create', 'pages.service-provider-create')->name('create');
    // });
    Route::resource('service-providers', ServiceProviderController::class);

    Route::prefix('surveys')->name('surveys.')->group(function () {
        Route::get('/customer', [CustomerSurveyController::class, 'index'])->name('customer');
        Route::get('/staff',    [StaffSurveyController::class, 'index'])->name('staff');
        // Route::view('/create',        'pages.survey-create')->name('create');
        // Route::view('/{survey}/fill', 'pages.survey-fill')->name('fill')->whereNumber('survey');
    });

    Route::get('/reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity.index');
    Route::delete('/activity-logs/{log}', [ActivityLogController::class, 'destroy'])->name('activity.destroy');
    Route::resource('/signature-banner', SignatureBannerController::class)
        ->except(['create', 'edit', 'show'])
        ->names('banner');
});
