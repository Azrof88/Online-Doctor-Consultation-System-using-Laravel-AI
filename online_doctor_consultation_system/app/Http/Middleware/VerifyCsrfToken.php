<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;





use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
   public function handle($request, Closure $next)
{
    \Log::info('CSRF Check for URI: ' . $request->path());

    return parent::handle($request, $next);
}


   /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
    '/pay-via-ajax',
    '/success',
    '/cancel',
    '/fail',
    '/ipn',
    'patient/appointments/*/pay',
];

}
