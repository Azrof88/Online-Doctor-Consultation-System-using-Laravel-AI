<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //index
    public function index()
    {
        // eager‐load the User so you can do $doc->user->name, etc.

//now have to load the user
        $user = auth()->user();

        // load this user’s Patient record
        $patient = $user->patient;

        // fetch appointments with each doctor’s user
        $appointments = $patient->appointments()
            ->with('doctor.user')
            ->orderBy('scheduled_datetime','desc')
            ->get();

        // fetch symptom checks
        $symptomChecks = $patient->symptomChecks()
            ->orderBy('created_at','desc')
            ->get();

       return view('dashboards.patient', compact('user','appointments','symptomChecks'));
    }
}
