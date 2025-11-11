<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\Inpanel\UserProject\SurveyTestInvite;
use App\Mail\Inpanel\UserProject\autReminderSurveyMail;
use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting\Setting;
use App\Models\Project\InviteSentDetails;

class surveyReminderAfter24Hours extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $reminderTime = Setting::where('key','REMINDER_INVITE_TIME')->first();
        $time = $reminderTime->value;

        $users = DB::table('user_projects')
                ->select('users.*', 'user_projects.*', 'projects.*', 'users.id as user_id', 'user_projects.created_at as u_pro_created_at', 'users.uuid as uuid','project_quotas.apace_quota_id as apace_p_quota_id','user_projects.project_quota_id as apace_project_quota_id')
                ->whereNotNull('user_projects.status')
                ->whereDate('user_projects.created_at', '<', now()->subHours($time)) 
                ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                ->where('projects.survey_status_code', '=', 'LIVE')
                ->join('project_quotas', 'project_quotas.project_id', '=', 'user_projects.project_id')
                ->orderBy('projects.cpi', 'desc')
                ->join('users', 'users.id', '=', 'user_projects.user_id')
                ->where('active', 1)  
                ->get();
    

         $users_invited = DB::table('invite_sent_details')
                            ->whereDate('invite_sent_details.created_at', '<', now()->subHours($time))
                            ->join('projects', 'projects.id', '=', 'invite_sent_details.project_id')
                            ->where('projects.survey_status_code', '=', 'LIVE')
                            ->where('invite_sent_details.reminder','=',0)
                            ->get();

            if (isset($users_invited) && !empty($users_invited)) {
            $user_invite_reminder_id = [];
            $user_invite_reminder_uuids = [];
            $user_invite_reminder_survey_codes =[];       
            foreach ($users_invited as $user_invite) {
                $user_invite_reminder_id[] = $user_invite->id;
                $invite_detail = explode(',', $user_invite->user_ids);
                $invite_detail_code = explode(',', $user_invite->apace_project_code);
                $user_invite_reminder_uuids = array_merge($user_invite_reminder_uuids, $invite_detail);
                $user_invite_reminder_survey_codes = array_merge($user_invite_reminder_survey_codes,$invite_detail_code);
              }
              $user_invite_reminder_survey_codes = array_unique($user_invite_reminder_survey_codes);
            }
            // echo "<pre>";
            // print_r(count($user_invite_reminder_survey_codes));
            // die();

            
            $invite_sent_datas =$this->checkSurveyAnduuids($users,$user_invite_reminder_survey_codes, $user_invite_reminder_uuids);
            // echo "<pre>";
            // print_r($invite_sent_datas);
            // die();
            $this->updatereminderSurveyMail($user_invite_reminder_id, $invite_sent_datas);
        
            $dataArray=['template_type'=>'predefined','from_name'=>'sjpanel','from_email'=>'rameshk@samplejunction','name'=>'sjpanel'];
            $pointsConversionMetric = config('app.points.metric.conversion');

            if(isset($users) && !empty($users)){
                $invit =[];
                foreach($users as $user){
                    try {

                        $locale=$user->locale;
                        app()->setLocale($locale);
                        $device =$this->getProjectDeviceName($user);    
                        $email_data = [
                            'email' => decrypt( $user->email),
                             //'email' => 'amarjitm@samplejunction.com',
                            'from_name' => (!empty($dataArray['name']))?$dataArray['name']:'SJ Panel',
                            'from_address' => (!empty($dataArray['email']))?$dataArray['email']/*.'@sjpanel.com'*/:'do-not-reply@sjpanel.com',
                            'subject' => __('inpanel.mail.survey.reminder_subject_new',['reminder_points' => $user->cpi]),
                        ];
                    
                        $email = new autReminderSurveyMail($email_data, $user,$device);
                        Mail::send($email);
                
                    } catch (\Exception $e) {
                        continue;
                    }
                }
                
                
            }
            \Log::info('Reminder send');
    }




    /*
    Function to get the Project Device Name.
    */ 

    public function getProjectDeviceName($project)
        {
            $allProjectDevice = $project->device_options;
            $projectDevice = explode(',',$allProjectDevice);
            
            $retunDevice=[];
            foreach($projectDevice as $device){
                
                if($device==2){
                    $retunDevice[] = "DESKTOP";
                } 
                if($device==3){
                    $retunDevice[] = "PHONE";
                }
                if($device==4){
                    $retunDevice[] = "TABLET";
                }
                
            }

            return implode('/',$retunDevice);

        }

      /*
    Function for Updating sent details in invite_sent_details table
    */
    public function updatereminderSurveyMail($user_invite_reminder_id = null, $invite_sent_datas = null)
    {
        if ($user_invite_reminder_id !== null && is_array($user_invite_reminder_id)) {
            InviteSentDetails::whereIn('id', $user_invite_reminder_id)
                ->update([
                    'reminder' => \DB::raw('reminder + 1'),
                    'updated_at' => Carbon::now()
                ]);
          
        }
    
        if ($invite_sent_datas !== null && is_array($invite_sent_datas)) {
           foreach($invite_sent_datas as $invite_sent_data){
            InviteSentDetails::create($invite_sent_data);
           }
        }
    } 
    
      /*
    Function for array $invite_datas
    */
    public function checkSurveyAnduuids($users=null,$user_invite_reminder_survey_codes=null, $user_invite_reminder_uuids=null)
     {
        if(isset($users) && !empty($users)){
            $invit =[];
            $survey_code=[];
            foreach($users as $user){
                if(in_array($user->apace_project_code,$user_invite_reminder_survey_codes)){
                    if(!in_array($user->uuid,$user_invite_reminder_uuids)){
                        $invit[] = [
                            'uuid' => $user->uuid,
                            'survey_code' => $user->apace_project_code,
                            "project_id" => $user->project_id,
                            "project_quota_id" => $user->project_quota_id,
                            "apace_project_quota_id" => $user->apace_p_quota_id
                        ];
                    }
                }else{
                    $invit[] = [
                            'uuid' => $user->uuid,
                            'survey_code' => $user->apace_project_code,
                            "project_id" => $user->project_id,
                            "project_quota_id" => $user->project_quota_id,
                            "apace_project_quota_id" => $user->apace_p_quota_id
                    ];
                }
                $survey_code[] = $user->apace_project_code;
            }
    
            $survey_code = array_unique($survey_code);
            // return $invit;

            $invite_sent_datas = [];

            foreach ($invit as $init) {
                if (in_array($init['survey_code'], $survey_code)) {
                    $index = array_search($init['survey_code'], array_column($invite_sent_datas, 'apace_project_code'));
                    
                    if ($index !== false) { 
                        // Append user IDs and update invitation count
                        $invite_sent_datas[$index]['user_ids'] .= ',' . $init['uuid'];
                        $invite_sent_datas[$index]['invitecnt'] += 1;
                    } else {
                        // Insert new record
                        $dates = Carbon::now();
                        $invite_sent_datas[] = [
                            "project_id" => $init['project_id'],
                            "project_quota_id" => $init['project_quota_id'],
                            "apace_project_code" => $init['survey_code'],
                            "apace_project_quota_id" => $init['apace_project_quota_id'],
                            "user_ids" => $init['uuid'],
                            "created_at" => $dates,
                            'invitecnt' => 1,
                            'reminder' => 0,
                            'surveycnt' => 0
                        ];
                    }
                }
            }
            
            return $invite_sent_datas;                 
    }
  }
    

}
