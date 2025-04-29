<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    return view('welcome');
});



//use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

//Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
//I want to return views only in /register
Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/login', function () {
    return view('auth.login');
});
//Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register')->middleware('guest');

// Later for form submit
// Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
// Route::post('/register', [RegisterController::class, 'register'])->middleware('guest');


