<?php

namespace App\Events\Frontend\Auth;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;


/**
 * This event is used, as the User from Promo Link register to our end is redirected to clients link.
 *
 * Class AffiliateConversion
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Events\Frontend\Auth\AffiliateConversion
 */
class AffiliateConversion
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $affiliateCampData;
    public function __construct($affiliateCampData)
    {
        $this->affiliateCampData = $affiliateCampData;
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
