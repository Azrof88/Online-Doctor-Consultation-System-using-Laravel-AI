<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\User;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use PDF;    // Barryvdh\DomPDF\Facade\Pdf




class AuthController extends Controller
{
    // Show the registration form
    public function showRegister()
    {
        return view('register');
    }




    public function register(Request $req)
    {
        // 1) validate
        $data = $req->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'mobile'                => 'required|string|max:50',
            'user_type'             => 'required|in:admin,doctor,patient',
            'password'              => 'required|confirmed|min:6',
        ]);

        // 2) create user
        $user = User::create([
          'name'       => $data['name'],
          'email'      => $data['email'],
          'mobile'     => $data['mobile'],
          'user_type'  => $data['user_type'],
          'password'   => Hash::make($data['password']),
        ]);

        // 1) render the PDF
$pdf = PDF::loadView('pdf.welcome', ['user' => $user]);

// 2) send the mail with PDF attached
Mail::raw(
    "Hello {$user->name},\n\nThank you for registering at Online Doctor System. Your registration details are attached as a PDF.",
    function($msg) use ($user, $pdf) {
        $msg->to($user->email)
            ->subject('Welcome to Online Doctor System')
            ->attachData(
                $pdf->output(),
                'Registration-Details.pdf',
                ['mime' => 'application/pdf']
            );
    }
);

        // 4) log them in by session
        session([
          'user_id'   => $user->id,
          'user_type' => $user->user_type,
        ]);

        return redirect()->route('dashboard')
                         ->with('status', 'Registration successful! A welcome email has been sent.');
    }



    // Show the login form
    public function showLogin()
    {
        return view('login');
    }

    // Handle login POST
    public function login(Request $req)
    {
        // 1) validate
        $creds = $req->validate([
          'email'    => 'required|email',
          'password' => 'required',
        ]);

        // 2) lookup & verify
        $user = User::where('email', $creds['email'])->first();
        if (! $user || ! Hash::check($creds['password'], $user->password)) {
            return back()->withErrors(['email' => 'Invalid credentials']);
        }

        // 3) set session
        session(['user_id' => $user->id, 'user_type' => $user->user_type]);
        // 4) If “remember me” checked → generate & save token + set cookie
    if($req->filled('remember')) {
        $token = Str::random(60);
        $user->remember_token = $token;
        $user->save();

        // 30 days, in minutes
        Cookie::queue('remember_token',$token, 60*24*30);
        Cookie::queue('remember_user',$user->id, 60*24*30);
      }

        return redirect()->route('dashboard');
    }

    // Log out
    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }


// public function verifyEmail(Request $req, $id)
// {
//     $user = User::findOrFail($id);
//     $user->email_verified_at = now();
//     $user->save();

//     return redirect()->route('login')
//                      ->with('status','Email verified—please log in.');
// }


}
