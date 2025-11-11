<?php

namespace App\Listeners\Inpanel;

use App\Events\Inpanel\Auth\UserBasicDetailsFilled;
use App\Events\Inpanel\Auth\UserUpdated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class MarkUserBasicDetailsFilled
{
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
     * Handle the event.
     *
     * @param  UserUpdated  $event
     * @return void
     */
    public function handle(UserUpdated $event)
    {
        \Log::info('User MarkUserBasicDetailsFilled');
        //BasicProfileUpdate
        $user = $event->user;
        if(empty($event->user->filled_basic_details)){
            $flag = false;
            foreach($this->mandatoryAttributes as $key => $value){
                if(empty($user->$value)){
                    $flag = true;
                }
            }
            if(!$flag){
                $user->filled_basic_details = true;
                $user->save();
                event(new UserBasicDetailsFilled($user));
                if( $user->give_basic_details_filled() )
                    return;
            }
        }
    }
}
