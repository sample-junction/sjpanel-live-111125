<?php

namespace App\Mail\Inpanel\UserProject;

use App\Models\Project\UserProject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserProjectCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user_project_placeholders, $user;
    public function __construct($user,$user_project_placeholders)
    {
        $this->user = $user;
        $this->user_project_placeholders = $user_project_placeholders;
    }

    public function build()
    {
         
        $placeholders =  $this->user_project_placeholders;
        $user = $this->user;
        return $this->to($user->email, $user->first_name)
            ->view('inpanel.mail.survey.survey_assign_mail',
                compact('user','placeholders'))
            //->text('frontend.mail.contact-text')
            ->subject(__('inpanel.mail.survey.invite.subject'))
            ->from(config('mail.from.address'), config('mail.from.name'));
    }
}
