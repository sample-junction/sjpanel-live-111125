<?php

namespace App\Mail\Backend\Campaign;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;



class CampaignTest extends Mailable
{
    use Queueable, SerializesModels;

    protected $templateContent,$approver,$rejector;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($templateContent,$approver_id,$rejecter_id)
    {
        $this->templateContent = $templateContent;
        $this->approver = $approver_id;
        $this->rejector = $rejecter_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = $this->templateContent;
        $templateContent = $template->template_content;
        $template_id = $template->id;
        $approver_id = $this->approver;
        $rejecter_id = $this->rejector;

        return $this->view('backend.auth.campaign.test_mail')
                    ->with(['templateContent' => $templateContent,'template_id' => $template_id, 'approver_id' => $approver_id,  'rejecter_id' => $rejecter_id]);
    }
}