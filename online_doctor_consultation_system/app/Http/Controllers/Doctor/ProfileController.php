<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;





use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the logged-in doctor’s profile form.
     */
    public function show()
    {
        $user   = Auth::user();
        $doctor = $user->doctor;   // assumes User->doctor() relation

        return view('doctor.profile', compact('user','doctor'));
    }

    /**
     * Handle form submission to update the profile.
     */
    public function update(Request $req)
    {
        $userId = Auth::id();

        // 1) Validate
        $data = $req->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email,'.$userId,
            'mobile'                => 'required|string|max:50',
            'specialization'        => 'nullable|string|max:255',
            'fee'                   => 'nullable|numeric|min:0',
            'zoom_link'             => 'nullable|url',
            'bio'                   => 'nullable|string',
            'availability_schedule' => 'nullable|string',
            'password'              => 'nullable|confirmed|min:6',
        ]);

        // 2) Update the base User
        $user = Auth::user();
        $user->fill([
            'name'   => $data['name'],
            'email'  => $data['email'],
            'mobile' => $data['mobile'],
        ]);
        if (! empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        // 3) Update doctor details
        $doctor = $user->doctor;
        $doctor->fill([
            'name'                  => $data['name'],           // duplicate or omit if you prefer
            'specialization'        => $data['specialization'],
            'fee'                   => $data['fee'] ?? 0,
            'zoom_link'             => $data['zoom_link'],
            'bio'                   => $data['bio'],
            'availability_schedule' => $data['availability_schedule'],
        ]);
        $doctor->save();

        return redirect()
               ->route('doctor.home')
               ->with('status','Availability updated.');
    }
}

