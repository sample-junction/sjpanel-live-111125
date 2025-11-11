<?php

namespace App\Mail\Frontend\Contact;

use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class SendContact.
 */
class SendContact extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Request
     */
    public $request;

    /**
     * SendContact constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->request->email;
        $name = $this->request->name;
        
        $recipient_mail = 'amarjitm@samplejunction.com';
        // $recipient_mail = 'rohinic@samplejunction.com';
        $recipient_name = 'Amarjit';
        /* $message = $this->request->messages;*/
        return 
            // $this->to(config('mail.to.address'), config('mail.to.name'))
            $this->to($recipient_mail, $recipient_name)
            ->view('frontend.mail.contact')
            ->subject(__('strings.emails.contact.subject', ['app_name' => app_name()]))
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->replyTo($email, $name)
            ->with('user_info',$this->request);
    }
}
