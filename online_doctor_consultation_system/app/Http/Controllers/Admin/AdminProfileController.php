<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();           // the logged-in admin
        return view('admin.profile', compact('user'));
    }

    public function update(Request $req)
    {
        $data = $req->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,'.Auth::id(),
            'mobile'   => 'required|string|max:50',
            'password' => 'nullable|confirmed|min:6',
        ]);

        $user = Auth::user();
        $user->fill($data);
        if ($data['password'] ?? false) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();

        return back()->with('status','Profile updated.');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
