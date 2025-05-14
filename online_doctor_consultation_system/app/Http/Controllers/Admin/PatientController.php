<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
    public function index()
    {
        // eager-load user fields
        $patients = Patient::with('user')->orderBy('id','desc')->paginate(10);
        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|confirmed|min:8',
            'contact_number'  => 'required|string|max:20',
            'age'             => 'required|integer|min:0',
            'gender'          => 'required|in:male,female,other',
        ]);

        DB::transaction(function() use($data) {
            // 1) create the user
            $user = User::create([
              'name'     => $data['name'],
              'email'    => $data['email'],
              'password' => Hash::make($data['password']),
            ]);

            // 2) create the patient profile
            $user->patient()->create([
              'contact_number' => $data['contact_number'],
              'age'            => $data['age'],
              'gender'         => $data['gender'],
            ]);
        });

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient created.');
    }

    public function edit(Patient $patient)
    {
        // we need the related user for the form
        $patient->load('user');
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,'.$patient->user_id,
            'contact_number'  => 'required|string|max:20',
            'age'             => 'required|integer|min:0',
            'gender'          => 'required|in:male,female,other',
        ]);

        DB::transaction(function() use($data, $patient) {
            // 1) update user
            $patient->user->update([
              'name'  => $data['name'],
              'email' => $data['email'],
            ]);

            // 2) update profile
            $patient->update([
              'contact_number' => $data['contact_number'],
              'age'            => $data['age'],
              'gender'         => $data['gender'],
            ]);
        });

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient updated.');
    }

    public function destroy(Patient $patient)
    {
        // deleting the user will cascade to patient
        $patient->user->delete();

        return back()->with('success', 'Patient deleted.');
    }
}
