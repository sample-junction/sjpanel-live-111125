<?php

namespace App\Mail\Inpanel\User;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TwoFactDisable extends Mailable
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
        return $this->to( $this->user->email, $this->user)
            ->view('inpanel.mail.user.two-factor-disable')
            ->with('user','dfghj')
            //->text('frontend.mail.contact-text')
            ->subject(__('rftyui'))
            ->replyTo('contact@sjpanel.com', 'contact')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
