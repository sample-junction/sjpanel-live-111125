<?php

namespace App\Mail\Frontend\UserConfirm;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * This mail class is used for sending the confirmation mail after successfully registration.
 *
 * Class UserResetPassword
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Frontend\UserResetPassword
 */

class UserTestMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $confirmation_code,$user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        return $this->to($user->email, $user->first_name)
            ->view('frontend.mail.testing_mail')
            ->with('user',$user)
            //->text('frontend.mail.contact-text')
            ->subject(app_name().': Test Mail')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
