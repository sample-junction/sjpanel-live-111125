<?php

namespace App\Mail\Inpanel\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;

    /**
     * Create a new message instance.
     *
     * @param string|int $otp
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $logoUrl = url('/');

        try {
            return $this->view('inpanel.mail.user.otp-mail')
                ->with([
                    'otp' => $this->otp,
                    'logoUrl' => $logoUrl,
                ])
                ->subject(__('frontend.index.contact_us.OTP'))
                ->replyTo('contact@sjpanel.com', 'Contact')
                ->from(config('mail.from.address'), config('mail.from.name'));
        } catch (\Exception $e) {
            Log::error('Error sending OTP email: ' . $e->getMessage());
        }
    }
}
