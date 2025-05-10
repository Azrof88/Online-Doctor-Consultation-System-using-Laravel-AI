<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Show the logged-in patient’s profile form.
     */
    public function show()
    {
        // Auth::user() is the base User model; cascade into the Patient record
        $user    = Auth::user();
        $patient = $user->patient; // assumes User->patient() relationship

        return view('patient.profile', compact('user','patient'));
    }

    /**
     * Handle form submission to update profile.
     */
    public function update(Request $req)
    {
        $data = $req->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.Auth::id(),
            'mobile'   => 'required|string|max:50',
            'age'      => 'required|integer|min:0',
            'gender'   => 'required|in:male,female,other',
            'contact_number' => 'required|string|max:50',
            'password' => 'nullable|confirmed|min:6',
        ]);

        // Update base user
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

        // Update patient details
        $patient = $user->patient;
        $patient->fill([
            'age'            => $data['age'],
            'gender'         => $data['gender'],
            'contact_number' => $data['contact_number'],
        ]);
        $patient->save();

        return back()->with('status','Profile updated.');
    }
}
