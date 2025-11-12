<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Project\SjpanelResponserates;
use App\Models\Report\SurveyStartCount;
use App\Repositories\Backend\Auth\UserRepository;
use App\Models\Report\SurveyReport;
use App\Models\Auth\User;
use App\Models\Redeem\RequestRedeem;
use App\Models\Project\UserProject;
use Illuminate\Http\Request;
use App\Models\Setting\Setting;
use App\Models\Traffics\Traffic;
use MongoDB\BSON\UTCDateTime;
use Carbon\Carbon;

/**
 * Class DashboardController.
 */

class DashboardController extends Controller
{

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;

    }

    /**
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {

        //$responseRate = SjpanelResponserates::first();
        $fromDate   = $request->get('fromDate');
        $toDate     = $request->get('toDate');
       
        $fromLastDays = config('app.dashboard_last_day.days');
        // $getMonthLimit = Setting::where('key','=','PANEL_ACTIVE_MONTH_LIMIT')->first();
        // $fromLastMonths = $getMonthLimit->value;
        //echo $fromLastDays;die;
        if(!empty($fromDate) && !empty($toDate)){
            $fromDate = $fromDate;
            $toDate   = $toDate;
        }else{
            $fromDate = now()->subDays($fromLastDays)->endOfDay();
            //$fromDate = now()->subMonths($fromLastMonths);
            $toDate   = now();
        }
        
        //print_r($toDate); die;
        /**
         * Total Response Rate 
         */
        // Code Added by Vikas(Starting)
        // $resultData = SurveyStartCount::selectRaw('SUM(start_count) as startCount')
        //                             //->where('start_date', '>', $fromDate)
        //                             //->where('start_date', '<=', $toDate)
        //                             ->whereBetween('start_date', [$fromDate, $toDate])
        //                             //->where('start_date', '>=', $fromDate)
        //                             ->first();
        if (!empty($fromDate)) {
            // Convert string to Carbon
            $fromDate = Carbon::parse($fromDate);

            // Then get timestamp properly
            $filterDate = new UTCDateTime($fromDate->getTimestamp() * 1000);
        }
        $query = Traffic::where('source_code', 'SJPL')
                ->where(function ($q) {
                    $q->where('channel_id', '2')
                        ->orWhere('channel_id', 2);
                })
                ->where('updated_at', '>=', $filterDate);
        $resultData = $query->count();

        $invite_sent_details = \DB::table('invite_sent_details')
                                ->select(\DB::raw('SUM(reminder) as rcnt'),\DB::raw('SUM(invitecnt) as icnt'),\DB::raw('SUM(surveycnt) as scnt'))
                                ->whereBetween('created_at', [$fromDate, $toDate])
                                ->orWhereBetween('updated_at', [$fromDate, $toDate])->first();
                                /*->where('created_at', '>=', $fromDate)
                                ->orWhere('updated_at', '>=', $fromDate)->first();*/

        $totalStart  = $resultData;
        $totalInvite =  ($invite_sent_details->icnt)?$invite_sent_details->icnt:0;
        // Code Added by Vikas(Ending)

        if($totalInvite > 0){
            $totalResponseRate = round(($totalStart/$totalInvite)*100);
        }else{
            $totalResponseRate = 0;
        }

            /**
            *  Active Panellist With Time - latest
            */
            $activeUsers = User::select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at','T2.updated_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
                // Code Added by Vikas(laravel 9 to 10 upgradation-Starting-6/10/2025)
                //  ->leftJoin(DB::raw('(SELECT user_id,updated_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `user_id` order BY `updated_at` DESC)').' AS `row_num` FROM `user_projects` WHERE `status` IS NOT NULL)').' AS T1 WHERE T1.`row_num` = 1) as T2'), function ($join) {
                //                 $join->on ('users.id', '=', 'T2.user_id' );
                //              })    
                // ->leftJoin(DB::raw('(SELECT causer_id,created_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `causer_id` order BY `created_at` DESC)').' AS `row_num` FROM `activity_log`)').' AS T3 WHERE T3.`row_num` = 1) as T4'), function ($join) {
                //     $join->on ('users.id', '=', 'T4.causer_id' );
                //  })    
                ->leftJoin(DB::raw('(
                    SELECT user_id, updated_at
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER(PARTITION BY user_id ORDER BY updated_at DESC) AS row_num
                        FROM user_projects
                        WHERE status IS NOT NULL
                    ) AS T1
                    WHERE T1.row_num = 1
                ) AS T2'), function ($join) {
                    $join->on('users.id', '=', 'T2.user_id');
                })
                ->leftJoin(DB::raw('(
                    SELECT causer_id, created_at
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER(PARTITION BY causer_id ORDER BY created_at DESC) AS row_num
                        FROM activity_log
                    ) AS T3
                    WHERE T3.row_num = 1
                ) AS T4'), function ($join) {
                    $join->on('users.id', '=', 'T4.causer_id');
                })
                // Ending(Vikas 6/10/2025)
                 ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
                 ->join('roles', function ($join) {         
                     $join->on('roles.id', '=', 'model_has_roles.role_id')             
                     ->where('roles.id', '=', 4);     
                 })
                ->whereIn('users.confirmed',array("1","2"))
                //->where('users.unsubscribed',"0")
                ->where('users.is_blacklist',"0")
                ->where('users.active',"1")
                //->where('T2.updated_at',">", Carbon::now()->subMonths(6))
                ->where(function($query) use ($fromDate, $toDate){
                    $query->whereBetween('T2.updated_at', [$fromDate, $toDate])
                          ->orWhereBetween('T4.created_at', [$fromDate, $toDate]);
                  })
                ->whereNull('users.deleted_at')
                ->get();

        /**
        * Total Active Panellist with all time
        */
        $TotalActiveUsersuid = User::select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at','T2.updated_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
                // Code Added by Vikas(laravel 9 to 10 upgradation-Starting-6/10/2025) 
                // ->leftJoin(DB::raw('(SELECT user_id,updated_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `user_id` order BY `updated_at` DESC)').' AS `row_num` FROM `user_projects` WHERE `status` IS NOT NULL)').' AS T1 WHERE T1.`row_num` = 1) as T2'), function ($join) {
                //                 $join->on ('users.id', '=', 'T2.user_id' );

                //             })    
                ->leftJoin(DB::raw('(
                    SELECT user_id, updated_at 
                    FROM (
                        SELECT *,
                            ROW_NUMBER() OVER(PARTITION BY user_id ORDER BY updated_at DESC) AS row_num
                        FROM user_projects
                        WHERE status IS NOT NULL
                    ) AS T1
                    WHERE T1.row_num = 1
                ) AS T2'), function ($join) {
                    $join->on('users.id', '=', 'T2.user_id');
                })
                // Code Added by Vikas(laravel 9 to 10 upgradation-Ending-6/10/2025)
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
                            ->join('roles', function ($join) {         
                                $join->on('roles.id', '=', 'model_has_roles.role_id')             
                                ->where('roles.id', '=', 4);     
                            })

                //->where('users.confirmed',"1")
                ->whereIn('users.confirmed',array("1","2"))
                //->where('users.unsubscribed',"0")
                ->where('users.is_blacklist',"0")
                //->where('T2.updated_at',">", Carbon::now()->subMonths(6))
                //->whereBetween('T2.updated_at', [$fromDate, $toDate])
                ->whereNull('users.deleted_at')
                ->get();
                $TotalActiveUsers=$TotalActiveUsersuid->count();
           
            $uuid=[];
            foreach($TotalActiveUsersuid as $value){
               $uuid[]=$value->uuid; 
            }



        /**
         * Total Panellist
         */
        $totalUsers = User::all();

        /**
         * Inactive Users
         */
        $totalInactive = $TotalActiveUsers-count($activeUsers);

        /**
         * Total Incentive Paid
         */
        $totalIncentivePaid = RequestRedeem::selectRaw('SUM(redeem_points) as total_Points')
        ->join('users', function ($join) {         
            $join->on('request_redeems.user_uuid', '=', \DB::raw('users.uuid COLLATE utf8mb4_unicode_ci'))             
            ->where('request_redeems.status', '=', 'completed');     })     
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
            ->join('roles', function ($join) {         
                $join->on('roles.id', '=', 'model_has_roles.role_id')             
                ->where('roles.id', '=', 4);     })  
                          ->whereBetween('coupon_redeemed', [$fromDate, $toDate])
                          ->first();

        /**
         * Total Complete Report
         */

        // $surveyCompleteReport = SurveyReport::where('source_code','SJPL')
        //                     ->join('users', 'survey_reports.uuid COLLATE utf8mb4_0900_ai_ci', '=', 'users.uuid  COLLATE utf8mb4_unicode_ci')     
        //                     ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
        //                     ->join('roles', function ($join) {         
        //                         $join->on('roles.id', '=', 'model_has_roles.role_id')             
        //                         ->where('roles.id', '=', 4);     
        //                     })
        //                   ->where('status', 1)
        //                   //->where('createdOn', '>=',$fromDate)
        //                   ->whereBetween('createdOn', [$fromDate, $toDate])
        //                   ->orWhereBetween('updatedOn', [$fromDate, $toDate])
        //                   ->get();

        $surveyCompleteReport = SurveyReport::where('source_code', 'SJPL')     
        ->join('users', function ($join) {         
            $join->on('survey_reports.uuid', '=', \DB::raw('users.uuid COLLATE utf8mb4_unicode_ci'))             
            ->where('survey_reports.status', '=', 1);     })     
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
            ->join('roles', function ($join) {         
                $join->on('roles.id', '=', 'model_has_roles.role_id')             
                ->where('roles.id', '=', 4);     })     
                ->where(function ($query) use ($fromDate, $toDate) {         
                    $query->whereBetween('survey_reports.createdOn', [$fromDate, $toDate])               
                    ->orWhereBetween('survey_reports.updatedOn', [$fromDate, $toDate]);     })     
                    ->get();


                    // echo "<pre>";
                    // print_r($surveyCompleteReport->toArray()); die();

        /**
         * Last Signup Date
         */
        $lastSignupDate =  DB::table('users')
                        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id') 
                        ->select('users.created_at')        
                        ->join('roles', function ($join) {         
                            $join->on('roles.id', '=', 'model_has_roles.role_id')             
                            ->where('roles.id', '=', 4);     })  
                            ->orderBy('users.created_at','desc')->first();



        /**
         * Last Confirmation Date
         */
        $lastCofirmDate = DB::table('users')
        ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id') 

        ->join('roles', function ($join) {         
            $join->on('roles.id', '=', 'model_has_roles.role_id')             
            ->where('roles.id', '=', 4);     })  
            ->orderBy('confirm_at','desc')->first();
        //echo '<pre>';
        //print_r($lastCofirmDate);die;
        /**
         * Last Deactive Date
         */
        $lastDeactiveDate = DB::table('users')
                            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
                            ->join('roles', function ($join) {         
                                $join->on('roles.id', '=', 'model_has_roles.role_id')             
                                ->where('roles.id', '=', 4);     })  
                                ->orderBy('deactivate_at','desc')->first();

        /**
         * Last Redeemption Request Date
         */
        $lastRedeemRequestDate = RequestRedeem::orderBy('request_redeems.created_at','desc')
        ->select('request_redeems.created_at')
                                                    ->join('users', function ($join) {         
                                                    $join->on('request_redeems.user_uuid', '=', \DB::raw('users.uuid COLLATE utf8mb4_unicode_ci')); })     
                                                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
                                                    ->join('roles', function ($join) {         
                                                        $join->on('roles.id', '=', 'model_has_roles.role_id')             
                                                    ->where('roles.id', '=', 4);     })  ->first();

        //print_r($lastRedeemRequestDate['created_at']);die;
        /**
         * Last Survey Attempted Date
         */
        $lastSurveyAttemptDate = UserProject::whereNotNull('status')->orderBy('user_projects.updated_at','desc')  
        ->select('user_projects.updated_at')
        ->join('users', function ($join) {         
            $join->on('user_projects.user_id', '=', \DB::raw('users.id COLLATE utf8mb4_unicode_ci')); })     
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
            ->join('roles', function ($join) {         
                $join->on('roles.id', '=', 'model_has_roles.role_id')             
            ->where('roles.id', '=', 4);     })
            ->first();
        // echo '<pre>';
        // print_r($lastSurveyAttemptDate);die;
        /**
         * Last Survey Completed Date
         */
        $lastSurveyCompleteDate = UserProject::where('status',1) ->orderBy('user_projects.updated_at','desc') 
        ->select('user_projects.updated_at')
        ->join('users', function ($join) {         
            $join->on('user_projects.user_id', '=', \DB::raw('users.id COLLATE utf8mb4_unicode_ci')); })     
            ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
            ->join('roles', function ($join) {         
                $join->on('roles.id', '=', 'model_has_roles.role_id')             
            ->where('roles.id', '=', 4);     })
            ->first();

        /**
         * Last Redeemption Request Processed Date
         */
        $lastRedeemRequestProcesseDate = RequestRedeem::orderBy('approve','desc')
        ->select('request_redeems.*')
                                                    ->join('users', function ($join) {         
                                                    $join->on('request_redeems.user_uuid', '=', \DB::raw('users.uuid COLLATE utf8mb4_unicode_ci')); })     
                                                    ->join('model_has_roles', 'model_has_roles.model_id', '=', 'users.id')     
                                                    ->join('roles', function ($join) {         
                                                        $join->on('roles.id', '=', 'model_has_roles.role_id')             
                                                    ->where('roles.id', '=', 4);     })  ->first();

        

        return view('backend.dashboard')
              ->with("fromLastDays",$fromLastDays)
              ->with("totalResponseRate",$totalResponseRate)
              ->with("activeUsers",$activeUsers)
              ->with("surveyCompleteReport",$surveyCompleteReport)
              ->with('totalInactive', $totalInactive)
              ->with('totalIncentivePaid', $totalIncentivePaid)
              ->with('totalUsers', count($totalUsers))
              ->with('totalActiveUsers', $TotalActiveUsers)
              ->with('lastSignupDate',$lastSignupDate)
              ->with('lastCofirmDate',$lastCofirmDate)
              ->with('lastDeactiveDate',$lastDeactiveDate)
              ->with('lastRedeemRequestDate',$lastRedeemRequestDate)
              ->with('lastSurveyAttemptDate',$lastSurveyAttemptDate)
              ->with('lastSurveyCompleteDate',$lastSurveyCompleteDate)
              ->with('lastRedeemRequestProcesseDate',$lastRedeemRequestProcesseDate);
    }
}
