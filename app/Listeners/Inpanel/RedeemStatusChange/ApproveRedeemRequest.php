<?php

namespace App\Listeners\Inpanel\RedeemStatusChange;

use App\Models\Auth\User;
use App\Models\Redeem\RequestRedeem;
use App\Repositories\Inpanel\Redeem\RedeemRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApproveRedeemRequest
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Listener to handle the BulkUserRedeemStatusChange Event for Approving the Redeem Requests in bulk.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $redeem_status = $event->redeem_status;
        $redeem_id = $event->redeem;
        $redeemRepo = new RedeemRepository;
        $get_redeem_request = RequestRedeem::where('id','=',$redeem_id)->first();
        $user = User::where('uuid','=',$get_redeem_request->user_uuid)->first();
        $redeemRepo->approveRedeemPoints($user,$redeem_id);
    }
}
