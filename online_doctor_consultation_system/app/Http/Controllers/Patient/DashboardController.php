<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $user        = auth()->user();
    $patient     = $user->patient;
    $appointments = $patient->appointments()
        ->with([
            'doctor.user',    // already there
            'zoomMeeting',    // ← add this
        ])
        ->orderByDesc('scheduled_datetime')
        ->get();

    $symptomChecks = $patient->symptomChecks()
        ->orderByDesc('created_at')
        ->get();

    return view('dashboards.patient', compact('user','appointments','symptomChecks'));
}
}
