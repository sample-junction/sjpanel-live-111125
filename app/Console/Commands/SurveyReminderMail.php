<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurveyReminder;
use App\Helpers\MailHelper;
use App\Mail\Inpanel\Support\PanelistBirthdayMail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SurveyReminderMail extends Command
{
    protected $signature = 'email:survey-reminder';
    protected $description = 'Send reminder emails to users who have not clicked on the survey link within 24 hours';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = DB::table('campaign_histories')
         ->select('campaign_histories.*', 'users.*','user_projects.*', 'projects.*')
        ->where('campaign_histories.c_type', '=', 'Survey')  
        ->where('campaign_histories.created_at', '<', Carbon::now()->subHours(24)) 
        ->join('users', 'users.panellist_id', '=', 'campaign_histories.panelist_id')
        ->join('user_projects', 'user_projects.id', '=', 'campaign_histories.user_pro_id')
        ->join('projects', 'campaign_histories.project_id', '=', 'projects.id')
        ->whereNull('user_projects.status')
        ->where('projects.survey_status_code', '=', 'LIVE')
        ->get();
    
        
            // echo '<pre>';
            // print_r($users->count());die;


        

        // Send reminder emails to users
        foreach ($users as $user) {      
            $email=decrypt( $user->email);
            $points = ($user->campaign_amount) * 1000; 
            $logo_url = url('/');
            $reminder_count = $user->survey_email_reminder + 1;

            $subjectLine = 'Reminder: ' . $user->campaign_subject;          
            $Content = str_replace(
                [':link', ':userFristName', ':logo_url', ':Survey_code', ':survey_link', ':points', ':dollor', ':topic', ':min'],
                [$user->status_link, $user->first_name, $logo_url, $user->survey_code, $user->status_link, $points, $user->campaign_amount, $user->survey_topic, $user->survey_loi],
                $user->campaign_content
            );

            $subject =str_replace(':dollor','$'.$user->campaign_amount,$subjectLine);

            // echo '<pre>';
            // print_r($Content);die;

        

            MailHelper::sendBirthdayMail($user,$email, $subject, $Content); 
            
                DB::table('campaign_histories')
                ->where('panelist_id', $user->panelist_id)
                ->update([
                    'survey_email_reminder' => $reminder_count,
                    'email_reminder_date' => Carbon::now()              
                ]);
            //    die;
        }

        $this->info('Reminder emails sent successfully.');
    }
}
