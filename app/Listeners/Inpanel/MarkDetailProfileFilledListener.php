<?php

namespace App\Listeners\Inpanel;

use App\Events\Inpanel\Project\ProfileComplete;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkDetailProfileFilledListener
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
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
       $user = $event->user;
       $profile = $event->profile;

        if (!$profile) {
            $user->detailed_profile_filled = 1;
            $user->save();
            event(new ProfileComplete($user));
            return true;
        }else{
            return true;
        }
    }
}
