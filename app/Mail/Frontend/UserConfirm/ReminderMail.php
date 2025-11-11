<?php

namespace App\Mail\Frontend\UserConfirm;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $userData;
    public $subject;
    public $link;
    public $token;

    public function __construct($userData, $subject, $link,  $token) 
    {
        $this->userData = $userData;
        $this->subject = $subject;
        $this->link = $link;
        $this->token = $token; 
    }

    public function build()
    {
        return $this->subject($this->subject)
            ->view('frontend.mail.bulk_invite_mail')
            ->with([
                'userData' => $this->userData,
                'link' => $this->link,
                'user' => $this->userData,
                'token' => $this->token, 
            ]);
    }
}

