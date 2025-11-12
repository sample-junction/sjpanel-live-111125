<?php

namespace App\Mail\Frontend\UserConfirm;

use App\Models\Auth\User;
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
 * @package  App\Mail\Frontend\UserConfirm\resetPasswordSuccess
 */

class ResetPasswordSuccess extends Mailable
{
    use Queueable, SerializesModels;

  /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;

    public function __construct(User $user)
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
        $email = $this->user->email;
        $user = $this->user;
        $logoUrl = url('/');


        $originalLocale = app()->getLocale();
        app()->setLocale($user->locale);

        try {
        } catch (\Exception $e) {
         Log::error('Error sending email: ' . $e->getMessage());  
        }
        return $this->to($email, $user->first_name)
            ->view('frontend.mail.resetPassSuccess')
            ->with('user', $this->user)
            ->with('logoUrl',$logoUrl)
            ->subject(__('frontend.otp_mail.pass_confirm_change'))
            ->replyTo('contact@sjpanel.com', 'Contact')
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
