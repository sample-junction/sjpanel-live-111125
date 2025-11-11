<?php

namespace App\Jobs\Inpanel\Invite;

use App\Mail\Inpanel\Invite\InvitationEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
  

class SendInvitationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user, $referralLink, $referralName, $referralEmail,$get_referal_point;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $referralLink, $referralName, $referralEmail,$get_referal_point)
    {
        $this->user = $user;
        $this->referralLink = $referralLink;
        $this->referralEmail = $referralEmail;
        $this->referralName = $referralName;
        $this->get_referal_point = $get_referal_point;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new InvitationEmail($this->user, $this->referralLink, $this->referralName, $this->referralEmail, $this->get_referal_point);
        Mail::send($email);
    }
}
