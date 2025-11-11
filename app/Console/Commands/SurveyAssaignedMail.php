<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Inpanel\UserProject\SurveyAssaigned;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use Carbon\Carbon;

class SurveyAssaignedMail extends Command
{
    protected $signature = 'email:user-assaigned-project';

    protected $description = 'Send email to user if conditions are met';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

     //    $appUrl = env('APP_URL');
    	// echo $appUrl;
    	
         $user_projects = DB::table('user_projects as up')
            ->join('projects as p', 'up.project_id', '=', 'p.id')
            ->join('users', 'users.id', '=', 'up.user_id') 
            ->select(DB::raw('count(*) as user_count, up.user_id'))
            ->where('p.survey_status_code', '=', 'LIVE')
            ->where('up.status', '=', null)
            //->where('up.user_id','2501')
            ->where(DB::raw('date_format(up.created_at,"%Y-%m-%d")'), date('Y-m-d'))
            ->groupBy('up.user_id')
            ->get();
           
           
            if(!empty($user_projects)){
             foreach ($user_projects as $userinfo) {

              $user = User::find($userinfo->user_id); 
              $email = new SurveyAssaigned($user, $userinfo->user_count);
              Mail::send($email);
            }
        }
    }
}
