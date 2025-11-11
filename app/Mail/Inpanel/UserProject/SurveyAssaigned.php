<?php

namespace App\Mail\Inpanel\UserProject;

use App\Models\Project\UserProject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class surveyAssaigned extends Mailable
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

    public function build()
    {
         
        // $placeholders =  $this->user_project_placeholders;
        $user = $this->user;
        $logoUrl = url('/');
        \Log::info("message : " . $user->locale."--".$user->id);
        $locale=$user->locale;

        app()->setLocale($locale);
        return $this->to($user->email, $user->first_name)
            ->view('inpanel.mail.survey.surveyAssaignedMale',
                compact('user'))
                ->with('logoUrl',$logoUrl)
            //->text('frontend.mail.contact-text')
            ->subject(__('inpanel.SurveyMail.subject'))
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
