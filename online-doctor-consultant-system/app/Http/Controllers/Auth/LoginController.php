<?php

namespace App\Http\Controllers\Auth;




// app/Http/Controllers/Auth/LoginController.php



use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors(['email' => 'These credentials do not match our records.'])
                ->withInput($request->only('email', 'remember'));
        }

        // Regenerate session to prevent fixation
        $request->session()->regenerate();

        // Optionally set a custom cookie:
        if ($request->boolean('remember')) {
            Cookie::queue('user_email', Auth::user()->email, 60 * 24 * 30);
        }

        // Example policy check: only allow admins to go to /admin
        if (Auth::user()->can('viewAdminDashboard')) {
            return redirect()->intended('/admin');
        }

        return redirect()->intended('/dashboard');
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Forget any custom cookie
        Cookie::queue(Cookie::forget('user_email'));

        return redirect('/');
    }
}

