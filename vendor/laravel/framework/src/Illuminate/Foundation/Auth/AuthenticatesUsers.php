<?php

namespace Illuminate\Foundation\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use App\Models\user_ip_map;

trait AuthenticatesUsers
{
    use RedirectsUsers, ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }
        
        if ($this->attemptLogin($request) ) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function login_old(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $proxytest = $this->checkProxy($request);
        $attemptLogin = $this->attemptLogin($request);
        
        if ($attemptLogin && $proxytest) {
            return $this->sendLoginResponse($request);
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }
    
    protected function attemptLogin_old(Request $request)
    {
        /*return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );*/

        $result = $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
        if ($result) {
            $user = auth()->user();
            $country = $user->country_code;
            $zipcode = $user->zipcode;
            $uid     = $user->id;

            /*
            * Get Client's country and lattitue/longitue from there IP and validate with User's 
            * Provided country
            */
            $geoip = geoip(request()->ip());
            $current_ip =  $geoip->getAttribute('ip');
            $ipcountryCode = $geoip->getAttribute('iso_code');
            /*$lat = $geoip->getAttribute('lat');
            $lon = $geoip->getAttribute('lon');*/
            
            $ipDClassCheck = $this->ipDClassCheck($current_ip, $uid);
            if($ipDClassCheck >= 2)
            {
                $this->guard()->logout();
                $request->session()->invalidate();

                throw ValidationException::withMessages([
                    $ipcountryCode.'-Dclass-loginfraud' => [trans('auth.repeatedIPFraudLogin')],
                ]);
            }
            else if($country && $country != $ipcountryCode)
            {
                $this->guard()->logout();
                $request->session()->invalidate();
                
                throw ValidationException::withMessages([
                    $this->username() => [trans('auth.countryLocationFraud')],
                ]);
            }else{
                $this->setUserLoginIP($uid, $current_ip);
                return true;
            }
        }
        return false;
        
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // protected function credentials(Request $request)
    // {
    //     return $request->only($this->username(), 'password');
    // }

    protected function credentials(Request $request)
    {
        return ['email_hash' => sha1($request->email), 'password' => ($request->password)];
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Attempt to check the client's proxy, vpn or tor network
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function checkProxy(Request $request)
    {
        $key = 'Jaxm7e3Msbmj74a19Uay0ZI0uhws4p7H';
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_CLIENT_IP'];

        $strictness = 1;
        $result = json_decode(file_get_contents(sprintf('https://ipqualityscore.com/api/json/ip/%s/%s?strictness=%s', $key, $ip, $strictness)), true);

        // Remove $ip condition from below on production
        if($result !== null && $ip!='127.0.0.1'){ 
            if($result['vpn'] || $result['tor']){
                //exit("Please disable your proxy connection!");            
                throw ValidationException::withMessages([
                    $this->username() => [trans('auth.proxyFraud')],
                ]);
            }
        }
        return true;
    }

    protected function setUserLoginIP($id, $ip)
    {
        user_ip_map::create(['user_id'      => $id, 'user_ip'      => $ip ]);
    }

    /**
     * Attempt to check the similar Ip's D class check
     *
     * @return bool
     */
    protected function ipDClassCheck($ip, $uid)
    {
        $abcClass = substr($ip, 0, strrpos($ip, "."));
        $Dclass = substr($ip, strrpos($ip, ".")+1);

        //DB::enableQueryLog();
        $info = DB::select("SELECT SUBSTRING_INDEX(user_ip, '.', 3) AS abc_Class 
            ,COUNT(SUBSTRING_INDEX(user_ip, '.', 3)) AS abc_Class_cnt 
            ,group_concat(id)
            ,group_concat(user_ip)
            FROM user_ip_maps
            WHERE
            user_id = $uid
            AND SUBSTRING_INDEX(user_ip, '.', 3) = '$abcClass'
            AND SUBSTRING_INDEX(user_ip, '.', -1) != '$Dclass'
            GROUP BY SUBSTRING_INDEX(user_ip, '.', 3) ");
        //dd(DB::getQueryLog());
        
        return (count($info) > 0) ? $info[0]->abc_Class_cnt : 0 ;
    }
}
