<?php

namespace App\Mail\Inpanel\User;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TwoDisableMail extends Mailable
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

        try {
        } catch (\Exception $e) {
         Log::error('Error sending email: ' . $e->getMessage());  
        }

        return $this->to($email, $user->first_name)
            ->view('inpanel.mail.user.two-fa-disable')
            ->with('user', $this->user)
            ->with('otp',$otp)
            ->with('logoUrl',$logoUrl)
            ->subject(__('frontend.index.contact_us.OTP'))
            ->replyTo('contact@sjpanel.com', 'Contact')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
  