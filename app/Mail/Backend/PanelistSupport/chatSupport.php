<?php

namespace App\Mail\Backend\PanelistSupport;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;



class chatSupport extends Mailable
{
    use Queueable, SerializesModels;

    public $user_tkt,$ticket_id;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_tkt,$ticket_id)
    {
        $this->user_tkt = $user_tkt;
        $this->ticket_id = $ticket_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user_tkt = $this->user_tkt;
        $ticket_id = $this->ticket_id;
        $enemail = $this->user_tkt->email;

        $email = decrypt($enemail);
        $fname = decrypt($user_tkt->first_name);

        $originalLocale = app()->getLocale();
        app()->setLocale($user_tkt->locale);

        // echo'<pre>';
        // print_r($decryptedEmail); die();
        try {
        } catch (\Exception $e) {
         Log::error('Error sending email: ' . $e->getMessage());  
        }
        /* Anil Sharma Added the subject for  the hindi language*/ 
        if($user_tkt->locale=="hi_IN"){
            $subject = __('frontend.otp_mail.panelist_support_sub').' '.$ticket_id.' '.__('frontend.otp_mail.panelist_support_sub2');
        }else{
            $subject = __('frontend.otp_mail.panelist_support_sub').' '.$ticket_id;
        }
        return $this->to($email, $fname)
            ->view('backend.mail.chatSupportMail')
            ->with('ticket_id', $ticket_id)
            ->with('fname', $fname)
            ->with('email', $email)
            ->with('user', $user_tkt)
            ->subject($subject)
            ->replyTo('contact@sjpanel.com', 'Contact')
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
