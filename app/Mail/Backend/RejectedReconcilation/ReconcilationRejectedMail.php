<?php

namespace App\Mail\Backend\RejectedReconcilation;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReconcilationRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user,$subject,$project,$topic_name,$loi;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$project=null,$topic_name =null,$loi =null)
    {
       $this->user = $user;
       $this->project = $project;
       $this->loi = $loi;
       $this->topic_name = $topic_name;
       
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $locale=$user->locale;
        app()->setLocale($locale);
        $logoUrl = url('/');
         $toEmail = $user->email;
        //$toEmail = "obhimainom@samplejunction.com";
        // $toEmail = " ";
        $user_first_name = $user->first_name;
        $project =$this->project;
        $topic_name = $this->topic_name;
        $loi = $this->loi;
        $subject =__('inpanel.activity_log.rejection_mail_subject');

        return $this->to($toEmail)
            ->view('inpanel.mail.survey.reconcilation_reject_mail',compact('user', 'user_first_name','project','logoUrl','loi','topic_name'))
            ->subject($subject)
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'));
    }
}
