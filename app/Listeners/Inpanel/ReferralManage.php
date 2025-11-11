<?php

namespace App\Listeners\Inpanel;

use App\Events\Inpanel\Auth\UserConfirmed;
use App\Repositories\Inpanel\ReferralProgram\ReferralProgramRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Cookie;

class ReferralManage
{
    use InteractsWithQueue;

    protected $user, $referralRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(ReferralProgramRepository $referralRepository)
    {
        $this->referralRepository = $referralRepository;
    }

    /**
     * Handle the event.
     *
     * @param  UserConfirmed  $event
     * @return void
     */
    public function handle($event)
    {
        \Log::info('Referral Manage Executed');
        $this->user = $event->user;
        if (request()->hasCookie('code')) {
            $referralId = Cookie::get('code');
            $referral = $this->referralRepository->findByReferralId($referralId);
            if(!$referral){
                return;
            }

            $status = $this->referralRepository->createReferralRelationship($referral, $this->user);

            if ($status) {
                Cookie::queue(Cookie::forget('code'));
            }
        }
    }
}
