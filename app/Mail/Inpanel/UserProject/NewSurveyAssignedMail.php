<?php

namespace App\Mail\Inpanel\UserProject;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewSurveyAssignedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user_project_count, $user;
    public function __construct($user,$user_project_count)
    {
        $this->user = $user;
        $this->user_project_count = $user_project_count;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $logoUrl = url('/');
        $locale=$user->locale;

        app()->setLocale($locale);
        return $this->to($user->email, $user->first_name)
            ->view('inpanel.mail.survey.new-assign-survey-panellist',
                compact('user'))
                ->with('logoUrl',$logoUrl)
            ->subject(__('inpanel.mail.invitation.reminder_survey_subject'))
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
