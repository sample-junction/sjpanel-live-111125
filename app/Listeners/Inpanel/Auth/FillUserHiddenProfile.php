<?php

namespace App\Listeners\Inpanel\Auth;

use App\Events\Inpanel\Auth\UserBasicDetailsFilled;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FillUserHiddenProfile //implements ShouldQueue
{
    //use InteractsWithQueue;

    public $userRepo;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Handle the event.
     *
     * @param  UserBasicDetailsFilled  $event
     * @return void
     */
    public function handle(UserBasicDetailsFilled $event)
    {
        //dd('tada');

        $users = $this->userRepo->find_users_with_pending_additional_data();
        if (!empty($users)) {
            foreach ($users as $user) {
                if (empty($user->country)) {
                    continue;
                }
                $this->userRepo->fillUserAdditionalData($user);
            }
        }
    }
}
