<?php

namespace App\Listeners\Inpanel;

use App\Events\Backend\Auth\User\BulkUserRedeemStatusChange;
use App\Listeners\Inpanel\RedeemStatusChange\ApproveRedeemRequest;
use App\Listeners\Inpanel\RedeemStatusChange\CouponRedeemRedeemRequest;
use App\Listeners\Inpanel\RedeemStatusChange\CouponLapsedRedeemRequest;
use App\Listeners\Inpanel\RedeemStatusChange\CouponSendRedeemRequest;
use App\Listeners\Inpanel\RedeemStatusChange\RibbonNotifiedRedeemRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BulkChangeRedeemRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the BulkUserRedeemStatusChange event for changing bulk status of redeem .
     *
     * @param  object  $event
     * @return void
     */
    public function handle($events)
    {
        $redeem_status = $events->redeem_status;
        if(BulkUserRedeemStatusChange::APPROVE==$redeem_status){
           $approve = new ApproveRedeemRequest;
           $approve->handle($events);
        }
        if(BulkUserRedeemStatusChange::RIBBON_NOTIFIED==$redeem_status){
            $approve = new RibbonNotifiedRedeemRequest;
            $approve->handle($events);
        }
        if(BulkUserRedeemStatusChange::COUPON_SEND==$redeem_status){
            $approve = new CouponSendRedeemRequest;
            $approve->handle($events);
        }
        if(BulkUserRedeemStatusChange::COUPON_REDEEM==$redeem_status){
           $approve = new CouponRedeemRedeemRequest;
            $approve->handle($events);
        }
        if(BulkUserRedeemStatusChange::COUPON_LAPSED==$redeem_status){
           $approve = new CouponLapsedRedeemRequest;
            $approve->handle($events);
        }
    }
}
