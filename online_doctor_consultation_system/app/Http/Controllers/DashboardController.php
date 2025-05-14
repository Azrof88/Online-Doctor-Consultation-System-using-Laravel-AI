<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\SymptomCheck;

class DashboardController extends Controller
{
    public function index()
    {
        // 1) Grab the currently authenticated user (or redirect to login)
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        // 2) Branch by role
        switch ($user->role) {
            case 1: // Admin
                $doctors  = Doctor::with('user')->get();
                $patients = Patient::with('user')->get();

                return view('dashboards.admin', compact('user','doctors','patients'));

            case 2: // Doctor
        // 1) Grab the doctor profile
        $doctor = $user->doctor;

        // 2) Load all this doctor’s upcoming appts (eager‐load patient name + Zoom)
        $appointments = $doctor->appointments()
            ->with(['patient.user','zoomMeeting'])
            ->whereIn('status', ['pending','confirmed'])
            ->orderByDesc('scheduled_datetime')
            ->get();

        // 3) Pass them all into the view
        return view('dashboards.doctor', compact('user','doctor','appointments'));

            case 3: // Patient
                // load this user’s Patient record
                $patient = $user->patient;

                // fetch appointments with each doctor’s user
                $appointments = Appointment::with('doctor.user')
                    ->where('patient_id', $patient->id)
                    ->orderBy('scheduled_datetime','desc')
                    ->get();

                // fetch symptom checks
                $symptomChecks = SymptomCheck::where('patient_id', $patient->id)
                    ->orderBy('created_at','desc')
                    ->get();

                return view('dashboards.patient',
                            compact('user','appointments','symptomChecks'));

            default:
                abort(403);
        }
    }
}
