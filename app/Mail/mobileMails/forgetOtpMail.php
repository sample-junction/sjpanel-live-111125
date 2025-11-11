<?php

namespace App\Mail\mobileMails;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class forgetOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user,$six_digit_random_number;
    public function __construct(User $user, $six_digit_random_number)
    {
        $this->user = $user;
        $this->six_digit_random_number = $six_digit_random_number;
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
        $otp = $this->six_digit_random_number;
        $logoUrl = url('/');

        return $this->to($email, $user->first_name)
            ->view('frontend.mail.otp')
            ->with('user',$user)
            ->with('otp',$otp)
            ->with('logoUrl',$logoUrl)

            //->text('frontend.mail.contact-text')
            ->subject(__('frontend.index.contact_us.OTP'))
            ->replyTo('contact@sjpanel.com', 'contact')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
