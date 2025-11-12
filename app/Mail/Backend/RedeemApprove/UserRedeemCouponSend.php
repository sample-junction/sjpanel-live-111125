<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:39 PM
 */

namespace App\Mail\Backend\RedeemApprove;

use App\Models\Redeem\RequestRedeem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * This mail request is used to send the mail to user after Coupon Send.
 *
 * Class UserRedeemCouponSend
 * @author Vikash Yadav
 * @access public
 * @package  App\Mail\Backend\RedeemApprove\UserRedeemCouponSend
 */

class UserRedeemCouponSend extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }
    public function build()
    {
       $user = $this->user;
       $locale=$user->locale;
        app()->setLocale($locale);
        return $this->to($user->email, $user->first_name)
            ->view('inpanel.redeem.mail.coupon_send',
                compact('user'))
            ->subject(__('inpanel.redeem.index.mail.couponsend_subject'))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
