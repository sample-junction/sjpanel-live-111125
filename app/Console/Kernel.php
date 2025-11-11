<?php

namespace App\Console;

use App\Console\Commands\ProjectCCR;
use App\Console\Commands\TestCronMail;
use App\Console\Commands\CreateSurveyStartCount;
use App\Console\Commands\CreateSurveyReport;
use App\Console\Commands\UpdateResponseRate;
use App\Console\Commands\SendScheduledMail;
use Illuminate\Console\Scheduling\Schedule;
// use Illuminate\Console\Scheduling\Event;
use App\Console\Commands\SurveyAssaignedMail;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\surveyReminderAfter24Hours;
use App\Console\Commands\SurveyReminderMail;
use App\Console\Commands\SendPanlistIDWithCountSurveyWithSurveyID;
use App\Console\Commands\ActiveUserList;
use App\Console\Commands\NewSurveyAssignedMail;
use App\Console\Commands\AwardInvitationScheduledMail;  // added by Himanshu 03-10-2025
/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ProjectCCR::class,
        TestCronMail::class,
        CreateSurveyStartCount::class,
        CreateSurveyReport::class,
        UpdateResponseRate::class,
        SendScheduledMail::class,
        SurveyAssaignedMail::class,
        surveyReminderAfter24Hours::class,
        SurveyReminderMail::class,
        SendPanlistIDWithCountSurveyWithSurveyID::class,
        ActiveUserList::class,
        NewSurveyAssignedMail::class,
        AwardInvitationScheduledMail::class, // added by Himanshu 03-10-2025
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

       // $schedule->command('email:sendSurveyCountWithSurveyID')->dailyAt("19:30")->timezone('Asia/Kolkata');


        //die();
       // $schedule->command('hourly:project_ccr')->hourly();
        //$schedule->command('hourly:project_ccr')
           // ->cron('0 */2 * * *')
           // ->runInBackground()
            //->withoutOverlapping();
        //Test mail send from cron automatic
        //$schedule->command('everyminute:email_send')->dailyAt("23:59")->timezone('Asia/Kolkata');
        //$schedule->command('profileMail:send')->everyMinute()->timezone('Asia/Kolkata');
        // $schedule->command('profileMail:send')->dailyAt("05:12")->timezone('Asia/Kolkata');
        //Insert Survey start count data from cron automatic   
        //$schedule->command('surveystartcount:create')->dailyAt("23:59")->timezone('Asia/Kolkata');

        //Insert Survey report data from cron automatic

        // $fileN = 'testfile.log';
        $fileN = 'new-assign-survey.log';
       $schedule->command('reminder:new-assign-survey')->everyFifteenMinutes()

           ->runInBackground()->sendOutputTo($fileN)->timezone('Asia/Kolkata')
           ->withoutOverlapping();
       $schedule->command('surveyreport:create')->everyFifteenMinutes()
       ->runInBackground()
         ->withoutOverlapping();


        $file = 'monthActiveUserlist.log';
        $schedule->command('user:active_user_list')
          ->dailyAt("19:01")->timezone('Asia/Kolkata')
         ->runInBackground()->withoutOverlapping()->sendOutputTo($file);
      


        //Upadte response rate from cron automatic
        //$schedule->command('sjpanelresponserate:daily_update')->dailyAt("01:00")->timezone('Asia/Kolkata');

        // modified by obhi
        //  $schedule->command('survey:reminder')->everyMinute()->timezone('Asia/Kolkata');
        //$schedule->command('profileMail:send')->dailyAt("05:12")->timezone('Asia/Kolkata');
         // modified by obhi
        
       /* $file = 'command1_output.log';
        $schedule->command('email:user-assaigned-project')
        ->dailyAt("08:30")
        //  ->everyMinute()
         ->runInBackground()
         ->withoutOverlapping()->sendOutputTo($file)
          ->timezone('Asia/Kolkata');*/
        // ->timezone('America/New_York');

          //$schedule->command('survey:reminder')->dailyAt("05:12")->timezone('Asia/Kolkata'); 
          //$schedule->command('email:survey-reminder')->dailyAt("05:12")->timezone('Asia/Kolkata'); 


        //  add invitation scaduler my Hiamnshu 24-09-2025
        // $file = storage_path('logs/award_invitation.log');
        // $schedule->command('custom:send-award-invitation-emails')
        // // ->withoutOverlapping()
        // ->sendOutputTo($file)
        // // ->everyMinute();
        // ->everyFiveMinutes();
        
        // end invitation scaduler 

                
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
