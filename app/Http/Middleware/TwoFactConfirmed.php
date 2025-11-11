<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactConfirmed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(! is_null($request->user()) && $request->user()->two_fact_auth) {
            if(!$request->user()->two_fact_confirm){
                return redirect()->route('frontend.auth.2fa.otp.confirmation');
            }
        }
        return $next($request);
    }
}
