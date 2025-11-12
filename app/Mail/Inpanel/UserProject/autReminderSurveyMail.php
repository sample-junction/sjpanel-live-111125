<?php

namespace App\Mail\Inpanel\UserProject;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class autReminderSurveyMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public $email_data, $user,$device, $user_project_placeholders;

    public function __construct($email_data,$user,$device,$user_project_placeholders)
    {
        $this->email_data = $email_data;
        $this->user = $user;
        $this->device =$device;
         $this->user_project_placeholders = $user_project_placeholders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $pointsConversionMetric = config('app.points.metric.conversion');
        $user =  $this->user;
        $email_data =  $this->email_data;
        $referralName = decrypt($user->first_name);
        $topic = $user->project_topic_name;
        $loi = $user->loi;
        $value = $user->cpi;
        $points = round($user->cpi/$pointsConversionMetric);
        $s_link = str_replace('[%sjpid%]',$user->uuid.'_sjpid&ch=2',$user->user_live_link);
        $device = $this->device;
		$placeholders =  $this->user_project_placeholders;
		//$conversion = $placeholders['conversion'];
		$conversion = number_format(($points/$placeholders['countryPoints']),2);
		$currencySymbol = $placeholders['COUNTRYSYMBOL'];
		
		
        /* Parshant Sharma [03-09-2024] Starts */
        
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
				
        /* Parshant Sharma [03-09-2024] Ends */		
		
        
        //  \Log::info('ADAADDADAD' . $email_data);
        $toEmail = $email_data['email'];
        $fromName = ($email_data['from_name'])?$email_data['from_name']:config('mail.from.name');
        $fromAddress = ($email_data['from_address'])?$email_data['from_address']:config('mail.from.address');
        $subject = ($email_data['subject'])?$email_data['subject']:'Test Survey Invite';
        $logoUrl = url('/');

        return $this->to($toEmail)
            ->view('inpanel.mail.survey.auto_survey_reminder_mail',
                compact('user', 'referralName','topic','loi','value','points','s_link','device','conversion','currencySymbol'))
            ->subject($subject)
            ->from($fromAddress, $fromName);
    }
}
