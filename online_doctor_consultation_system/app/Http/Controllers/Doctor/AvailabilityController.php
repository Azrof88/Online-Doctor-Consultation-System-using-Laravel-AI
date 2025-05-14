<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AvailabilityController extends Controller
{
    public function edit()
    {
        $doctor = Auth::user()->doctor;
        return view('doctor.availability.edit', compact('doctor'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'availability_schedule' => 'nullable|string',
        ]);

        $doctor = Auth::user()->doctor;
        $doctor->availability_schedule = $data['availability_schedule'];
        $doctor->save();

        return redirect()
               ->route('doctor.home')
               ->with('status','Availability updated.');
    }
}
