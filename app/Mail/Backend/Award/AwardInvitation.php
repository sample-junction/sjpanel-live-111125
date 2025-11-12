<?php

namespace App\Mail\Backend\Award;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AwardInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function build()
    {
        /*
        $data = $this->details;
        return $this->subject('SJ Panel: '.$data['awardMonth'].' Award Announcement')
            ->view('backend.mail.awardInvitationMail')
            ->with('data',$data); 
            */
        return $this->subject($this->details['mail_subject'])
            ->html($this->details['mail_content']);
    }
}
