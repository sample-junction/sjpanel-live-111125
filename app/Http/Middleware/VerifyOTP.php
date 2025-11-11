<?php

namespace App\Http\Middleware;

use Closure;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class VerifyOTP
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
        $user = auth()->user();
        $secret_key = session('registration_data');
        $user->google2fa_secret = $secret_key['google2fa_secret'];
        $user->save();
        $authenticator = app(Authenticator::class)->boot($request);
        if ($authenticator->isAuthenticated()) {
            $user->two_fact_auth = 1;
            $user->two_fact_confirm = 1;
            $user->save();
            return $next($request);
        }
        /* session()->put('errors', 'Wrong OTP Entered');
         session()->forget('errors');*/
        return response()->json(['status'=>false]);
        //return redirect()->route('inpanel.dashboard');

    }
}
