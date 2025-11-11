<?php

namespace App\Mail\Inpanel\Invite;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;

/**
 * This mail class is used to send the Invite user first survey completed Email.
 *
 * Class UserInviteSurveyComplete
 * @author Vikash Yadav
 * @access public
 * @package  App\Mail\Inpanel\Invite\UserInviteSurveyComplete
 */

class UserInviteSurveyComplete extends Mailable
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
        $referralName = decrypt($user->first_name);
        $referredName = ($this->referredName);
        $referred_first_name = $this->referred_first_name;
        // echo '<pre>';
        // print_r($referralName);die();
        $referralEmail = decrypt($user->email);
        // return $this->to($referralEmail, $referralName)
        //     ->view('inpanel.mail.invite.surveyComplete_invitaion',
        //         compact('user', 'referralName','referredName','get_referal_point'))
        //     ->subject(__('inpanel.mail.invitation.surveyCompleteSubject'))
        //     ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
		
		/* Parshant Sharma [27-08-2024] STARTS */		
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
		
		/* Parshant Sharma [27-08-2024] ENDS */

        return $this->to($referralEmail, $referralName)
            ->view('inpanel.mail.invite.surveyComplete_invitaion',
                compact('user', 'referralName','referredName','get_referal_point','referred_first_name','currencies'))
            ->subject(__('inpanel.mail.invitation.survey_complete_subject'))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
