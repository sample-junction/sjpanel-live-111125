<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use DB;
/**
 * Class ForgotPasswordController.
 */
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm(Request $request)
    {
        /*Todo reset page to be setup for different languages*/
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

        return view('frontend.auth.passwords.email')
        ->with('country_code',$ipcountryCode)
        ->with('flags',$flag);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {

        // print_r($request->all());exit();
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $request->email_hash = sha1($request->email);
        $user_confirmed = DB::table('users')->where('email_hash',$request->email_hash)->where('confirmed','1')->first();

        if(!$user_confirmed){
            return Redirect::back()->withFlashDanger(__('inpanel.activity_log.invalid_reset_password_mail')); 
        }
        // $response = $this->broker()->sendResetLink(
        //     //$request->only('email')
        //     ['email_hash'=>$request->email_hash]
        // );

        $response =$this->broker()->sendResetLink(['email_hash' => $request->email_hash]);

        // print($response);exit();
        if($response != 'passwords.sent'){
        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
                }else{
        return view('frontend.auth.reset-password-email')->with('email' , $request->get('email'));
    }

        
    }
}
