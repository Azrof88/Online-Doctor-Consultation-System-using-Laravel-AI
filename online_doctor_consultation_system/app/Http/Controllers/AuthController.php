<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Models\Doctor;
use App\Models\Patient;
use PDF;    // Barryvdh\DomPDF\Facade\Pdf
use Illuminate\Support\Facades\Auth;         // ← add

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;



class AuthController extends Controller
{
    // Show the registration form
    public function showRegister()
    {
        $roles       = Role::all();
        $adminExists = User::where('role', 1)->exists();             // true if someone already picked Admin
        return view('register', compact('roles','adminExists'));

    }




    public function register(Request $req)
    {
        $doctorRoleId = Role::where('name','doctor')->value('id');
        // 1) Build validation rules
        $rules = [
            'name'       => 'required|string|max:255',
            'email'      => 'required|email',
            'mobile'     => 'required|string|max:50',
            'role'     => 'required|in:1,2,3',
            'password'   => 'required|confirmed|min:6',
            'zoom_link'             => [
      'nullable',
      'url',
      'required_if:role,'.$doctorRoleId
  ],
        ];

        // If resetting (prefilled form had hidden id), require & skip unique email
        if ($req->filled('id')) {
            $rules['id'] = 'required|exists:users,id';
        } else {
            // brand-new signup must have unique email
            $rules['email'] .= '|unique:users,email';
        }

        // 2) Validate incoming data
        $data = $req->validate($rules);

        // 3) Either reset password or create new user
        if ($req->filled('id')) {
            // Password reset branch
            $user = User::find($data['id']);
            $user->password = Hash::make($data['password']);
            $user->save();

            // (Optional) send a “Your password has been changed” email
            Mail::raw(
                "Hello {$user->name},\n\nYour password has been successfully updated.",
                function($msg) use ($user) {
                    $msg->to($user->email)
                        ->subject('Password Updated – Online Doctor System');
                }
            );

        } else {
            // New registration branch
            $user = User::create([
                'name'       => $data['name'],
                'email'      => $data['email'],
                'mobile'     => $data['mobile'],
                'role'  => $data['role'],
                'password'   => Hash::make($data['password']),
            ]);
            if ($data['role'] == $doctorRoleId) {
    $user->doctor()->create([
        // user_id is filled automatically by the relation
        'name'      => $user->name,           // required column
        'zoom_link' => $data['zoom_link'],    // from your form
        // specialization, bio, availability_schedule
        // are all nullable in the schema and can be omitted
        // fee has a default of 0, so you can omit it too
    ]);
}

            // Log them in
Auth::login($user);




            // Generate PDF of registration details
            $pdf = Pdf::loadView('pdf.welcome', ['user' => $user]);

            // Send welcome email with PDF attached
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
        }

        // 4) Log user in via session
        session([
            'user_id'   => $user->id,
            'role' => $user->role,
        ]);

        // 5) Redirect to dashboard
        $message = $req->filled('id')
            ? 'Password updated! You’re now logged in.'
            : 'Registration successful! A welcome email has been sent.';

        return redirect()->route('dashboard')
                         ->with('status', $message);
    }



    // Show the login form
    public function showLogin()
    {
        return view('login');
    }


        public function login(Request $req)
    {
        // 1) validate
        $creds = $req->validate([
            'email'    => 'required|email',
            'password' => 'required',
            'remember' => 'nullable|boolean',
        ]);

        // 2) attempt login (with optional “remember me”)
        if (Auth::attempt([
                'email'    => $creds['email'],
                'password' => $creds['password'],
            ], $req->filled('remember'))
        ) {
            // 3) regenerate session to prevent fixation
            $req->session()->regenerate();

            // 4) redirect to intended (or dashboard)
            return redirect()->intended(route('dashboard'));
        }

        // 5) invalid credentials
        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }


    // Log out
    public function logout(Request $req)
    {
        // 1) invalidate session
        // 2) regenerate CSRF token
        // 3) redirect to login page

        Auth::logout();
    $req->session()->invalidate();
    $req->session()->regenerateToken();

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

public function showForgotForm()
{
    return view('auth.forgot-email');
}

// 2) Validate & redirect to the “prefill register” URL
public function redirectToPrefillRegister(Request $req)
{
    $req->validate(['email'=>'required|email']);
    $user = User::where('email',$req->email)->first();

    if (! $user) {
        return back()->withErrors(['email'=>'No account found with that email.']);
    }

    return redirect()->route('register.prefill',['id'=>$user->id]);
}

// 3) Load the same register view, but pass in the $user so it can prefill all fields
public function showPrefillRegister($id)
{
    $user = User::findOrFail($id);
    $adminExists = User::where('role','1')->exists();
    return view('register', compact('user','adminExists'));
}


}
