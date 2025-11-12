<?php

namespace App\Events\Frontend\Auth;

use App\Models\Auth\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * This class is used to update basic profile,hidden autopunch, detailed profile in user additional data and provide the User
 * achievements points and updating user Points in user additional data and also assign Match Project
 * to the newly joined user as soon as he provides his basic profile data.
 *
 * Class UserUpdated
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Events\Frontend\Auth\UserUpdated
 */

class UserUpdated
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
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
