<?php

namespace App\Events\Inpanel\Project;

use App\Models\Auth\User;
use App\Models\Project\UserProject;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * This event is fired as the project's status is changed to LIVE, than it matches the project quota with the users details
 * like basic details, detailed profile and than eligible customer will receive the project.
 *
 * Class UserAssignProject
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Events\Inpanel\Project\UserAssignProject
 */

class UserAssignProject
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $user , $placeholders;
    public function __construct(User $user,$placeholders)
    {
        $this->user = $user;
        $this->placeholders = $placeholders;
          
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
