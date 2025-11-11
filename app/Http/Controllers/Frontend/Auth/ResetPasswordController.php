<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\Auth\ResetPasswordRequest;
use App\Mail\Frontend\UserConfirm\resetPasswordSuccess;
use Illuminate\Support\Facades\Mail;
use App\Models\Auth\User;


/**
 * This class ios used for Reset Password.
 *
 * Class ResetPasswordController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Frontend\Auth\ResetPasswordController
 */

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * ChangePasswordController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param string|null $token
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetForm($token = null ,Request $request)
    {
        if (! $token) {
            return redirect()->route('frontend.auth.password.email');
        }

        $user = $this->userRepository->findByPasswordResetToken($token);
                $geodata = geoip(request()->ip());
        $ipcountryCode = $geodata->getAttribute('iso_code');
        $country=$geodata->getAttribute('country');
        
        if($ipcountryCode!='US'){
            if(!empty($request->session()->get('locale'))){
                $flag=str_replace('_','-',strtoupper($request->session()->get('locale')));
            }else{
              app()->setLocale('EN-'.$ipcountryCode);
              $flag='EN-'.$ipcountryCode;  
            }
            
        }else{
            $flag=str_replace('_','-',strtoupper($request->session()->get('locale')));
        }

        if ($user && app()->make('auth.password.broker')->tokenExists($user, $token)) {
            return view('frontend.auth.passwords.reset')
                ->withToken($token)
                ->withEmail($user->email)
                ->with('email',$user->email)
                ->with('country_code',$ipcountryCode)
                ->with('flags',$flag);
                // ->with('email',$request->get('email',false));
        }

        // return redirect()->route('frontend.auth.password.email')
        //     ->withFlashDanger(__('exceptions.frontend.auth.password.reset_problem'));
    }

    /**
     * Reset the given user's password.
     *
     * @param  ResetPasswordRequest  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $request->email_hash = sha1($request->email);
        $resetUser = null;
        //print_r($user);die;
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) use (&$resetUser) {
                $this->resetPassword($user, $password);
                $resetUser = $user;
            }
        );

        // echo "<pre>";
        // print_r($response); die();

        // $user = auth()->user();

        if($response == 'passwords.reset' && $resetUser){

            try {
                Mail::to($resetUser->email)->send(new resetPasswordSuccess($resetUser));
                // return response()->json(['success' => true, 'message' => __('inpanel.user.profile.preferences.two_fact.sendOtp')]);
     
            } catch (Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

        }

       // print_r($response);die;
        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response = Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($request, $response);
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {

        $user->password = $password;

        $user->password_changed_at = now();

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));
        if($user->active){
            $this->guard()->login($user);
        }else{
            return redirect()->route('frontend.auth.login');
        }
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($response)
    {
        // return redirect()->route(home_route())->withFlashSuccess(trans($response));
        return view('frontend.auth.reset-thanks');
        // return view ('frontend.auth.reset-password-email')->with('email' , $request->get('email'));
    }

    public function thankYou(Request $request){
        return view ('frontend.auth.password.thanks');
    }
}
