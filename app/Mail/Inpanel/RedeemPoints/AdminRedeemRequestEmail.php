<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:40 PM
 */

namespace App\Mail\Inpanel\RedeemPoints;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


/**
 * This mail class is used for sending the redeem request mail to the admin and super admin.
 *
 * Class AdminRedeemRequestEmail
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Mail\Inpanel\RedeemPoints\AdminRedeemRequestEmail
 */

class AdminRedeemRequestEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $user, $request_redeem;
    public function __construct($user, $request_redeem)
    {
        $this->user = $user;
        $this->request_redeem = $request_redeem;
    }
    public function build()
    {
      $user = $this->user;
        $request_redeem = $this->request_redeem;
        return $this->to($user['email'], $user['first_name'])
            ->view('inpanel.redeem.mail.admin_mail')
            ->with('user',$user)
            ->with('request_redeem',$request_redeem)
            //->text('frontend.mail.contact-text')
            ->subject('Your Redeem Request Has been Granted')
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
