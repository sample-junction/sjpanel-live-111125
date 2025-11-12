<?php

namespace App\Mail\Frontend;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * This mail class is used for sending the confirmation mail after successfully registration.
 *
 * Class UserConfirmation
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Frontend\UserConfirm\UserConfirmation
 */

class UserResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $confirmation_code,$user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$confirmation_code)
    {
        $this->confirmation_code = $confirmation_code;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $confirmation_code = $this->confirmation_code;
        $user = $this->user;
        $logoUrl = url('/');

        return $this->to($user->email, $user->first_name)
            ->view('frontend.mail.confirmation_mail')
            ->with('user',$user)
            ->with('confirmation_code',$confirmation_code)
            ->with('logoUrl',$logoUrl)
            //->text('frontend.mail.contact-text')
            ->subject(app_name().': '.__('exceptions.frontend.auth.confirmation.confirm'))
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
