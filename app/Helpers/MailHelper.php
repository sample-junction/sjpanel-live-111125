<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use App\Mail\Frontend\UserConfirm\NotificationMail;
use App\Mail\Frontend\UserConfirm\BulkMail;
use App\Mail\Inpanel\Support\PanelistBirthdayMail;


class MailHelper
{
    public static function sendCustomMail($user,$to,$subject,$data,$totalEarnedAmount=null,$redeem_points=null,$user_state =null){
        Mail::to($to)->send(new NotificationMail($user,$subject,$data,$totalEarnedAmount,$redeem_points,$user_state));
    }
    public static function sendBulkMail($user,$to,$subject,$code=null){
        Mail::to($to)->send(new BulkMail($user,$subject,$code));
    }
  public static function sendBirthdayMail($user, $to, $subjectLine, $emailContent,$url=null,$button=null)
    {
        Mail::to($to)->send(new PanelistBirthdayMail($user, $subjectLine, $emailContent,$url,$button));
    }
    
}