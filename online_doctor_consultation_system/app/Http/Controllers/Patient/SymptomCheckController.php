<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SymptomCheck;
use Illuminate\Support\Facades\Auth;      // ← add this


class SymptomCheckController extends Controller
{
     /**
     * Show a list of this patient’s symptom checks.
     */
    public function index()
    {
        $symptomChecks = Auth::user()
            ->patient
            ->symptomChecks()      // assumes you have Patient->symptomChecks()
            ->latest()             // order newest first
            ->paginate(10);        // or ->get() if you don’t want pagination

        return view('patient.symptom-checks.index', compact('symptomChecks'));
    }


public function show(SymptomCheck $symptomCheck)
{
    // 1. Authorize: only the owner patient can view
    abort_unless(
        $symptomCheck->patient_id === Auth::user()->patient->id,
        403
    );

    // 2. Eager-load the diseases pivot
    $symptomCheck->load('diseases');

    return view('patient.symptom-checks.show', compact('symptomCheck'));
}

}
