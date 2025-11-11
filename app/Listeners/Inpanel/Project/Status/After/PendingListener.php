<?php

namespace App\Listeners\Inpanel\Project\Status\After;

use App\Events\Inpanel\Project\AfterStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class PendingListener
{
    public $statusCode, $project, $sourceAPIService;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->statusCode = 'PENDING';
    }

    /**
     * Listener for handling the Event AfterStatusChanged for changing the status of Project To Pending
     *
     * @param  AfterStatusChanged  $event
     * @return void
     */
    public function handle(AfterStatusChanged $event)
    {
        $currentStatusObject = $event->currentStatusObject;
        if( empty($currentStatusObject) || $currentStatusObject->code !== $this->statusCode){
            return;
        }

        return;
    }
}
