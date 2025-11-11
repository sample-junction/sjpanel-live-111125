<?php

namespace App\Listeners\Inpanel\Project\Status\After;

use App\Events\Inpanel\Project\AfterStatusChanged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CancelledListener
{
    public $statusCode, $project;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->statusCode = 'CANCELLED';
    }

    /**
     * Listener for handling the Event AfterStatusChanged for changing the status of Project To Cancel.
     *
     * @param  AfterStatusChanged  $event
     * @return void
     */
    public function handle(AfterStatusChanged $event)
    {
        //
    }
}
