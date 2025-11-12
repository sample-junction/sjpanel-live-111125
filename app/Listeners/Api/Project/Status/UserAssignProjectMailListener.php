<?php

namespace App\Listeners\Api\Project\Status;

use App\Mail\Inpanel\UserProject\UserProjectCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class UserAssignProjectMailListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Listener for handling the Event UserAssignProject for sending the mail to the user after assigning the Project.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $placeholders = $event->placeholders;
        $user = $event->user;
        $email = new UserProjectCreated($user,$placeholders);
       
        Mail::send($email);
    }
}
