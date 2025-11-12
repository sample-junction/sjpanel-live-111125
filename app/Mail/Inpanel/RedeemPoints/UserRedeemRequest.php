<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:39 PM
 */

namespace App\Mail\Inpanel\RedeemPoints;

use App\Models\Redeem\RequestRedeem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;
/**
 * This mail request is used to send the mail to user after redeem request.
 *
 * Class UserRedeemRequest
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Inpanel\RedeemPoints\UserRedeemRequest
 */

class UserRedeemRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $request_redeem;
    public function __construct($user,$request_redeem)
    {
        $this->user = $user;
        $this->request_redeem = $request_redeem;
    }
    public function build()
    {
       $user = $this->user;
        $request_redeem = $this->request_redeem;
        $total_awaited_points = $request_redeem->redeem_points;
        /* Parshant Sharma [22-08-2024] Starts */
        
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
				
        /* Parshant Sharma [22-08-2024] Ends */
		
        // return $this->to($user->email, $user->first_name)
        //     ->view('inpanel.redeem.mail.user_mail',
        //         compact('user','request_redeem'))
        //     //->text('frontend.mail.contact-text')
        //     ->subject(__('inpanel.redeem.index.mail.user'))
        //     ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
		
       /*  if($cntry['1']!='UK'){


        if($total_awaited_points*config('app.points.metric.conversion') < 1){
            $points = $total_awaited_points*config('app.points.metric.conversion')*100 . __('inpanel.dashboard.cents');
        }else{
            $points = $currencies['currency_logo']. $total_awaited_points*config('app.points.metric.conversion');
        }
    }else{
        $total_awaited_points=number_format($total_awaited_points/$countryPoint->points,2);
        if($total_awaited_points < 1){
            $currency = ($total_awaited_points*config('app.points.metric.conversion')*100 < 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
            $points = __($currency)." ". number_format($total_awaited_points,2);
        }else{
            $points = $currencies['currency_logo']. number_format($total_awaited_points,2);
        }

    } */
	
	if($total_awaited_points*$metricConversion < 1){
		$currency = ($total_awaited_points*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
		$points = number_format($total_awaited_point*$metricConversion,2)." ".__($currency);
	}else{
		$points = $currencies['currency_logo']. number_format($total_awaited_points*$metricConversion,2);
	}
		
    $lang=$cntry['1'];
	
    $countryPoints=$countryPoint->points;
        return $this->to($user->email, $user->first_name)
        ->view('inpanel.redeem.mail.user_mail',
            compact('user','request_redeem','currencies','lang','countryPoints'))
        ->subject(__('inpanel.mail.invitation.user_email_subject',['redeem_point'=> $points]))
        ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
