<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:20 PM
 */

namespace App\Mail\Backend\RedeemApprove;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * This mail class is used to send the redeem approval mail to the User after changing
 * the status of Redeem Request from pending to approve By admin.
 *
 * Class RedeemApprovedEmail
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Backend\RedeemApprove\RedeemApprovedEmail
 */

class RedeemApprovedEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user;


    public function __construct($user,$request_redeem)
    {
        $this->user = $user;
        $this->request_redeem = $request_redeem;
    }
    public function build()
    {
        $user = $this->user;
        $locale=$user->locale;
        app()->setLocale($locale);
        $request_redeem = $this->request_redeem;
        return $this->to($user->email, $user->first_name)
            ->view('inpanel.redeem.mail.user_mail_granted',
                compact('user','request_redeem'))
            //->text('frontend.mail.contact-text')
            ->subject('Your Redeem Request Has been Granted')
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
