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
use App\Models\Setting\Setting as settings;

/**
 * This mail class is used to send the Blacklist user information mail to the User after marking
 * the fraud By admin.
 *
 * Class BlacklistInformationEmail
 * @author Vikash Kumar
 * @access public
 * @package  App\Mail\Backend\FraudInformation\BlacklistInformationEmail
 */

class BlacklistInformationEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $froud_surveys;
    


    public function __construct($user,$froud_surveys)
    {
        $this->user = $user;
        $this->froud_surveys = $froud_surveys;
    }
    public function build()
    {
        $user = $this->user;
        $locale=$user->locale;
        $fraud_survey_data=[];
        $froud_surveys = $this->froud_surveys;
        foreach($froud_surveys as $fraud){
            array_push($fraud_survey_data,$fraud->project_id);
        }
       
        app()->setLocale($locale);
        $getFraudLimit = settings::where('key','=','PANEL_FRAUD_LIMIT')->first();
        $fraudulent_count = $getFraudLimit->value;
        //$fraudDate = date('l,F d Y H:i:s');

        return $this->to($user->email, $user->first_name)
            ->view('backend.mail.blacklist_mail',
                compact('user','fraudulent_count','fraud_survey_data'))
            ->subject(__('inpanel.mail.invitation.blacklist_mail_subject'))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
