<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
/**
 * This middleware class is used to handle incoming request that user has is blacklist or not.
 *
 * Class BlacklistProvided
 * @author Vikash Yadav(12-12-2022)
 * @access public
 * @package  App\Http\Middleware\BlacklistProvided
 */

class BlacklistProvided
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
        
        if(! is_null($request->user()) && $request->user()->is_blacklist==1) {

            return redirect()->route('inpanel.dashboard');
        }
        return $next($request);
    }
}
