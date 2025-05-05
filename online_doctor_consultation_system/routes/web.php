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


Route::middleware(['auth','can:admin'])
     ->prefix('admin')
     ->name('admin.')
     ->group(function(){
         // Dashboard
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

   //  Route::get('email/verify/{id}', [AuthController::class,'verifyEmail'])
     //->name('verification.verify')
     //->middleware('signed');



