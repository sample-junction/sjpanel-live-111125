<?php

namespace App\Mail\Inpanel\UserProject;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SurveyCustomInvite extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email_data, $user_project_placeholders;
    public function __construct($email_data, $user_project_placeholders)
    {
        $this->email_data = $email_data;
        $this->user_project_placeholders = $user_project_placeholders;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        
        
        $placeholders =  $this->user_project_placeholders;
        $email_data =  $this->email_data;

        $toEmail = $email_data['email'];
        $fromName = ($email_data['from_name'])?$email_data['from_name']:config('mail.from.name');
        $fromAddress = ($email_data['from_address'])?$email_data['from_address']:config('mail.from.address');
        $subject = ($email_data['subject'])?$email_data['subject']:'Test Survey Invite';

        return $this->to($toEmail)
            ->view('inpanel.mail.survey.test_custom_invite',
                compact('placeholders'))
            //->text('frontend.mail.contact-text')
            ->subject($subject)
            ->from($fromAddress, $fromName);
    }
}
