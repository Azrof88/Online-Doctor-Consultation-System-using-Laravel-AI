<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
Route::controller(AuthController::class)->group(function () {
    // Registration
    Route::get('register', 'showRegister')->   name('register');
    Route::post('register', 'register')->      name('register.submit');

    // Login / Logout
    Route::get('login',    'showLogin')->      name('login');
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



