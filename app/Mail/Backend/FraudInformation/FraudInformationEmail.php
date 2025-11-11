<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:20 PM
 */

namespace App\Mail\Backend\FraudInformation;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * This mail class is used to send the fraud user information mail to the User after marking
 * the fraud By admin.
 *
 * Class FraudInformationEmail
 * @author Vikash Kumar
 * @access public
 * @package  App\Mail\Backend\FraudInformation\FraudInformationEmail
 */

class FraudInformationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $survey_id;


    public function __construct($user,$survey_id)
    {
        $this->user = $user;
        $this->survey_id = $survey_id;
    }
    public function build()
    {
        $user = $this->user;
        $locale=$user->locale;
        app()->setLocale($locale);
        $survey_id = $this->survey_id;
        $fraudDate = date('l,F d Y H:i:s');

      
        return $this->to($user->email, $user->first_name)
            ->view('backend.mail.fraud_information_mail',
                compact('user','fraudDate','survey_id'))
            ->subject(__('inpanel.mail.invitation.fraud_info_mail_subject',['survey_no'=>$survey_id]))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
