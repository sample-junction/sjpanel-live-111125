<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\Inpanel\UserProject\SurveyAssaigned;
use Illuminate\Support\Facades\DB;
use App\Models\Auth\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
class ActiveUserList extends Command
{
    protected $signature = 'user:active_user_list';

    protected $description = 'Active User List';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Cache::forget('activeUsers');
         $post=1;
        if ($post) {
            //$startDate = $post['fromDate'];

            //$endDate = $post['toDate'];
              $startDate = '2025-03-01';

             $endDate = '2025-03-31';
           
            $dateLimit = " AND updated_at >= '".$startDate."' AND updated_at <= '".$endDate."'";
            $dateTimeLimit = " AND updated_at >= '".$startDate." 00:00:00' AND updated_at <= '".$endDate." 23:59:59'"; 
            $dateTimeLimitChannel = " AND updatedOn >= '".$startDate." 00:00:00' AND updatedOn <= '".$endDate." 23:59:59'"; 
        }

// Profile filled subquery
$profileLog = DB::table('activity_log')
    ->select('causer_id', DB::raw('COUNT(*) AS profile_filled'))
    ->where('log_name', 'default')
    ->where('description', 'like', '%inpanel.activity_log.profile%')
    ->groupBy('causer_id');

// Fraud users subquery
$froudUsers = DB::table('froud_users')
    ->select('panellist_id', DB::raw('COUNT(*) AS froud_count'))
    ->groupBy('panellist_id');

// Last login subquery
$lastLogin = DB::table('activity_log')
    ->select('causer_id', DB::raw('MAX(updated_at) AS last_login'))
    ->where('description', 'inpanel.activity_log.log_in')
    ->groupBy('causer_id');

// Latest activity with description subquery
$latestActivity = DB::table('activity_log as al1')
    ->join(DB::raw('(
        SELECT causer_id, MAX(updated_at) as latest 
        FROM activity_log 
        GROUP BY causer_id
    ) al2'), function ($join) {
        $join->on('al1.causer_id', '=', 'al2.causer_id')
             ->on('al1.updated_at', '=', 'al2.latest');
    })
    ->select('al1.causer_id', 'al1.description AS Activities');

// Date of registration subquery
$dateOfJoin = DB::table('activity_log')
    ->select('causer_id', DB::raw('MIN(updated_at) as date_of_join'))
    ->whereIn('description', ['inpanel.activity_log.registration', 'inpanel.activity_log.user_confirm'])
    ->groupBy('causer_id');

// Last activity date subquery
$lastActivity = DB::table('activity_log')
    ->select('causer_id', DB::raw('MAX(updated_at) as Activities_date'))
    ->groupBy('causer_id');

// Properties (latest) subquery
$latestProperty = DB::table('activity_log as al1')
    ->join(DB::raw('(
        SELECT causer_id, MAX(updated_at) as latest 
        FROM activity_log 
        GROUP BY causer_id
    ) al2'), function ($join) {
        $join->on('al1.causer_id', '=', 'al2.causer_id')
             ->on('al1.updated_at', '=', 'al2.latest');
    })
    ->whereNotNull('al1.properties')
    ->select('al1.causer_id', 'al1.properties AS property');

// Survey data subquery
$surveyData = DB::table('user_projects')
    ->select(
        'user_id',
        DB::raw('COUNT(CASE WHEN status IS NOT NULL THEN 1 END) as Total_survey_taken'),
        DB::raw('MAX(status) as survey_status'),
        DB::raw('COUNT(CASE WHEN status IN (1, 50) THEN 1 END) as Total_survey_completed'),
        DB::raw('MAX(updated_at) as survey_taken'),
        DB::raw('MAX(CASE WHEN status IN (1, 50) THEN updated_at ELSE NULL END) as last_survey_completed_on')
    )
    ->groupBy('user_id');

// Unsubscribe subquery
$unsubscribe = DB::table('user_unsubscribes')
    ->select(DB::raw('SHA1(email) as hashed_email'), DB::raw('MAX(created_at) as unsubscribed_on'))
    ->groupBy(DB::raw('SHA1(email)'));

$support_chats = DB::table('support_chats')
    ->select('user_id', DB::raw('MAX(updated_at) as support_date'))
    ->groupBy('user_id');

    $request_redeems = DB::table('request_redeems')
    ->select('user_uuid', DB::raw('MAX(created_at) as redeem_request'))
    ->groupBy('user_uuid');

$user_refer_date_info1 = DB::table('user_referral_codes')
    ->select('user_id', DB::raw('MAX(created_at) as user_refer_date'))
    ->groupBy('user_id');

// Final user query
$users = User::query()
    ->select('users.*',
        DB::raw('TIMESTAMPDIFF(YEAR, DATE(users.dob), CURDATE()) AS age'),
        'profile_log.profile_filled',
        'froud_users1.froud_count',
        'last_login_log.last_login',
        'Activities_sub_act.Activities',
        'Activities_sub.date_of_join',
        'Activities_date_sub.Activities_date',
        'properties_log.property',
        'survey_data.Total_survey_taken',
        'survey_data.survey_status',
        'survey_data.last_survey_completed_on',
        'survey_data.Total_survey_completed',
        'survey_data.survey_taken',
        'unsubscribe_log.unsubscribed_on',
        'support_chats_info.support_date',
        'request_redeems_info.redeem_request',
        'user_refer_date_info.user_refer_date',
        'device_histories.device_type'
    )
    ->leftJoin('device_histories', 'users.id', '=', 'device_histories.user_id')
    ->leftJoinSub($profileLog, 'profile_log', function ($join) {
        $join->on('profile_log.causer_id', '=', 'users.id');
    })
    ->leftJoinSub($froudUsers, 'froud_users1', function ($join) {
        $join->on('froud_users1.panellist_id', '=', 'users.panellist_id');
    })
    ->leftJoinSub($lastLogin, 'last_login_log', function ($join) {
        $join->on('last_login_log.causer_id', '=', 'users.id');
    })
    ->leftJoinSub($latestActivity, 'Activities_sub_act', function ($join) {
        $join->on('Activities_sub_act.causer_id', '=', 'users.id');
    })
    ->leftJoinSub($dateOfJoin, 'Activities_sub', function ($join) {
        $join->on('Activities_sub.causer_id', '=', 'users.id');
    })
    ->leftJoinSub($lastActivity, 'Activities_date_sub', function ($join) {
        $join->on('Activities_date_sub.causer_id', '=', 'users.id');
    })
    ->leftJoinSub($latestProperty, 'properties_log', function ($join) {
        $join->on('properties_log.causer_id', '=', 'users.id');
    })
    ->leftJoinSub($surveyData, 'survey_data', function ($join) {
        $join->on('survey_data.user_id', '=', 'users.id');
    })
    ->leftJoinSub($unsubscribe, 'unsubscribe_log', function ($join) {
        $join->on('unsubscribe_log.hashed_email', '=', 'users.email_hash');
    })
    ->leftJoinSub($support_chats, 'support_chats_info', function ($join) {
        $join->on('support_chats_info.user_id', '=', 'users.id');
    })
    ->leftJoinSub($request_redeems, 'request_redeems_info', function ($join) {
        $join->on('request_redeems_info.user_uuid', '=', 'users.uuid');
    })
    ->leftJoinSub($user_refer_date_info1, 'user_refer_date_info', function ($join) {
        $join->on('user_refer_date_info.user_id', '=', 'users.id');
    })
    ->whereExists(function ($query) {
        $query->select(DB::raw(1))
            ->from('roles')
            ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
            ->whereColumn('model_has_roles.model_id', 'users.id')
            ->where('roles.id', 4);
    })
    //->where('users.uuid','8de8ebdd-cf01-45ea-b5c3-c9ad40271c40')
    ->whereNull('users.deleted_at')
    ->groupBy('users.id')
    ->orderByDesc('users.created_at')
    ->get();

                    $expiresAt=3600*24;
                    Cache::put('activeUsers',$users, $expiresAt);
                    // Cache::put('monthlyaward',$MonthlyAward, $expiresAt);
    
    }
}
