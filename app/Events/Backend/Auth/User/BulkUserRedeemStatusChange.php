<?php

namespace App\Events\Backend\Auth\User;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


/**
 * This event class is used for handling the functionlaity of bulk change status of Redeem Requests.
 *
 * Class BulkUserRedeemStatusChange
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Events\Backend\Auth\User\BulkUserRedeemStatusChange
 */
    class BulkUserRedeemStatusChange
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    const APPROVE = 'approve';
    const RIBBON_NOTIFIED = 'ribbon_notified';
    const COUPON_SEND = 'coupon_send';
    const COUPON_REDEEM = 'coupon_redeem';
    const COUPON_LAPSED = 'coupon_lapsed';

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $user,$redeem,$redeem_status;
    public function __construct($redeem_id,$redeem_status)
    {
        $this->redeem = $redeem_id;
        $this->redeem_status = $redeem_status;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
