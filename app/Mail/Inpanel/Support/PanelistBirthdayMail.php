<?php

namespace App\Mail\Inpanel\Support;

use App\Models\Auth\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PanelistBirthdayMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user,  $subjectLine, $emailContent,$status_link_new,$button;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $subjectLine, $emailContent,$status_link_new = null,$button= null)
    {
        $this->user = $user;
        $this->subjectLine = $subjectLine;
        $this->emailContent = $emailContent;
        $this->status_link_new = $status_link_new;
        $this->button = $button;
    }
    
    public function build()
    {

        
        $user = $this->user;
        $subjectLine = $this->subjectLine;
        $emailContent = $this->emailContent;
        $status_link_new = $this->status_link_new;
        $button = $this->button;
    
        // return $this->view('inpanel.mail.panelistSupport.panelistBdayMail')
        return $this->view('inpanel.mail.panelistSupport.campaign')
            ->with('user', $user)
            ->with('subjectLine', $subjectLine)
            ->with('emailContent', $emailContent)
            ->with('status_link_new',$status_link_new)
            ->with('button', $button)
            ->subject($subjectLine);

        
    }
    
    }

