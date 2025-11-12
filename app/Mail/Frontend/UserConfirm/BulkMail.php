<?php

namespace App\Mail\Frontend\UserConfirm;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BulkMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user,$subject;
    public function __construct($user,$subject,$code)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $code = $this->code;
        return $this->view('frontend.mail.bulk_invite_mail')
            ->with('user',$user)
            ->with('code',$code)
            ->subject($this->subject)
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
