<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:20 PM
 */

namespace App\Mail\Backend\RedeemApprove;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;

/**
 * This mail class is used to send the redeem approval mail to the User after changing
 * the status of Redeem Request from pending to approve By admin.
 *
 * Class RedeemApprovedEmail
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Backend\RedeemApprove\RedeemApprovedEmail
 */

class LapsedEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;


    public function __construct($user,$lapsed_val,$redeem_request_points)
    {
        $this->user = $user;
        $this->lapsed_val = $lapsed_val;
        $this->redeem_request_points = $redeem_request_points;
    }
    public function build()
    {
        $user = $this->user;
        $locale=$user->locale;
        app()->setLocale($locale);
        $lapsed_val = $this->lapsed_val;
        $redeem_request_points = $this->redeem_request_points;
		
		/* 07-10-2025 */
		
		$locale = $user->locale;
        
        $countryPoint = DB::table('country_points')->where('country_language', $locale)->first();   
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
        
        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {
            
            $cntry = explode('_',$countryPoint->country_language);
            
            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural
            );
        } 
		
		$metricConversion = 1/$countryPoints;	
		
		
		if($redeem_request_points*$metricConversion < 1){
			$currency = ($redeem_request_points*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
			$points = number_format($redeem_points*$metricConversion,2)." ".__($currency);
		}else{
			$points = $currencies['currency_logo']. number_format($redeem_request_points*$metricConversion,2);
		}
		
		
		/* 07-10-2025 */
		
		
        return $this->to($user->email, $user->first_name)
            ->view('inpanel.redeem.mail.user_mail_lapsed',
                compact('user','points','redeem_request_points'))
            //->text('frontend.mail.contact-text')
            ->subject(__('inpanel.mail.invitation.lapsed_subject_1',['lapsed_point'=>$points]))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
