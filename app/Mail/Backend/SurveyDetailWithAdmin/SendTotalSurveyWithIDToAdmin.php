<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 3/29/2019
 * Time: 7:20 PM
 */

namespace App\Mail\Backend\SurveyDetailWithAdmin;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
/**
 * This mail class is used to send the fraud user information mail to the User after marking
 * the fraud By admin.
 *
 * Class FraudInformationEmail
 * @author Vikash Kumar
 * @access public
 * @package  App\Mail\Backend\SurveyDetailWithAdmin\SendTotalSurveyWithIDToAdmin
 */

class SendTotalSurveyWithIDToAdmin extends Mailable
{
    use Queueable, SerializesModels;
    public $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }
    public function build()
    {
        $emailAddresses = [
            'rajann@samplejunction.com',
            'rameshk@samplejunction.com',
            'amarjitm@samplejunction.com',
        ];
        return $this->to($emailAddresses)
            ->view('backend.mail.sendTotalSurveyWithIDToAdmin',
                compact('data'))
            ->subject(' Survey Assignment report '.Carbon::now()->format('m-d-Y'))
            ->from(config('mail.from.donotreply_address'), config('mail.from.name'))
            ->attach($this->filename);
    }
}
