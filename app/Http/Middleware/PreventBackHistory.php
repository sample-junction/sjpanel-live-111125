<?php
namespace App\Http\Middleware;

use Auth;
use Closure;


class PreventBackHistory
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
        $user = Auth::user();
        $user_id=@$user->id;
        if($request->user()->filled_basic_details==1){
            return redirect()->route('inpanel.dashboard');
        }else{
          $response = $next($request);
        return $response->header('Cache-Control','nocache, no-store, max-age=0, must-revalidate')
            ->header('Pragma','no-cache')
            ->header('Expires','Sun, 02 Jan 2025 00:00:00 GMT');  
        }
        
    }
}
?>