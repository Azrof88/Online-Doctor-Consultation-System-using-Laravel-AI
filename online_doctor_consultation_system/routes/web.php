<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::get('/',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login'])->  name('login.submit');

Route::post('/logout',  [AuthController::class, 'logout'])->      name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
     ->name('dashboard');

   //  Route::get('email/verify/{id}', [AuthController::class,'verifyEmail'])
     //->name('verification.verify')
     //->middleware('signed');


// Show “enter your email” form
Route::get('password/forgot', [AuthController::class, 'showForgotForm'])
     ->name('password.request');

// Handle the email submission
Route::post('password/forgot', [AuthController::class, 'sendResetLink'])
     ->name('password.email');

// Show “reset your password” form (signed URL)
Route::get('password/reset/{id}', [AuthController::class, 'showResetForm'])
     ->name('password.reset')
     ->middleware('signed');

// Handle the actual password update
Route::post('password/reset', [AuthController::class, 'resetPassword'])
     ->name('password.update');



