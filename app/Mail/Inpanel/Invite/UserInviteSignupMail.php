<?php

namespace App\Mail\Inpanel\Invite;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;

/**
 * This mail class is used to send the Invite user signup Email.
 *
 * Class UserInviteSignupMail
 * @author Vikash Yadav
 * @access public
 * @package  App\Mail\Inpanel\Invite\UserInviteSignupMail
 */

class UserInviteSignupMail extends Mailable
{
    use Queueable, SerializesModels;


    public $user, $referredName, $get_referal_point,$referred_first_name;


    public function __construct($user, $referredName, $get_referal_point,$referred_first_name)
    {
        $this->user = $user;
        $this->referredName = $referredName;
        $this->get_referal_point = $get_referal_point;
        $this->referred_first_name = $referred_first_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $locale=$user->locale;
        app()->setLocale($locale);
        $countryPoint = DB::table('country_points')->where('country_language', $locale)->first();   
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
        
        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {
            
            $cntry = explode('_',$countryPoint->country_language);
            
            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang'=>$cntry[1],
                'countryPoint'=>$countryPoint->points,
            );
        } 

        $referralName = $user->first_name;
        $referredName = $this->referredName;
        $referralEmail = $user->email;
        $referred_first_name = $this->referred_first_name;
        $get_referal_point = $this->get_referal_point;
        // return $this->to($referralEmail, $referralName)
        //     ->view('inpanel.mail.invite.signup_invitation',
        //         compact('user', 'referralName','referredName','get_referal_point'))
        //     ->subject(__('inpanel.mail.invitation.signupSubject'))
        //     ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
        return $this->to($referralEmail, $referralName)
        ->view('inpanel.mail.invite.signup_invitation',
            compact('user', 'referralName','referredName','get_referal_point','referred_first_name','currencies'))
        ->subject(__('inpanel.mail.invitation.signup_invite_subject'))
        ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
