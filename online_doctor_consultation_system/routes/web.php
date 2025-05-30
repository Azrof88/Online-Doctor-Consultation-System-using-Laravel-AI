<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\PaymentController;


use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;


use App\Http\Controllers\Admin\AdminProfileController;

use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Patient\AppointmentController as PatientAppointmentController;

use App\Http\Controllers\Patient\SymptomCheckController as PatientSymptomCheckController;
use App\Http\Controllers\Patient\ProfileController    as PatientProfileController;

Use App\Http\Controllers\Patient\PatientPaymentController;


use App\Http\Controllers\Doctor\DashboardController as DoctorDashboardController;
use App\Http\Controllers\Doctor\AppointmentController as DoctorAppointmentController;
use App\Http\Controllers\Doctor\ProfileController as DoctorProfileController;
use App\Http\Controllers\Doctor\AvailabilityController as DoctorAvailabilityController;
use App\Http\Controllers\Doctor\ZoomMeetingController as DoctorZoomMeetingController;
use App\Http\Controllers\Doctor\PaymentController as DoctorPaymentController;
use App\Http\Controllers\SslcommerzPaymentController;

Route::post('/pay-via-ajax/{appointment}', [SslCommerzPaymentController::class, 'payViaAjax'])
    ->middleware(['auth']);

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

    Route::middleware(['auth', 'can:patient'])
    ->prefix('patient')
    ->name('patient.')
    ->group(function () {
        // Show payment confirmation page or form (GET)
        Route::get('appointments/{appointment}/pay', [SslcommerzPaymentController::class, 'showPayForm'])
            ->name('appointments.pay');

        // Handle payment POST (form submission)
        Route::post('appointments/{appointment}/pay', [SslcommerzPaymentController::class, 'payViaAjax'])
            ->name('appointments.pay.submit');

        // Payments resource routes
        Route::resource('payments', SslcommerzPaymentController::class)
            ->only(['index', 'show']);
    });
// Doctor‐only routes
Route::middleware(['auth', 'can:doctor'])
     ->prefix('doctor')
     ->name('doctor.')
     ->group(function(){

    // 1) Dashboard (GET /doctor)
    Route::get('/', [DoctorDashboardController::class, 'index'])
         ->name('home');

    // 2) Appointments: list & details
    Route::resource('appointments', DoctorAppointmentController::class)
         ->only(['index','show','destroy','update']);

    // Show the edit form (no {id} parameter)
Route::get('availability/edit', [DoctorAvailabilityController::class, 'edit'])
     ->name('availability.edit');

// Handle the update (PATCH)
Route::patch('availability', [DoctorAvailabilityController::class, 'update'])
     ->name('availability.update');


    // 4) Zoom Meetings management
    Route::resource('zoom-meetings', DoctorZoomMeetingController::class)
         ->only(['index','show','edit','update']);

    Route::resource('payments', DoctorPaymentController::class)
              ->only(['index','show','update']);
              // maybe update() to mark paid/confirmed

    // 5) Profile view & update
    Route::get('profile', [DoctorProfileController::class, 'show'])
         ->name('profile');
    Route::post('profile', [DoctorProfileController::class, 'update'])
         ->name('profile.update');

    // 6) (Optional) Logout can remain the same
});





Route::middleware(['auth','can:patient'])
     ->prefix('patient')
     ->name('patient.')
     ->group(function(){
         // Patient Dashboard (GET /patient)
         Route::get('/', [PatientDashboardController::class, 'index'])
              ->name('home');

         // Book an appointment form & store (GET /patient/appointments/create, POST /patient/appointments)
         Route::resource('appointments', PatientAppointmentController::class)
              ->only(['index','create','store','show']);


         // Symptom Checks: list, create, store, show
         Route::resource('symptom-checks', PatientSymptomCheckController::class)
              ->parameters(['symptom-checks' => 'symptomCheck'])
              ->only(['index','create','store','show']);

         // Profile view & update
         Route::get('profile', [PatientProfileController::class, 'show'])
              ->name('profile');
         Route::post('profile', [PatientProfileController::class, 'update'])
              ->name('profile.update');
});



Route::middleware(['auth','can:admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function(){
        //  // Dashboard
         Route::get('/', [AdminDashboardController::class, 'index'])
              ->name('home');

         // Doctors CRUD
         Route::resource('doctors', DoctorController::class);

         // Patients CRUD
         Route::resource('patients', PatientController::class);

         // Appointments (index, show, destroy)
         Route::resource('appointments', AppointmentController::class)
              ->only(['index','show','destroy']);

         // Payments (index, show, destroy)
         Route::resource('payments', PaymentController::class)
              ->only(['index','show','destroy']);

         // Profile view & update
         Route::get('profile', [AdminProfileController::class, 'show'])
              ->name('profile');
         Route::post('profile', [AdminProfileController::class, 'update'])
              ->name('profile.update');
});

Route::controller(AuthController::class)->group(function () {
    // Registration
    Route::get('register', 'showRegister')->   name('register');
    Route::post('register', 'register')->      name('register.submit');

    // Login / Logout
    Route::get('/',    'showLogin')->      name('login');
    Route::post('login',   'login')->          name('login.submit');
    Route::post('logout',  'logout')->         name('logout');
    // Forgot-to-Reset (reuse register form)
    Route::get('password/forgot',   'showForgotForm')->             name('password.request');
    Route::post('password/forgot',  'redirectToPrefillRegister')->  name('password.prefill');
    Route::get('register/reset/{id}','showPrefillRegister')->       name('register.prefill');

});



Route::get('/dashboard', [DashboardController::class, 'index'])
     ->name('dashboard');
    //  Route::get('/admin', [DashboardController::class,'index'])
    //  ->name('admin.home');

   //  Route::get('email/verify/{id}', [AuthController::class,'verifyEmail'])
     //->name('verification.verify')
     //->middleware('signed');

// in web.php, before any middleware
Route::get('/whoami', function(){
    if(! auth()->check()) {
        return 'Not logged in';
    }
    return 'ID=' . auth()->id() . '  role=' . auth()->user()->role;
});


