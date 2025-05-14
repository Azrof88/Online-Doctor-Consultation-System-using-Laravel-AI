<?php

return [
  'sandbox'        => env('SSLCOMMERZ_SANDBOX', true),
    'store_id'       => env('SSLCOMMERZ_STORE_ID'),
    'store_password' => env('SSLCOMMERZ_STORE_PASSWORD'),

    // Use APP_URL from your .env so SSLCommerz can reach you back
    'success_url'    => env('APP_URL').'/sslcommerz/success',
    'fail_url'       => env('APP_URL').'/sslcommerz/fail',     // <-- note `fail_url`, not `failed_url`
    'cancel_url'     => env('APP_URL').'/sslcommerz/cancel',
    'ipn_url'        => env('APP_URL').'/sslcommerz/ipn',
    'checkout_mode' => 'inline',
// 'success_url' => route('sslcommerz.success', [], false),
// 'fail_url'    => route('sslcommerz.fail',    [], false),
// 'cancel_url'  => route('sslcommerz.cancel',  [], false),


];
