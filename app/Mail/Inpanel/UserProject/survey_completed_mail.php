<?php

namespace App\Mail\Inpanel\UserProject;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class survey_completed_mail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user,$survey_code,$points,$RespId;
    public function __construct($user=null,$survey_code=null,$points=null,$respId=null)
    {
        $this->user = $user;
        $this->survey_code =$survey_code;
        $this->points = $points;
        $this->RespId = $respId;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user =$this->user;
        $survey_code = $this->survey_code;
        $points = $this->points;
        $respondentId = $this->RespId;
        $panelist_id = $user->panellist_id;

        //$respondentId = $user->uuid;

        $user_name = $user->first_name;
        $subject = "New Survey Completion Alert";

        //Testing To recipient and cc Recipients
        //$email = 'rohinic@samplejunction.com';
        //$ccRecipients = [
         //   'amarjitm@samplejunction.com'
        //];

        
        //Actual To recipient and CC recipients
         $email = 'amarjitm@samplejunction.com';
         $ccRecipients = [
             'rameshk@samplejunction.com',
             'nimeshs@samplejunction.com',
             'rajann@samplejunction.com',
         ];

        return $this->to($email)->cc($ccRecipients)
            ->view('inpanel.mail.survey.survey_completed_mail',
                compact('user_name','points','panelist_id','survey_code','respondentId'))
            ->subject($subject)
            ->from('donotreply@sjpanel.com', "donotreply@sjpanel.com");
    }
}
