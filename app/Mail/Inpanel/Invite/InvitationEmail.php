<?php

namespace App\Mail\Inpanel\Invite;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


/**
 * This mail class is used to send the Invite Email.
 *
 * Class InvitationEmail
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Inpanel\Invite\InvitationEmail
 */

class InvitationEmail extends Mailable
{
    use Queueable, SerializesModels;


    public $user, $referralLink, $referralName, $referralEmail, $get_referal_point;


    public function __construct($user, $referralLink, $referralName, $referralEmail,$get_referal_point)
    {
        $this->user = $user;
        $this->referralLink = $referralLink;
        $this->referralEmail = $referralEmail;
        $this->referralName = $referralName;
        $this->get_referal_point = $get_referal_point;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $locale=$user->locale;
        app()->setLocale($locale);
        $logoUrl = url('/');

        $referralLink = $this->referralLink;
        $referralName = $this->referralName;
        $referralEmail = $this->referralEmail;
        $get_referal_point = $this->get_referal_point;
        // return $this->to($referralEmail, $referralName)
        //     ->view('inpanel.mail.invite.invitation',
        //         compact('user', 'referralLink', 'referralEmail', 'referralName','get_referal_point'))
        //     ->with('referralEmail',$referralEmail)
        //     //->text('frontend.mail.contact-text')
        //     ->subject(__('inpanel.mail.invitation.subject'))
        //     ->from(config('mail.from.donotreply_address'), config('mail.from.name'));

        return $this->to($referralEmail, $referralName)
            ->view('inpanel.mail.invite.invitation',
                compact('user', 'referralLink', 'referralEmail', 'referralName','get_referal_point'))
            ->with('referralEmail',$referralEmail)
            ->with('logoUrl',$logoUrl)
            ->subject(__('inpanel.mail.invitation.invite_freind_subject'))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }

  
}
