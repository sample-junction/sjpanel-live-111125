<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActiveUser
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && !Auth::user()->active) {
            Auth::logout();
            return redirect('/login')->withErrors('Your account is deactivated.');
        }
        return $next($request);
    }
}