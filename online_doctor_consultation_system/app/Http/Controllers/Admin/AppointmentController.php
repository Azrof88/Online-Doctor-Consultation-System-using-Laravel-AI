<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    // GET /admin/appointments
    public function index()
    {
        $appointments = Appointment::with('doctor.user','patient.user')
            ->orderBy('scheduled_datetime','desc')
            ->paginate(10);

        return view('admin.appointments.index', compact('appointments'));
    }

    // GET /admin/appointments/{appointment}
    public function show(Appointment $appointment)
    {
        $appointment->load('doctor.user','patient.user');
        return view('admin.appointments.show', compact('appointment'));
    }

    // DELETE /admin/appointments/{appointment}
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return back()->with('success','Appointment deleted.');
    }
}
