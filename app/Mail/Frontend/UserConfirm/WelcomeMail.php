<?php

namespace App\Mail\Frontend\UserConfirm;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;


class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $get_reffer_point, $ref_points;

    public function __construct($user, $get_reffer_point, $ref_points)
    {
        $this->user = $user;
        $this->get_reffer_point = $get_reffer_point;
        $this->ref_points = $ref_points;
    }

    public function build()
    {
        $userLocale = $this->user->locale;
        App::setLocale($userLocale);
        $user = $this->user;
        $ref_points = $this->ref_points;
        $get_reffer_point = $this->get_reffer_point;
        $logoUrl = url('/');


        return $this->to($user->email, $user->first_name)
            ->view('frontend.mail.welcome')
            ->with('user', $user)
            ->with('logoUrl',$logoUrl)
            ->with('get_reffer_point', $get_reffer_point)
            ->with('ref_points', $ref_points)
            ->with('userLocale', $userLocale)
            ->subject(__('strings.emails.fraud_mail.subject_welcome'))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}

