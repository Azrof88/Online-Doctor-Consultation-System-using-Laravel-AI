<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
//use SSLCommerz;
use Karim007\SslCommerzLaravel\SslCommerzNotification;
class PatientPaymentController extends Controller
{
    /**
     * List this patient’s payments.
     */
    public function index()
    {
        $payments = Auth::user()
                        ->patient              // assumes your User→patient() relation
                        ->payments()           // and Patient→payments() relation
                        ->latest()
                        ->get();

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
            'total_amount' => $appointment->doctor->fee,   // your fee field
            'currency'     => 'BDT',
            'tran_id'      => 'APPT#'.$appointment->id.'_'.time(),
            'success_url'  => route('sslcommerz.success'),
            'fail_url'     => route('sslcommerz.fail'),
            'cancel_url'   => route('sslcommerz.cancel'),
            'ipn_url'      => route('sslcommerz.ipn'),
            'cus_name'     => Auth::user()->name,
            'cus_email'    => Auth::user()->email,
            'cus_phone'    => Auth::user()->mobile,
        ];


       // return SSLCommerz::makePayment($post_data, 'hosted');
        // <— resolve the service by its container key (no facade needed)
        $gateway = app('sslcommerznotification');
      //  dd($post_data);

    return $gateway->makePayment($post_data, 'hosted');
    }

    /**
     * Customer returns here on success.
     */


public function success(Request $request)
{
    dd($request->method(), $request->all());

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
        $validated = $notifier->orderValidate($request);

        if ($validated && $req->status === 'VALID') {
            // mark appointment, send email, etc.
        }

        return response('OK',200);
    }

    /**
     * Customer returns here on fail or cancel.
     */
    public function fail(Request $req)
    {
        return redirect()
            ->route('patient.appointments.index')
            ->withErrors('Payment cancelled or failed.');
    }
}
