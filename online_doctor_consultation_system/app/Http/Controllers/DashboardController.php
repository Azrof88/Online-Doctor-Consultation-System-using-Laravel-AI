<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;

class DashboardController extends Controller
{
    public function index(Request $req)
    {
        // Auto-login via “remember me” cookie if no session exists
        if (! $req->session()->has('user_id') && $req->cookie('remember_token')) {
            $user = User::where('id', $req->cookie('remember_user'))
                        ->where('remember_token', $req->cookie('remember_token'))
                        ->first();
            if ($user) {
                session([
                    'user_id' => $user->id,
                    'role'    => $user->role,
                ]);
            }
        }

        // 1) Ensure user is “logged in”
        $userId = $req->session()->get('user_id');
        if (! $userId) {
            return redirect()->route('login');
        }

        // 2) Fetch the user
        $user = User::find($userId);
        if (! $user) {
            return redirect()->route('login');
        }

        // 3) Return the view based on role
        switch ($user->role) {
            case 1: // Admin
                // load doctors & patients for the admin dashboard
                $doctors  = Doctor::with('user')->get();
                $patients = Patient::with('user')->get();

                return view('dashboards.admin', compact('user','doctors','patients'));

            case 2: // Doctor
                return view('dashboards.doctor', compact('user'));

            case 3: // Patient
                return view('dashboards.patient', compact('user'));

            default:
                abort(403);
        }
    }
}
