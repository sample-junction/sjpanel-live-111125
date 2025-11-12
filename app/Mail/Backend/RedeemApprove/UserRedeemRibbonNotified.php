<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:39 PM
 */

namespace App\Mail\Backend\RedeemApprove;

use App\Models\Redeem\RequestRedeem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;
/**
 * This mail request is used to send the mail to user after Rybbon Notified.
 *
 * Class UserRedeemRibbonNotified
 * @author Vikash Yadav
 * @access public
 * @package  App\Mail\Backend\RedeemApprove\UserRedeemRibbonNotified
 */

class UserRedeemRibbonNotified extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $redeem_points;
    public function __construct($user,$redeem_points)
    {
        $this->user = $user;
        $this->redeem_points=$redeem_points;
    }
    public function build()
    {
       $user = $this->user;
       $locale=$user->locale;
       $redeem_points=$this->redeem_points;
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
                'currency_denom_plural' => $countryPoint->currency_denom_plural
            );
        } 
		
		/* if($cntry['1']!='UK'){
			if($redeem_points*config('app.points.metric.conversion') < 1){
				$points = $redeem_points*config('app.points.metric.conversion')*100 . __('inpanel.dashboard.cents');
			}else{
				$points = $currencies['currency_logo']. $redeem_points*config('app.points.metric.conversion');
			}
		}else{
			$redeem_points=number_format($redeem_points/$countryPoint->points,2);			
			if($redeem_points < 1){
				$currency = ($redeem_points*config('app.points.metric.conversion')*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
				$points = __($currency)." ". number_format($redeem_points,2);
			}else{
				$points = $currencies['currency_logo']. number_format($redeem_points,2);
			}
		} */
		
		$metricConversion = 1/$countryPoints;
		
		if($redeem_points*$metricConversion < 1){
			$currency = ($redeem_points*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
			$points = __($currency)." ". number_format($redeem_points*$metricConversion,2);
		}else{
			$points = $currencies['currency_logo']. number_format($redeem_points*$metricConversion,2);
		}
		
		
        return $this->to(decrypt($user->email), decrypt($user->first_name))
            ->view('inpanel.redeem.mail.rybbon_notified',
                compact('user'))
            ->subject(__('inpanel.mail.invitation.rybbon_notify_subject_1',['redeem_point'=>$points]))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
