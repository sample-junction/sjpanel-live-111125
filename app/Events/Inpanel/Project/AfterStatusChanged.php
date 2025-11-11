<?php

namespace App\Events\Inpanel\Project;

use App\Models\Project\Project;
use App\Models\Project\ProjectStatus;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

/**
 * This event is used for changing the status of the Project.
 *
 * Class AfterStatusChanged
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Events\Inpanel\Project\AfterStatusChanged
 */
class AfterStatusChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $project, $previousStatusObject, $currentStatusObject ;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Project $project, ProjectStatus $previousStatusObject, ProjectStatus $currentStatusObject, $payload=null ) // added $payload by Himanshu 27-10-2025
    {
        $this->project = $project;
        $this->previousStatusObject = $previousStatusObject;
        $this->currentStatusObject = $currentStatusObject;
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
