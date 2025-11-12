<?php

namespace App\Mail\Frontend\UserConfirm;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;
use DB;

/**
 * This mail class is used for sending the confirmation mail after successfully registration.
 *
 * Class UserConfirmation
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Frontend\UserConfirm\UserConfirmation
 */

class UserConfirmation extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $confirmation_code, $user, $get_reffer_point, $flag, $campaign, $mobileLink;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user = null, $confirmation_code = null, $get_reffer_point = null, $flag = null, $campaign = null, $mobileLink = null)
    {
        $this->confirmation_code = $confirmation_code;
        $this->mobileLink = $mobileLink;
        $this->user = $user;
        $this->get_reffer_point = $get_reffer_point;
        $this->flag = $flag;
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $userLocale = '';
        
        if ($this->user) {
            $userLocale = $this->user->locale;
            App::setLocale($userLocale);
        }

        $countryPoint = DB::table('country_points')->where('country_language', $userLocale)->first();
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

        // Initialize an empty array
        $currencies = array();
        $cntry = '';
        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

            $cntry = explode('_', $countryPoint->country_language);

            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'cntry' => $cntry['1']
            );
        }

        if (!empty($cntry)) {
            if (@$cntry['1'] != 'UK') {
                $points = $currencies['currency_logo'];
            } else {

                $points = $currencies['currency_logo'];
            }
        } else {
            $currencies = array(
                'currency_logo'  => '$',
                'currency_denom_singular' => 'inpanel.dashboard.cents',
                'currency_denom_plural' => 'inpanel.dashboard.cents',
                'cntry' => 'US'
            );
        }
        $confirmation_code = $this->confirmation_code;
        $user = $this->user;
        $mobileLink = $this->mobileLink;

        $get_reffer_point = $this->get_reffer_point;
        //$get_reffer_point=5;
        $sub1 = __('exceptions.frontend.auth.confirmation.confirm1');
        //$sub1=__('exceptions.frontend.auth.confirmation.template_1_sub_1');
        $sub2 = $get_reffer_point;
        $sub3 = __('exceptions.frontend.auth.confirmation.confirm2');
        //$sub3=__('exceptions.frontend.auth.confirmation.template_1_sub_2');
        // $subject = $sub1.' '.$sub2.' '.$sub3;
        // $subject=  $sub1.$sub2.': '.$sub3; 
        //$subject=  $sub1.$get_reffer_point.': '.$sub3;
        // $subject=  'Reminder: ' .$sub1.' '.$sub2.' '.$sub3;
        // if($user->is_social==1){
        //    $email=$user->social_email;

        // }else{
        $email = $user->email;
        // }
        // \Log::info('User Email Confirmed: '.$user->email);
        //return $this->to($user->email, $user->first_name)
        //     ->view('frontend.mail.confirmation_mail')
        // ->view('frontend.mail.doi_mail_tmplate_test')
        //->view('frontend.mail.temp_3')
        if ($this->flag == 0) {
            $subject =  $sub1 . ' ' . $sub2 . ' ' . $sub3;
            $view = 'frontend.mail.confirmation_mail';
        } else {
            // $subject=__('exceptions.frontend.auth.confirmation.confirm_doi_sub1',['points'=> $points]);
            $subject = __('exceptions.frontend.auth.confirmation.confirm_doi_sub1');
            $view = 'frontend.mail.doi_mail_tmplate_test';
        }
        if ($this->campaign) {
            $campaign_flag = 1;
        } else {
            $campaign_flag = 0;
        }
        $logoUrl = url('/');
        \Log::info('User Email Confirmed:' . $user->email);
        return $this->to($user->email, $user->first_name)
            //->view('frontend.mail.confirmation_mail')
            //->view('frontend.mail.temp_1')
            //->view('frontend.mail.doi_mail_tmplate_test)
            ->view($view)
            ->with('user', $user)
            ->with('logoUrl', $logoUrl)
            ->with('confirmation_code', $confirmation_code)
            ->with('get_reffer_point', $get_reffer_point)
            ->with('campaign', $campaign_flag)
            ->with('currencies', $currencies)
            ->with('mobileLink', $mobileLink)
            ->subject($subject)
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
