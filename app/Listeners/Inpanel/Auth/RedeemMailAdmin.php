<?php

namespace App\Listeners\Inpanel\Auth;

use App\Mail\Inpanel\RedeemPoints\AdminRedeemRequestEmail;
use App\Models\Auth\User;
use App\Notifications\Frontend\Auth\AdminRedeemRequest;
use App\Notifications\Frontend\Auth\UserRedeemRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class RedeemMailAdmin
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
     * Listener for handling the Event UserRedeemRequest for sending the mail of Redeem Request To the Admin and Super Admin.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $users = User::permission('access user management')->get();
        $request_redeem = $event->create_redeem_request;
        foreach($users as $user_data){
            $user['email'] = $user_data->email;
            $user['first_name'] = $user_data->first_name;
            $admin_details = collect($user);
            $email = new AdminRedeemRequestEmail($admin_details,$request_redeem);
            Mail::send($email);
        }
    }
}
