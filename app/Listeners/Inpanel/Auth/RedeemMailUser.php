<?php

namespace App\Listeners\Inpanel\Auth;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\Inpanel\RedeemPoints\UserRedeemRequest;

class RedeemMailUser
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
     *  Listener for handling the Event UserRedeemRequest for sending the mail of Redeem Request To the User.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $request_redeem = $event->create_redeem_request;
            $email = new UserRedeemRequest($user, $request_redeem);
            Mail::send($email);
    }
}
