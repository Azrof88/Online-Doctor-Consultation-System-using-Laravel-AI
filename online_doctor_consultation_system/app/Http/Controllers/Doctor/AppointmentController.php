<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // 1) List all appointments for this doctor
    public function index()
    {
        $doctor = Auth::user()->doctor;

        $appointments = Appointment::with(['patient.user','zoomMeeting'])
            ->where('doctor_id', $doctor->id)
            ->orderByDesc('scheduled_datetime')
            ->paginate(10);

        return view('doctor.appointments.index', compact('appointments'));
    }

    // 2) Show one appointment
    public function show(Appointment $appointment)
    {
        // ensure they own it
        abort_unless(
            $appointment->doctor_id === Auth::user()->doctor->id,
            403
        );

        $appointment->load(['patient.user','zoomMeeting']);

        return view('doctor.appointments.show', compact('appointment'));
    }

    // 3) Confirm or cancel
    public function update(Request $request, Appointment $appointment)
    {
        abort_unless(
            $appointment->doctor_id === Auth::user()->doctor->id,
            403
        );

        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $appointment->update(['status' => $data['status']]);

        return back()->with('status',
            'Appointment '.ucfirst($data['status']).'.'
        );
    }
}
