<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
// app/Http/Controllers/DashboardController.php
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
                    'user_id'   => $user->id,
                    'role' => $user->role,
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
            case 1:
                return view('dashboards.admin', compact('user'));
            case 2:
                return view('dashboards.doctor', compact('user'));
            case 3:
                return view('dashboards.patient', compact('user'));
            default:
                abort(403);
        }
    }
}
