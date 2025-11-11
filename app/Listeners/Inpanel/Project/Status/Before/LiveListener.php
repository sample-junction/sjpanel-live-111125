<?php

namespace App\Listeners\Internal\Project\Status\Before;

use App\Events\Inpanel\Project\BeforeStatusChange;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LiveListener
{
    public $statusCode;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->statusCode = 'LIVE';
    }

    /**
     * Handle the event.
     *
     * @param  BeforeStatusChange  $event
     * @return void
     */
    public function handle(BeforeStatusChange $event)
    {
        $currentStatusObject = $event->currentStatus;
        if( empty($currentStatusObject) || $currentStatusObject->code !== $this->statusCode){
            return;
        }
        /*$project = $event->project;
        $nextStatusObject = $event->nextStatus;*/

        //Everything done;
        return;
    }
}
