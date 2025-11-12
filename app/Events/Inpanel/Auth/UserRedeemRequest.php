<?php

namespace App\Events\Inpanel\Auth;

use App\Models\Redeem\RequestRedeem;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Auth\User;

/**
 * This event is called as the User request for redemption of points.
 *
 * Class UserRedeemRequest
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Events\Inpanel\Auth\UserRedeemRequest
 */

class UserRedeemRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user, $create_redeem_request;
    public function __construct(User $user, RequestRedeem $redeemRequest)
    {
        $this->user = $user;
        $this->create_redeem_request = $redeemRequest;
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
