<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::orderBy('id','desc')->paginate(10);
        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
          'name'           => 'required|string',
          'email'          => 'required|email|unique:doctors',
          'mobile'         => 'required',
          'specialization' => 'required',
        ]);

        Doctor::create($data);
        return redirect()->route('admin.doctors.index')
                         ->with('success','Doctor added.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
          'name'           => 'required|string',
          'email'          => 'required|email|unique:doctors,email,'.$doctor->id,
          'mobile'         => 'required',
          'specialization' => 'required',
        ]);

        $doctor->update($data);
        return redirect()->route('admin.doctors.index')
                         ->with('success','Doctor updated.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return back()->with('success','Doctor removed.');
    }
}
