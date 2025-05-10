<?php
namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Doctor;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    // Show “book appointment” form
    public function create()
    {
        // pull in all doctors for the <select>
        $doctors = Doctor::with('user')->get();
        return view('patient.appointments.create', compact('doctors'));
    }

    // Handle the form POST
    public function store(Request $request)
{
    $data = $request->validate([
        'doctor_id'          => 'required|exists:doctors,id',
        'scheduled_datetime' => 'required|date|after:now',
        'mode'               => 'required|in:online,offline',
    ]);

    // grab the Patient model tied to the current User
    $patient = $request->user()->patient;

    Appointment::create([
        'patient_id'         => $patient->id,
        'doctor_id'          => $data['doctor_id'],
        'scheduled_datetime' => $data['scheduled_datetime'],
        'mode'               => $data['mode'],
        'status'             => 'pending',

    ]);

    return redirect()
        ->route('patient.appointments.index')
        ->with('status','Appointment requested!');
}

    // (You’ll also want index() and show(), but we’ll do those next.)
    /**
     * GET /patient/appointments
     * Show the logged-in patient’s appointments.
     */
    public function index()
{
    $patientId = Auth::user()->patient->id;

    $appointments = Appointment::with('doctor.user','zoomMeeting')
        ->where('patient_id', $patientId)
        ->orderBy('scheduled_datetime','desc')
        ->get();

    return view('patient.appointments.index', compact('appointments'));
}


    /**
     * GET /patient/appointments/{appointment}
     * Show details if you need a dedicated page.
     */
    public function show(Appointment $appointment)
    {
        abort_unless($appointment->patient_id === Auth::user()->patient->id, 403);

    return view('patient.appointments.show', compact('appointment'));
    }
}
