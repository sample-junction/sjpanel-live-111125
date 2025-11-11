<?php

namespace App\Listeners\Frontend;

use App\Events\Frontend\Auth\UserUpdated;
use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Events\Inpanel\Auth\UserBasicDetailsFilled;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkUserBasicDetailsFilled
{
    /**
     * @var array
     * @param $mandatoryAttributes;
     */
    protected $mandatoryAttributes = ['first_name', 'last_name', 'gender', 'dob', 'zipcode', 'confirmed'];
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
     * Listener handle the Event User Update for giving the user Basic Details Filling Points.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        \Log::info('User MarkUserBasicDetailsFilled');
        $user = $event->user;
        if($user->filled_basic_details){
            $flag = true;
            foreach ($this->mandatoryAttributes as $key => $value) {
                if (empty($user->$value)) {
                    $flag = false;
                }
            }
            if($flag){
                $user->give_basic_details_filled();
                event(new UserAchievementUpdate($user));
                    return;
            }
        }
    }
}
