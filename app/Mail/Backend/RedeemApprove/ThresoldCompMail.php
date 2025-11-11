<?php

namespace App\Mail\Backend\RedeemApprove;

use App\Models\Redeem\RequestRedeem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * This mail request is used to send the mail to user after Rybbon Notified.
 *
 * Class UserRedeemRibbonNotified
 * @author Vikash Yadav
 * @access public
 * @package  App\Mail\Backend\RedeemApprove\UserRedeemRibbonNotified
 */

class ThresoldCompMail extends Mailable
{
    use Queueable, SerializesModels;
    public $user,$userPointsValue,$emailAddress;

  
    public function __construct($user=null,$userPointsValue=null,$emailAddress=null)
    {
        $this->user = $user;
        $this->userPointsValue = $userPointsValue;
        $this->emailAddress = $emailAddress;
        // $this->email = $email;


       
    }
    public function build()
    {
        // $email = $this->user->email;
        $emailAddress = $this->emailAddress;
       // $email = 'anshum@samplejunction.com';
        $user = $this->user;
        $points = $this->userPointsValue;

        // $enemail = $this->user->email;
        // $emaill = $email;
        $fname = $user->first_name;
    
    
        return $this->to($emailAddress)
            ->view('backend.mail.thresoldCompMail',compact( 'user','points','fname'))
            ->subject('Redemption Threshold Reached Alert')
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));

    }
    
}
