<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
//use SSLCommerz;
use Karim007\SslCommerzLaravel\SslCommerzNotification;
class PatientPaymentController extends Controller
{
    /**
     * List this patient’s payments.
     */
    public function index()
{
    // 1) Grab the Patient model
    $patient = Auth::user()->patient;

    // 2) Build your query off the payments() relation
    $payments = $patient
        ->payments()                  // Relation, not ->payments (prop)
        ->with('appointment.doctor')  // eager-load nested models
        ->latest()                    // same as orderByDesc('created_at')
        ->paginate(10);
        // in index() before return:
// dd(
//   $payments->first()->appointment,
//   $payments->first()->appointment->doctor
// );
      // returns a LengthAwarePaginator

    // 3) Send to your view
    return view('patient.payments.index', compact('payments'));
}


    /**
     * Show one payment’s details.
     */
    public function show($id)
    {
        $payment = Auth::user()
                       ->patient
                       ->payments()
                       ->findOrFail($id);

        return view('patient.payments.show', compact('payment'));
    }

    /**
     * Kick off SSLCommerz for a “pending” appointment.
     */
   public function pay(Appointment $appointment)
     {
//         dd(
//   app()->has('sslcommerznotification'),
//   app('sslcommerznotification')
// );

        // grab the currently‐logged‐in patient's DB row:
     $patient = Auth::user()->patient;
    //  dd([
    //     'Auth::id() (user.id)'       => Auth::id(),
    //     'Patient record (patient)'   => $patient,
    //     'Patient model ->id'         => $patient?->id,
    //     'Appointment->patient_id'    => $appointment->patient_id,
    //     'Appointment->status'        => $appointment->status,
    //   ]);
    // now ensure that appointment really belongs to *that* patient:
  // abort_unless($appointment->patient_id === $patient->id, 403);

    // …and the rest of your checks…
   // abort_if($appointment->status !== 'pending', 400);
    // …
// Store the doctor's fee on the appointment row (if you haven't yet)
    $appointment->fee = $appointment->doctor->fee;
    $appointment->save();
        $post_data = [
            'total_amount' => $appointment->doctor->fee,
            'currency'     => 'BDT',
            'tran_id'      => 'APPT_' . $appointment->id . '_' . time(),
            'success_url'  => config('app.url').'/sslcommerz/success',
            'fail_url'     => config('app.url').'/sslcommerz/fail',
            'cancel_url'   => config('app.url').'/sslcommerz/cancel',
            'ipn_url'      => config('app.url').'/sslcommerz/ipn',
            'cus_name'     => Auth::user()->name,
            'cus_email'    => Auth::user()->email,
            'cus_phone'    => Auth::user()->mobile,
        ];


    //    // 3) Kick off the checkout in “inline” (same‐tab) mode
    //     /** @var SslCommerzNotification $gateway */
    //     $gateway  = app('sslcommerznotification');
    //     // Try passing only two arguments (no 'json')
    // try {
    //     $response = $gateway->makePayment($post_data, 'checkout');
    // } catch (\Throwable $e) {
    //     dd('Exception from makePayment:', $e->getMessage());
    // }

    // // Dump whatever we got back:
    // dd($response);

       // 3) Create a checkout session (JSON mode)
$gateway = app('sslcommerznotification');
$raw     = $gateway->makePayment($post_data, 'checkout', 'json');

// 4) Decode and validate
$session = json_decode($raw, true);
if (json_last_error() !== JSON_ERROR_NONE || empty($session['status']) || strtolower($session['status'])!=='success' || empty($session['data'])) {
    \Log::error('SSLCommerz session init failed', ['raw'=>$raw,'session'=>$session]);
    abort(500, 'Could not start payment session.');
}

// 5) Redirect in the same tab to the checkout URL
return redirect()->away($session['data']);

    }





    public function success(Request $request)
   {
    // 🔍 Debug right away
    \Log::info("SSL success callback", [
      'method' => $request->method(),
      'url'    => $request->fullUrl(),
      'all'    => $request->all(),
    ]);
    dd($request->method(), $request->fullUrl(), $request->all());

    // 1) Validate the callback payload
    $notifier  = new SslCommerzNotification();
    $validated = $notifier->orderValidate($request);

    if ($validated && $request->status === 'VALID') {
        // 2) Extract the appointment ID from "APPT#{$id}_{$timestamp}"
        [ $transactionId, $ts ] = explode('_', $request->tran_id, 2);
        $appointmentId = (int) Str::after($transactionId, 'APPT#');

        // 3) Mark the appointment confirmed
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->status = 'confirmed';
        $appointment->save();

        return redirect()
            ->route('patient.appointments.index')
            ->with('status', 'Payment successful!');
    }

    // 4) If validation fails
    return redirect()
        ->route('patient.appointments.index')
        ->withErrors('Payment validation failed.');
}


    /**
     * IPN listener.
     */
    public function ipn(Request $req)
    {
       // 1) instantiate the real notifier
        $notifier  = new SslCommerzNotification();

        // 2) validate the incoming IPN payload
        $validated = $notifier->orderValidate($req);

        if ($validated && $req->status === 'VALID') {
            // mark appointment, send email, etc.
        }

        return response('OK',200);
    }

    /**
     * Customer returns here on fail or cancel.
     */
    public function fail(Request $request)
    {
        \Log::info("SSLCommerz fail callback", [
    'method' => $request->method(),
    'url'    => $request->fullUrl(),
    'data'   => $request->all(),
  ]);
  dd('Called fail()', $request->method(), $request->fullUrl());
        return redirect()
            ->route('patient.appointments.index')
            ->withErrors('Payment cancelled or failed.');
    }
}
