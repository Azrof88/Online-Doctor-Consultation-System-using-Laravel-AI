<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
{
    $user   = Auth::user();
    $doctor = $user->doctor;

    $appointments = $doctor->appointments()
        ->with(['patient.user','zoomMeeting'])
        ->whereIn('status',['pending','confirmed'])
        ->orderByDesc('scheduled_datetime')
        ->get();

    // make sure you pass $appointments here!
    return view('dashboards.doctor', [
        'user'         => $user,
        'doctor'       => $doctor,
        'appointments' => $appointments,
    ]);
}

}
