<?php

namespace App\Mail\Inpanel\Invite;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;

class ReferPointsConfirm extends Mailable
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
        // app()->setLocale($locale);
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
		
		$metricConversion = 1/$countryPoints;

        $referralName = $user->first_name;
        $referredName = $this->referredName;
        $referralEmail = $user->email;
        $referred_first_name = $this->referred_first_name;
        $get_referal_point = $this->get_referal_point;
        /* if($cntry[1]!='UK'){
              if($get_referal_point*config('app.points.metric.conversion') < 1){
                $ref_points = $get_referal_point*config('app.points.metric.conversion')*100 ."__('inpanel.dashboard.cents')" ;
            }else{
                $ref_points = '$' . $get_referal_point*config('app.points.metric.conversion') ;
            }  
        }else{
			$get_referal_points=number_format($get_referal_point/$currencies['countryPoint'],2);
			if($get_referal_points < 1){
				$currency = ($get_referal_point*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
				$ref_points = $get_referal_point*$metricConversion*100 .' '. __($currency); 
			}else{
				$ref_points = $currencies['currency_logo']. number_format($get_referal_point,2);
			}
        } */
        
		if($get_referal_point*$metricConversion < 1){
			$currency = ($get_referal_point*$metricConversion*100 > 1) ? $currencies['currency_denom_plural'] : $currencies['currency_denom_singular'];
			$ref_points = number_format(($get_referal_point*$metricConversion*100),2) .' '. __($currency); 
		}else{
			$ref_points = $currencies['currency_logo']. number_format($get_referal_point*$metricConversion,2);
		}
                        
        // return $this->to($referralEmail, $referralName)
        //     ->view('inpanel.mail.invite.refer_points',
        //         compact('user', 'referralName','referredName','get_referal_point'))
        //     ->subject(__('inpanel.mail.refer_points.subject'))
        //     ->from(config('mail.from.donotreply_address'), config('mail.from.name'));

        return $this->to($referralEmail, $referralName)
        ->view('inpanel.mail.invite.refer_points',
            compact('user', 'referralName','referredName','get_referal_point','referred_first_name','currencies'))
        ->subject(__('inpanel.mail.invitation.refer_point_subject_1',['referral_point' => $ref_points]))
        ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
