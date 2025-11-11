<?php

namespace App\Mail\Frontend;

use Illuminate\Mail\Mailable;

class CustomEmail extends Mailable
{
	public $data;
	public $subject;

    public function __construct($data, $subject)
    {
        $this->data = $data;
		$this->subject = $subject;
    }

    public function build()
    {
        return $this->view('frontend.mail.custom')
						->subject($this->subject);
    }
}