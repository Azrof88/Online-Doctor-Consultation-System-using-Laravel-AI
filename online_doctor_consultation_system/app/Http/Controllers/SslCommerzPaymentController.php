<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Order;

class SslCommerzPaymentController extends Controller
{

    public function showPayForm(Appointment $appointment)
{
    return view('patient.payments.confirm', compact('appointment'));
}

    public function exampleEasyCheckout()
    {
        return view('exampleEasycheckout');
    }

    public function exampleHostedCheckout()
    {
        return view('exampleHosted');
    }

    public function index(Request $request, Appointment $appointment)
{
    // 1) Get authenticated patient
    $patient = auth()->user()->patient;
    $user = $patient->user; // get the related user

    // 2) Check appointment belongs to patient (optional, for security)
    if ($appointment->patient_id !== $patient->id) {
        abort(403, 'Unauthorized payment attempt.');
    }

    // 3) Prepare payment data
    $post_data = [];

    $post_data['total_amount'] = $appointment->fee;  // real fee
    $post_data['currency'] = "BDT";
    $post_data['tran_id'] = uniqid(); // unique transaction ID

    // Customer info from patient
    $post_data['cus_name'] = $user->name;
    $post_data['cus_email'] = $user->email;
    $post_data['cus_add1'] = $patient->address ?? '';
    $post_data['cus_phone'] = $user->mobile;

    // SHIPMENT INFO (optional or static)
    $post_data['shipping_method'] = "NO"; // For virtual/online products like doctor consultation

    $post_data['ship_name'] = "Online Doctor Service";
    $post_data['ship_add1'] = "Sylhet";
    $post_data['ship_city'] = "Sylhet";
    $post_data['ship_postcode'] = "3100";
    $post_data['ship_country'] = "Bangladesh";

    $post_data['product_name'] = "Doctor Appointment";
    $post_data['product_category'] = "Service";
    $post_data['product_profile'] = "general";

    // Optional params
    $post_data['value_a'] = $appointment->id;
    $post_data['value_b'] = $patient->id;

    // 4) Save or update order in DB
    Order::updateOrCreate(
    ['transaction_id' => $post_data['tran_id']],
    [
        'name' => $post_data['cus_name'],
        'email' => $post_data['cus_email'],
        'phone' => $post_data['cus_phone'],
        'amount' => $post_data['total_amount'],
        'status' => 'Pending',
        'address' => $post_data['cus_add1'],
        'currency' => $post_data['currency'],
        'appointment_id' => $appointment->id,
    ]
);
    // 5) Initiate SSLCommerz payment (hosted checkout)
    $sslc = new SslCommerzNotification();
    $payment_options = $sslc->makePayment($post_data, 'hosted');

    if (!is_array($payment_options)) {
        // payment initiation failed
        return redirect()->back()->withErrors('Payment initiation failed.');
    }
}


    public function payViaAjax(Request $request, Appointment $appointment)
{
    $patient = auth()->user()->patient;
    $user = $patient->user; // get the related user

    if ($appointment->patient_id !== $patient->id) {
        return response()->json(['status' => 'fail', 'message' => 'Unauthorized payment.'], 403);
    }

    $post_data = [];
    $post_data['total_amount'] = $appointment->fee;
    $post_data['currency'] = "BDT";
    $post_data['tran_id'] = uniqid();

    // CUSTOMER INFO
    $post_data['cus_name'] = $patient->name;
    $post_data['cus_email'] = $user->email;
    $post_data['cus_add1'] = $patient->address ?? 'Dhaka';
    $post_data['cus_country'] = "Bangladesh";
    $post_data['cus_phone'] = $user->mobile;

    // SHIPMENT INFO (optional or static)
    $post_data['shipping_method'] = "NO"; // For virtual/online products like doctor consultation

    $post_data['ship_name'] = "Online Doctor Service";
    $post_data['ship_add1'] = "Sylhet";
    $post_data['ship_city'] = "Sylhet";
    $post_data['ship_postcode'] = "3100";
    $post_data['ship_country'] = "Bangladesh";

    $post_data['product_name'] = "Doctor Appointment";
    $post_data['product_category'] = "Service";
    $post_data['product_profile'] = "general";

    // Optional params
    $post_data['value_a'] = $appointment->id;
    $post_data['value_b'] = $patient->id;

    // Callback URLs
    $post_data['success_url'] = url('/success');
    $post_data['fail_url'] = url('/fail');
    $post_data['cancel_url'] = url('/cancel');
    $post_data['ipn_url'] = url('/ipn');

    // Store payment
   Order::updateOrCreate(
    ['transaction_id' => $post_data['tran_id']],
    [
        'name' => $post_data['cus_name'],
        'email' => $post_data['cus_email'],
        'phone' => $post_data['cus_phone'],
        'amount' => $post_data['total_amount'],
        'status' => 'Pending',
        'address' => $post_data['cus_add1'],
        'currency' => $post_data['currency'],
        'appointment_id' => $appointment->id,
    ]
);

    // Call SSLCommerz
    $sslc = new SslCommerzNotification();

//dd($payment_options);

    $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

if (is_string($payment_options)) {
    $payment_options = json_decode($payment_options, true);
}

if (isset($payment_options['status']) && $payment_options['status'] == 'success') {
    return redirect()->away($payment_options['data']);
} else {
    return redirect()->back()->with('error', $payment_options['message'] ?? 'Payment gateway initialization failed.');
}


}


public function success(Request $request)
{
    // Dump entire request to see all parameters sent by SSLCommerz
    // dd($request->all()); // Remove this in production!

    $tran_id = $request->input('tran_id');
    $amount = $request->input('amount');
    $currency = $request->input('currency');

    $sslc = new SslCommerzNotification();

    // Check if order is found or not
    $order = DB::table('orders')->where('transaction_id', $tran_id)->first();
    // dd($order); // Remove this in production!

    if (!$order) {
        return redirect()->route('patient.payments.index') // Consider a more general dashboard route if payments index isn't the primary one
            ->with('error', 'Transaction not found.');
    }

    // Check order status before validation
    // dd($order->status); // Remove this in production!

    if ($order->status === 'Pending') {
        $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);
        // dd($validation); // Remove this in production!

        if ($validation) {
            DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Processing']);

            if (!empty($order->appointment_id)) {
                DB::table('appointments')->where('id', $order->appointment_id)
                    ->update(['status' => 'confirmed']);
            }

            // Crucial step: Regenerate session ID after successful payment processing
            // This ensures a fresh CSRF token is available for the next page load.
            $request->session()->regenerate();

            // Redirect to the patient's home page
            return redirect()->route('dashboards.patient') // Assuming 'dashboards.patient' is the name of your patient dashboard/home route
                ->with('success', 'Payment successful! Your appointment is confirmed.');
        } else {
            return redirect()->route('patient.payments.index') // Or dashboards.patient with error
                ->with('error', 'Payment validation failed.');
        }
    }

    if (in_array($order->status, ['Processing', 'Complete'])) {
        // Regenerate session ID even if already processed to ensure a valid session
        $request->session()->regenerate();
        return redirect()->route('dashboards.patient') // Redirect to home even if already completed
            ->with('success', 'Transaction was already completed.');
    }

    return redirect()->route('dashboards.patient') // Redirect to home with error for invalid state
        ->with('error', 'Invalid transaction state.');
}


    public function fail(Request $request)
{
    $tran_id = $request->input('tran_id');

    $order = DB::table('orders')
        ->where('transaction_id', $tran_id)
        ->first();

    if (!$order) {
        return redirect()->route('patient.payments.index')
            ->with('error', 'Transaction not found.');
    }

    if ($order->status === 'Pending') {
        DB::table('orders')->where('transaction_id', $tran_id)
            ->update(['status' => 'Failed']);

        return redirect()->route('patient.payments.index')
            ->with('error', 'Transaction failed. Please try again.');
    }

    if (in_array($order->status, ['Processing', 'Complete'])) {
        return redirect()->route('patient.payments.index')
            ->with('success', 'Transaction already completed.');
    }

    return redirect()->route('patient.payments.index')
        ->with('error', 'Invalid transaction state.');
}


    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_details = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled']);
            echo "Transaction is Cancel";
        } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
            echo "Transaction is already Successful";
        } else {
            echo "Transaction is Invalid";
        }


    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update(['status' => 'Processing']);

                    echo "Transaction is successfully Completed";
                }
            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {

                #That means Order status already updated. No need to udate database.

                echo "Transaction is already successfully Completed";
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                echo "Invalid Transaction";
            }
        } else {
            echo "Invalid Data";
        }
    }

}
