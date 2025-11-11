<?php

namespace App\Mail\Backend\Support;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;



class PanelistSupport extends Mailable
{
    use Queueable, SerializesModels;

    protected $supportHistory,$user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$supportHistory)
    {
        $this->supportHistory = $supportHistory;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $supportHistory = $this->supportHistory;
        $user = $this->user;
        return $this->to($user->email, $user->first_name)
            ->view('backend.mail.panelistSupportMail')
            ->with('user',$user)
            //->text('frontend.mail.contact-text')
            //->subject(app_name().': '.__('exceptions.frontend.auth.confirmation.confirm'))
            ->subject('Thanks for reaching us')
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
