<?php

namespace App\Events\Inpanel\Auth;

use App\Models\Auth\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


/**
 * This class is used for updating the user points in User Additional data after every user achievements user receive.
 *
 * Class UserReferralAchievementUpdate
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Events\Inpanel\Auth\UserReferralAchievementUpdate
 */

class UserReferralAchievementUpdate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $referral_user_id,$refered_user_id;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($referral_user_id,$refered_user_id)
    {
        $this->referral_user_id = $referral_user_id;
        $this->refered_user_id = $refered_user_id;
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
