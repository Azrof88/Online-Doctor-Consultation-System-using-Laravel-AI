<?php
// app/Http/Controllers/Doctor/ZoomMeetingController.php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\ZoomMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ZoomMeetingController extends Controller
{
    public function index()
    {
        $doctorId = Auth::user()->doctor->id;

        $meetings = ZoomMeeting::with(['appointment.patient.user'])
            ->whereHas('appointment', fn($q) => $q->where('doctor_id', $doctorId))
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('doctor.zoom_meetings.index', compact('meetings'));
    }

    public function show(ZoomMeeting $zoomMeeting)
    {
        abort_unless(
          $zoomMeeting->appointment->doctor_id === Auth::user()->doctor->id,
          403
        );

        $zoomMeeting->load('appointment.patient.user');

        return view('doctor.zoom_meetings.show', compact('zoomMeeting'));
    }

    public function edit(ZoomMeeting $zoomMeeting)
    {
        abort_unless(
          $zoomMeeting->appointment->doctor_id === Auth::user()->doctor->id,
          403
        );

        return view('doctor.zoom_meetings.edit', compact('zoomMeeting'));
    }

    public function update(Request $req, ZoomMeeting $zoomMeeting)
    {
        abort_unless(
          $zoomMeeting->appointment->doctor_id === Auth::user()->doctor->id,
          403
        );

        $data = $req->validate([
            'start_url' => 'required|url',
            'join_url'  => 'required|url',
        ]);

        $zoomMeeting->update($data);

        return redirect()
               ->route('doctor.zoom-meetings.show', $zoomMeeting)
               ->with('status','Zoom meeting updated.');
    }
}
