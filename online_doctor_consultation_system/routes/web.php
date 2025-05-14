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
use Karim007\SslcommerzLaravel\SslCommerzController;
Use App\Http\Controllers\Patient\PatientPaymentController;
use App\Http\Middleware\VerifyCsrfToken;

// Accept GET (user cancel) or POST (gateway callback)
Route::match(['get','post'], 'sslcommerz/success',  [PatientPaymentController::class,'success'])
    ->name('sslcommerz.success')
    ->withoutMiddleware(VerifyCsrfToken::class);

Route::match(['get','post'], 'sslcommerz/fail',     [PatientPaymentController::class,'fail'])
    ->name('sslcommerz.fail')
    ->withoutMiddleware(VerifyCsrfToken::class);

Route::match(['get','post'], 'sslcommerz/cancel',   [PatientPaymentController::class,'fail'])
    ->name('sslcommerz.cancel')
    ->withoutMiddleware(VerifyCsrfToken::class);

// IPN is always POST
Route::post('sslcommerz/ipn', [PatientPaymentController::class,'ipn'])
    ->name('sslcommerz.ipn')
    ->withoutMiddleware(VerifyCsrfToken::class);


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
        // just so GET /patient/appointments/{appointment}/pay shows something
Route::get('appointments/{appointment}/pay',
    [PatientPaymentController::class, 'pay'])
    ->name('appointments.pay');

         // Payments: list & show (GET /patient/payments, GET /patient/payments/{id})
         Route::resource('payments', PatientPaymentController::class)
              ->only(['index','show']);
              // Payments index & show:
         Route::resource('payments', PatientPaymentController::class)
         ->only(['index','show']);

    // “Pay/Confirm” button POST:
    Route::post('appointments/{appointment}/pay',[PatientPaymentController::class, 'pay'])
    ->name('appointments.pay');

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


