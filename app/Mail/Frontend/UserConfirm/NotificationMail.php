<?php

namespace App\Mail\Frontend\UserConfirm;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user,$subject,$data,$totalEarnedAmount,$redeem_points,$user_state;
    public function __construct($user,$subject,$data,$totalEarnedAmount, $redeem_points,$user_state =null)
    {
        $this->user = $user;
        $this->subject = $subject;
        $this->data = $data;
        $this->totalEarnedAmount = $totalEarnedAmount;
        $this->redeem_points = $redeem_points;
        $this->user_state = $user_state;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $data = $this->data;
        $totalEarnedAmount = $this->totalEarnedAmount;
        $redeem_points = $this->redeem_points;
        $user_state = $this->user_state;
        return $this->view('frontend.mail.notification')
            ->with('user',$user)
            ->with('data',$data)
            ->with('totalEarnedAmount',$totalEarnedAmount)
            ->with('redeem_points',$redeem_points)
            ->with('user_state',$user_state)
            //->text('frontend.mail.contact-text')
            //->subject(app_name().': '.__('Welcome!'))
            // ->subject('New registration alert')
            ->subject($this->subject)
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
