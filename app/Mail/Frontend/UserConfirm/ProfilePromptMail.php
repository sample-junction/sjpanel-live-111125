<?php

namespace App\Mail\Frontend\UserConfirm;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Setting\Setting;

class ProfilePromptMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        // return $this->view('frontend.mail.profilePrompt')
        //     ->with('user',$user)
        //     ->subject(__('frontend.welcome_mail.sub_header_2'))
        //     ->from(config('mail.from.donotreply_address'), config('mail.from.name'));

        $profile_point = setting::where('key','=','PANEL_BASIC_PROFILE_POINTS')->first();
        return $this->view('frontend.mail.profilePrompt')
        ->with(['user'=>$user,'profile_point'=>$profile_point])
        ->subject(__('inpanel.mail.invitation.profileprompt_subject_1',['profile_point'=>$profile_point->value]))
        ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}