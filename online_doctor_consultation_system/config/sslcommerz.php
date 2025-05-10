<?php

return [
    'sandbox'       => env('SSLCOMMERZ_SANDBOX', true),
  'store_id'      => env('SSLCOMMERZ_STORE_ID'),
  'store_password'=> env('SSLCOMMERZ_STORE_PASSWORD'),
  'success_url'   => '/sslcommerz/success',
  'failed_url'    => '/sslcommerz/fail',
  'cancel_url'    => '/sslcommerz/cancel',
// 'success_url' => route('sslcommerz.success', [], false),
// 'fail_url'    => route('sslcommerz.fail',    [], false),
// 'cancel_url'  => route('sslcommerz.cancel',  [], false),

  'ipn_url'       => '/sslcommerz/ipn',
];
