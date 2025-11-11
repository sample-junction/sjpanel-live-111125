<?php

namespace App\Console\Commands;

use App\Mail\Backend\SurveyDetailWithAdmin\SendTotalSurveyWithIDToAdmin;
use App\Mail\Inpanel\Support\PanelistBirthdayMail;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Mail;
use App\Models\Project\UserProject;
use App\Models\Report\SurveyReport;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Command;
use App\Mail\SurveyReminder;
use App\Helpers\MailHelper;
use App\Models\Auth\User;
use Carbon\Carbon;

class SendPanlistIDWithCountSurveyWithSurveyID extends Command
{
    protected $signature = 'email:sendSurveyCountWithSurveyID';
    protected $description = 'Send emails for assigned survey with counts and survey Id to the panelist';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $activeUsers1=User::whereHas('roles',function($query){$query->where('id',4);})
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();
        $survey_data = [];
        $time='10';
        
        $survey_data[] = array('Panelist ID', 'Total number of survey assinged', 'Survey number');
        foreach ($activeUsers1 as $value) {
            $date = Carbon::now()->subHours($time)->format('Y-m-d');
            //$result = SurveyReport::where('uuid', $value->uuid)->whereDate('createdOn',$date)->get();
            $result = UserProject::where('user_id', $value->id)->whereDate('created_at',$date)->get();
            if(count($result) > 0){
                $row_first = 1;
                foreach ($result as $key => $data) {
                    if($row_first == 1){
                        $survey_data[] = array($value->panellist_id, count($result), $data->apace_project_code);
                    }else{
                        $survey_data[] = array(' ', ' ', $data->apace_project_code);
                    } 
                    $row_first++;
                }
            }
        }
        
        $csv = '';
        foreach ($survey_data as $row) {
            $csv .= implode(',', $row) . "\n";
        }

        $filename = storage_path('app/survey-assignment-report-' . Carbon::now()->format('m-d-Y') . '.csv');
        file_put_contents($filename, $csv);
        
        $email = new SendTotalSurveyWithIDToAdmin($filename);
        Mail::send($email);
        unlink($filename);

        $this->info('Emails sent successfully.');
    }
}
