<?php

namespace App\Repositories\Backend\Auth;

use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Repositories\BaseRepository;
use App\Events\Backend\Auth\User\UserCreated;
use App\Events\Backend\Auth\User\UserUpdated;
use App\Events\Backend\Auth\User\UserRestored;
use App\Events\Backend\Auth\User\UserConfirmed;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Events\Backend\Auth\User\UserDeactivated;
use App\Events\Backend\Auth\User\UserReactivated;
use App\Events\Backend\Auth\User\UserUnconfirmed;
use App\Events\Backend\Auth\User\UserPasswordChanged;
use App\Notifications\Backend\Auth\UserAccountActive;
use App\Events\Backend\Auth\User\UserPermanentlyDeleted;
use App\Notifications\Frontend\Auth\UserNeedsConfirmation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use App\Models\Profiler\ProfileSection;
use App\Models\Profiler\ProfilerQuestions;
use App\Models\Profiler\GlobalProfileQuestion;
use App\Models\Project\Project;
use App\Models\Report\SurveyReport;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use App\Models\CountryTrans;
use Illuminate\Support\Facades\Cache;


/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    /**
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * @return mixed
     */
    public function getUnconfirmedCount() : int
    {
        return $this->model
            ->where('confirmed', 0)
            ->count();
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return mixed
     */
    public function getActivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->with('roles', 'permissions', 'providers')
            ->active()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    public function getUsers()
    {
        return $this->model
            ->with('roles', 'permissions', 'providers')
            ->active()
            ->get();
    }

    public function getActiveUsers($uuids=null,$panelists=null)
    {
        $getMonthLimit = Setting::where('key','=','PANEL_ACTIVE_MONTH_LIMIT')->first();
        $lastMonth = $getMonthLimit->value;
        $fromDate = now()->subMonths($lastMonth);
        $toDate   = now();
        if($uuids){
        //     return DB::table('users')
        //     ->select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at')
        //     ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
        //     ->leftJoin('user_projects','user_projects.user_id','=','users.id')
        //     ->where('users.confirmed',"1")
        //     ->where('users.unsubscribed',"0")
        //     ->where('users.is_blacklist',"0")
        //     ->where('user_projects.updated_at',">", Carbon::now()->subMonths(6))
        //     ->whereNull('users.deleted_at')
        //   //  ->whereNotNull('user_projects.status')
        //     ->whereIn('users.email', $emailids)
        //     ->groupBy('user_projects.user_id')
        //     ->get();

            //return DB::table('users')
            return User::select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at','T2.updated_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
                ->leftJoin(DB::raw('(SELECT user_id,updated_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `user_id` order BY `updated_at` DESC)').' AS `row_num` FROM `user_projects` WHERE `status` IS NOT NULL)').' AS T1 WHERE T1.`row_num` = 1) as T2'), function ($join) {
                                $join->on ('users.id', '=', 'T2.user_id' );
                            }) 
                ->leftJoin(DB::raw('(SELECT causer_id,created_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `causer_id` order BY `created_at` DESC)').' AS `row_num` FROM `activity_log`)').' AS T3 WHERE T3.`row_num` = 1) as T4'), function ($join) {
                                $join->on ('users.id', '=', 'T4.causer_id' );
                             })          
                ->where('users.confirmed',"1")
                //->where('users.unsubscribed',"0")
                ->where('users.is_blacklist',"0")
                //->where('T2.updated_at',">", Carbon::now()->subMonths($lastMonth))
                ->where(function($query) use ($fromDate, $toDate){
                    $query->whereBetween('T2.updated_at', [$fromDate, $toDate])
                          ->orWhereBetween('T4.created_at', [$fromDate, $toDate]);
                  })
                ->whereNull('users.deleted_at')
                ->whereIn('users.uuid', $uuids)
                ->get();

        }elseif($panelists){
        //     return DB::table('users')
        //     ->select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at')
        //     ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
        //     ->leftJoin('user_projects','user_projects.user_id','=','users.id')
        //     ->where('users.confirmed',"1")
        //     ->where('users.unsubscribed',"0")
        //     ->where('users.is_blacklist',"0")
        //     ->where('user_projects.updated_at',">", Carbon::now()->subMonths(6))
        //     ->whereNull('users.deleted_at')
        //   //  ->whereNotNull('user_projects.status')          
        //     ->whereIn('users.panellist_id', $panelists)
        //     ->groupBy('user_projects.user_id')
        //     ->get();

            //return DB::table('users')
                return User::select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at','T2.updated_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
                ->leftJoin(DB::raw('(SELECT user_id,updated_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `user_id` order BY `updated_at` DESC)').' AS `row_num` FROM `user_projects` WHERE `status` IS NOT NULL)').' AS T1 WHERE T1.`row_num` = 1) as T2'), function ($join) {
                                $join->on ('users.id', '=', 'T2.user_id' );
                            }) 
                ->leftJoin(DB::raw('(SELECT causer_id,created_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `causer_id` order BY `created_at` DESC)').' AS `row_num` FROM `activity_log`)').' AS T3 WHERE T3.`row_num` = 1) as T4'), function ($join) {
                                $join->on ('users.id', '=', 'T4.causer_id' );
                             })             
                ->where('users.confirmed',"1")
                //->where('users.unsubscribed',"0")
                ->where('users.is_blacklist',"0")
                //->where('T2.updated_at',">", Carbon::now()->subMonths($lastMonth))
                ->where(function($query) use ($fromDate, $toDate){
                    $query->whereBetween('T2.updated_at', [$fromDate, $toDate])
                          ->orWhereBetween('T4.created_at', [$fromDate, $toDate]);
                  })
                ->whereNull('users.deleted_at')
                ->whereIn('users.panellist_id', $panelists)
                ->get();

        }else{
           /* return DB::table('users')
            ->select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at')
            ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
            ->leftJoin('user_projects','user_projects.user_id','=','users.id')
            ->where('users.confirmed',"1")
            ->where('users.unsubscribed',"0")
            ->where('users.is_blacklist',"0")
            ->where('user_projects.updated_at',">", Carbon::now()->subMonths(6))
            ->whereNull('users.deleted_at')
          //  ->whereNotNull('user_projects.status') 
            ->groupBy('user_projects.user_id')
            ->get();*/

            //return DB::table('users')
                return User::select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at','T2.updated_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
                ->leftJoin(DB::raw('(SELECT user_id,updated_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `user_id` order BY `updated_at` DESC)').' AS `row_num` FROM `user_projects` WHERE `status` IS NOT NULL)').' AS T1 WHERE T1.`row_num` = 1) as T2'), function ($join) {
                                $join->on ('users.id', '=', 'T2.user_id' );
                            })  
                ->leftJoin(DB::raw('(SELECT causer_id,created_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `causer_id` order BY `created_at` DESC)').' AS `row_num` FROM `activity_log`)').' AS T3 WHERE T3.`row_num` = 1) as T4'), function ($join) {
                                $join->on ('users.id', '=', 'T4.causer_id' );
                             })            
                ->where('users.confirmed',"1")
                //->where('users.unsubscribed',"0")
                ->where('users.is_blacklist',"0")
                //->where('T2.updated_at',">", Carbon::now()->subMonths($lastMonth))
                ->where(function($query) use ($fromDate, $toDate){
                    $query->whereBetween('T2.updated_at', [$fromDate, $toDate])
                          ->orWhereBetween('T4.created_at', [$fromDate, $toDate]);
                  })
                ->whereNull('users.deleted_at')
                ->get();

        }
       
        //return $roles;

        //echo "<pre>";print_r($data);die;
    }


public function getActiveUsersByPanelistId($panelist_id=null){

     return $activeUsers = User::with(['roles' => function ($q) {
                    $q->whereIn('role_id', ['4', '8']);}], 'permissions', 'providers')
                    ->select('users.id', 'users.email', 'users.locale', 'users.first_name', 'users.last_name', 'users.uuid', 'users.panellist_id', 'users.dob', 'users.gender', 'users.country', 'users.updated_at','users.password_changed_at','users.created_at','users.last_login_at','users.*',
                        DB::raw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age"),
                        DB::raw("(SELECT COUNT(*) FROM froud_users WHERE panellist_id = users.panellist_id) as froud_count"),
                        DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND description = 'inpanel.activity_log.log_in' ORDER BY updated_at DESC LIMIT 1) as last_login"),
                        DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND (description = 'inpanel.activity_log.registration' OR description = 'inpanel.activity_log.user_confirm') ORDER BY updated_at DESC LIMIT 1) as date_of_join"),
                        DB::raw("(SELECT CONCAT_WS(',', description) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities"),
                        DB::raw("(SELECT CONCAT_WS(',', properties) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as property"),
                        DB::raw("(SELECT max(updated_at) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities_date"),
                        DB::raw("(SELECT GROUP_CONCAT(project_id ORDER BY created_at DESC) FROM (SELECT project_id, created_at FROM froud_users WHERE panellist_id = users.panellist_id ORDER BY created_at DESC LIMIT 3) AS subquery) as project_ids"),
                        DB::raw("(SELECT max(updated_at) FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC) as survey_taken"),
                        DB::raw("(SELECT MAX(updated_at) FROM user_projects WHERE user_id = users.id AND status NOT IN (50, NULL) ORDER BY updated_at DESC) as survey_taken_date"),
                        DB::raw("(SELECT count(*) FROM user_projects WHERE user_id  = users.id AND status IS NOT NULL) as Total_survey_taken"),
                        DB::raw("(SELECT status FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC LIMIT 1) as survey_status"),
                        DB::raw("(SELECT channel_id FROM survey_reports WHERE uuid COLLATE utf8mb4_unicode_ci = users.uuid COLLATE utf8mb4_unicode_ci ORDER BY updatedOn DESC LIMIT 1) as channel_id"),
                        DB::raw("(SELECT count(*) FROM user_projects WHERE user_id = users.id AND status IN (1, 50)) as Total_survey_completed"),
                        DB::raw("(SELECT created_at FROM request_redeems WHERE user_uuid COLLATE utf8mb4_unicode_ci = users.uuid ORDER BY created_at DESC LIMIT 1) as redeem_request"),
                        DB::raw("(SELECT created_at FROM user_referral_codes WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1) as user_refer_date"),
                        DB::raw("(SELECT updated_at FROM support_chats WHERE user_id = users.id ORDER BY updated_at DESC LIMIT 1) as support_date"),
                        DB::raw("(SELECT updated_at FROM user_projects WHERE user_id = users.id AND status IN (1, 50) ORDER BY updated_at DESC LIMIT 1) as last_survey_completed_on")
                    )
                    ->active()
                    ->where('users.panellist_id', $panelist_id)
                    ->ORwhere('users.email_hash', sha1($panelist_id))
                    ->orderBy('users.created_at', 'desc')
                    ->paginate(10); 
 }

    public function getActiveUsers1($uuids=null,$panelists=null,$getAllUsersActiveInactive=null)
    {
        $getMonthLimit = Setting::where('key','=','PANEL_ACTIVE_MONTH_LIMIT')->first();
        $lastMonth = $getMonthLimit->value;
        $fromDate = now()->subMonths($lastMonth);
        $toDate   = now();
        
        if($uuids){
        //     return DB::table('users')
        //     ->select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at')
        //     ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
        //     ->leftJoin('user_projects','user_projects.user_id','=','users.id')
        //     ->where('users.confirmed',"1")
        //     ->where('users.unsubscribed',"0")
        //     ->where('users.is_blacklist',"0")
        //     ->where('user_projects.updated_at',">", Carbon::now()->subMonths(6))
        //     ->whereNull('users.deleted_at')
        //   //  ->whereNotNull('user_projects.status')
        //     ->whereIn('users.email', $emailids)
        //     ->groupBy('user_projects.user_id')
        //     ->get();

            //return DB::table('users')
            return User::select('users.id','users.uuid','users.locale','users.panellist_id','users.dob','users.gender','users.last_login_at','T2.updated_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
                ->leftJoin(DB::raw('(SELECT user_id,updated_at FROM '.DB::raw(
                    '(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `user_id` order BY `updated_at` DESC)').' AS `row_num` FROM `user_projects` WHERE `status` IS NOT NULL)').' AS T1 WHERE T1.`row_num` = 1) as T2'), function ($join) {
                                $join->on ('users.id', '=', 'T2.user_id' );
                            }) 
                ->leftJoin(DB::raw('(SELECT causer_id,created_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `causer_id` order BY `created_at` DESC)').' AS `row_num` FROM `activity_log`)').' AS T3 WHERE T3.`row_num` = 1) as T4'), function ($join) {
                                $join->on ('users.id', '=', 'T4.causer_id' );
                             })          
                ->where('users.confirmed',"1")
                //->where('users.unsubscribed',"0")
                ->where('users.is_blacklist',"0")
                //->where('T2.updated_at',">", Carbon::now()->subMonths($lastMonth))
                ->where(function($query) use ($fromDate, $toDate){
                    $query->whereBetween('T2.updated_at', [$fromDate, $toDate])
                          ->orWhereBetween('T4.created_at', [$fromDate, $toDate]);
                  })
                ->whereNull('users.deleted_at')
                ->whereIn('users.uuid', $uuids)
                ->orderBy('created_at', 'desc')
                ->get();

        }elseif($panelists){
        //     return DB::table('users')
        //     ->select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at')
        //     ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
        //     ->leftJoin('user_projects','user_projects.user_id','=','users.id')
        //     ->where('users.confirmed',"1")
        //     ->where('users.unsubscribed',"0")
        //     ->where('users.is_blacklist',"0")
        //     ->where('user_projects.updated_at',">", Carbon::now()->subMonths(6))
        //     ->whereNull('users.deleted_at')
        //   //  ->whereNotNull('user_projects.status')          
        //     ->whereIn('users.panellist_id', $panelists)
        //     ->groupBy('user_projects.user_id')
        //     ->get();

            //return DB::table('users')
                return User::select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at','T2.updated_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
                ->leftJoin(DB::raw('(SELECT user_id,updated_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `user_id` order BY `updated_at` DESC)').' AS `row_num` FROM `user_projects` WHERE `status` IS NOT NULL)').' AS T1 WHERE T1.`row_num` = 1) as T2'), function ($join) {
                                $join->on ('users.id', '=', 'T2.user_id' );
                            }) 
                ->leftJoin(DB::raw('(SELECT causer_id,created_at FROM '.DB::raw('(SELECT *, '.DB::raw('ROW_NUMBER() OVER(PARTITION BY `causer_id` order BY `created_at` DESC)').' AS `row_num` FROM `activity_log`)').' AS T3 WHERE T3.`row_num` = 1) as T4'), function ($join) {
                                $join->on ('users.id', '=', 'T4.causer_id' );
                             })             
                ->where('users.confirmed',"1")
                //->where('users.unsubscribed',"0")
                ->where('users.is_blacklist',"0")
                //->where('T2.updated_at',">", Carbon::now()->subMonths($lastMonth))
                ->where(function($query) use ($fromDate, $toDate){
                    $query->whereBetween('T2.updated_at', [$fromDate, $toDate])
                          ->orWhereBetween('T4.created_at', [$fromDate, $toDate]);
                  })
                ->whereNull('users.deleted_at')
                ->whereIn('users.panellist_id', $panelists)
                ->orderBy('created_at', 'desc')
                ->get();

        }elseif($getAllUsersActiveInactive && $getAllUsersActiveInactive == "allUsers"){
            return $activeUsers = User::with(['roles' => function ($q) {
                    $q->whereIn('role_id', ['4','8']);}], 'permissions', 'providers')
                    ->select('users.id', 'users.email', 'users.locale', 'users.first_name', 'users.last_name', 'users.uuid', 'users.panellist_id', 'users.dob', 'users.gender', 'users.country', 'users.updated_at','users.password_changed_at','users.created_at','users.last_login_at','users.*',
                        DB::raw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age"),
                        DB::raw("(SELECT COUNT(*) FROM froud_users WHERE panellist_id = users.panellist_id) as froud_count"),
                        DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND description = 'inpanel.activity_log.log_in' ORDER BY updated_at DESC LIMIT 1) as last_login"),
                        DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND (description = 'inpanel.activity_log.registration' OR description = 'inpanel.activity_log.user_confirm') ORDER BY updated_at DESC LIMIT 1) as date_of_join"),
                        DB::raw("(SELECT CONCAT_WS(',', description) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities"),
                        DB::raw("(SELECT CONCAT_WS(',', properties) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as property"),
                        DB::raw("(SELECT max(updated_at) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities_date"),
                        DB::raw("(SELECT GROUP_CONCAT(project_id ORDER BY created_at DESC) FROM (SELECT project_id, created_at FROM froud_users WHERE panellist_id = users.panellist_id ORDER BY created_at DESC LIMIT 3) AS subquery) as project_ids"),
                        DB::raw("(SELECT max(updated_at) FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC) as survey_taken"),
                        DB::raw("(SELECT MAX(updated_at) FROM user_projects WHERE user_id = users.id AND status NOT IN (50, NULL) ORDER BY updated_at DESC) as survey_taken_date"),
                        DB::raw("(SELECT count(*) FROM user_projects WHERE user_id  = users.id AND status IS NOT NULL) as Total_survey_taken"),
                        DB::raw("(SELECT status FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC LIMIT 1) as survey_status"),
                        DB::raw("(SELECT channel_id FROM survey_reports WHERE uuid COLLATE utf8mb4_unicode_ci = users.uuid COLLATE utf8mb4_unicode_ci ORDER BY updatedOn DESC LIMIT 1) as channel_id"),
                        DB::raw("(SELECT count(*) FROM user_projects WHERE user_id = users.id AND status IN (1, 50)) as Total_survey_completed"),
                        DB::raw("(SELECT created_at FROM request_redeems WHERE user_uuid COLLATE utf8mb4_unicode_ci = users.uuid ORDER BY created_at DESC LIMIT 1) as redeem_request"),
                        DB::raw("(SELECT created_at FROM user_referral_codes WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1) as user_refer_date"),
                        DB::raw("(SELECT updated_at FROM support_chats WHERE user_id = users.id ORDER BY updated_at DESC LIMIT 1) as support_date")
                    )
                    ->orderBy('users.created_at', 'desc')
                    ->get(); 
        }else{


           /* return DB::table('users')
            ->select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at')
            ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
            ->leftJoin('user_projects','user_projects.user_id','=','users.id')
            ->where('users.confirmed',"1")
            ->where('users.unsubscribed',"0")
            ->where('users.is_blacklist',"0")
            ->where('user_projects.updated_at',">", Carbon::now()->subMonths(6))
            ->whereNull('users.deleted_at')
          //  ->whereNotNull('user_projects.status') 
            ->groupBy('user_projects.user_id')
            ->get();*/

            //return DB::table('users')
            // echo "users.email";exit();
               /* $user= User::with(['roles' => function($q){
                $q->where('role_id', '4');
                }], 'permissions', 'providers')
                ->select('users.id', 'users.email' , 'users.first_name', 'users.last_name' ,'users.uuid','users.panellist_id','users.dob','users.gender','users.last_login_at')
                ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
               
                ->get();*/
                
                // return $activeUsers=user::with(['roles' => function($q){
                // $q->whereIn('role_id', ['4','8']);
                // }], 'permissions', 'providers')
                // ->active()
                // ->orderBy('created_at', 'desc')
                // ->get();

                return $activeUsers = User::with(['roles' => function ($q) {
                    $q->whereIn('role_id', ['4','8']);}], 'permissions', 'providers')
                    ->select('users.id', 'users.email', 'users.locale', 'users.first_name', 'users.last_name', 'users.uuid', 'users.panellist_id', 'users.dob', 'users.gender', 'users.country', 'users.updated_at','users.password_changed_at','users.created_at','users.last_login_at','users.*',
                        DB::raw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age"),
                        DB::raw("(SELECT COUNT(*) FROM froud_users WHERE panellist_id = users.panellist_id) as froud_count"),
                        DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND description = 'inpanel.activity_log.log_in' ORDER BY updated_at DESC LIMIT 1) as last_login"),
                        DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND (description = 'inpanel.activity_log.registration' OR description = 'inpanel.activity_log.user_confirm') ORDER BY updated_at DESC LIMIT 1) as date_of_join"),
                        DB::raw("(SELECT CONCAT_WS(',', description) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities"),
                        DB::raw("(SELECT CONCAT_WS(',', properties) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as property"),
                        DB::raw("(SELECT max(updated_at) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities_date"),
                        DB::raw("(SELECT GROUP_CONCAT(project_id ORDER BY created_at DESC) FROM (SELECT project_id, created_at FROM froud_users WHERE panellist_id = users.panellist_id ORDER BY created_at DESC LIMIT 3) AS subquery) as project_ids"),
                        DB::raw("(SELECT max(updated_at) FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC) as survey_taken"),
                        DB::raw("(SELECT MAX(updated_at) FROM user_projects WHERE user_id = users.id AND status NOT IN (50, NULL) ORDER BY updated_at DESC) as survey_taken_date"),
                        DB::raw("(SELECT count(*) FROM user_projects WHERE user_id  = users.id AND status IS NOT NULL) as Total_survey_taken"),
                        DB::raw("(SELECT status FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC LIMIT 1) as survey_status"),
                        DB::raw("(SELECT channel_id FROM survey_reports WHERE uuid COLLATE utf8mb4_unicode_ci = users.uuid COLLATE utf8mb4_unicode_ci ORDER BY updatedOn DESC LIMIT 1) as channel_id"),
                        DB::raw("(SELECT count(*) FROM user_projects WHERE user_id = users.id AND status IN (1, 50)) as Total_survey_completed"),
                        DB::raw("(SELECT created_at FROM request_redeems WHERE user_uuid COLLATE utf8mb4_unicode_ci = users.uuid ORDER BY created_at DESC LIMIT 1) as redeem_request"),
                        DB::raw("(SELECT created_at FROM user_referral_codes WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1) as user_refer_date"),
                        DB::raw("(SELECT updated_at FROM support_chats WHERE user_id = users.id ORDER BY updated_at DESC LIMIT 1) as support_date"),
                        DB::raw("(SELECT updated_at FROM user_projects WHERE user_id = users.id AND status IN (1, 50) ORDER BY updated_at DESC LIMIT 1) as last_survey_completed_on")
                    )
                    ->active()
                    ->orderBy('users.created_at', 'desc')

                    ->paginate(10);  

        }
        
        //return $roles;

        //echo "<pre>";print_r($data);die;
    }

    public function getActiveUsersForFraud($uuids=null,$panelists=null)
    {

        
        if($uuids){
            return DB::table('users')
            ->select('users.*','T1.fraudcount','T1.projectcode')
            ->leftJoin(DB::raw('(SELECT panellist_id, '.DB::raw('COUNT(panellist_id) as fraudcount').','.DB::raw('GROUP_CONCAT(project_id) as projectcode').' FROM froud_users GROUP BY (panellist_id)
                        ) as T1'), function ($join) {
                            $join->on ('users.panellist_id', '=', 'T1.panellist_id' );
                        })           
            ->where('users.confirmed',"1")
            //->where('users.unsubscribed',"0")
            //->where('users.is_blacklist',"0")
            ->whereNull('users.deleted_at')
            ->whereIn('users.uuid', $uuids)
            ->get();
        }elseif($panelists){
            return DB::table('users')
            ->select('users.*','T1.fraudcount','T1.projectcode')
            ->leftJoin(DB::raw('(SELECT panellist_id, '.DB::raw('COUNT(panellist_id) as fraudcount').','.DB::raw('GROUP_CONCAT(project_id) as projectcode').' FROM froud_users GROUP BY (panellist_id)
                        ) as T1'), function ($join) {
                            $join->on ('users.panellist_id', '=', 'T1.panellist_id' );
                        })
            ->where('users.confirmed',"1")
            //->where('users.unsubscribed',"0")
            //->where('users.is_blacklist',"0")
            ->whereNull('users.deleted_at')
            ->whereIn('users.panellist_id', $panelists)
            ->get();
        }else{
            
        //     return DB::table('users')
        //   //  ->select('users.id','users.uuid','users.panellist_id','users.dob','users.gender','froud_users.id')
        //     ->select("ANY_VALUE(users.uuid)", "ANY_VALUE(users.panellist_id)", "ANY_VALUE(users.gender)")
        //     ->selectRaw("COUNT(users.panellist_id) AS fraudcount")
        //    // ->selectRaw("COUNT(froud_users.id) AS fraudcount")
        //    // ->selectRaw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age")
        //     //->leftJoin('froud_users','froud_users.panelist_id','=','users.panellist_id')
        //     ->where('users.confirmed',"1")
        //     ->where('users.unsubscribed',"0")
        //    // ->where('users.is_blacklist',"0")
        //     ->whereNull('users.deleted_at')
        //     ->groupBy('users.panellist_id')
        //     ->get();

          return DB::table('users')

          ->select('users.id','users.uuid','users.panellist_id','users.panellist_id','users.email','users.dob','users.zipcode','users.locale','users.country','users.country_code','users.locale','T1.fraudcount','T1.projectcode')

          ->leftJoin(DB::raw('(SELECT panellist_id, '.DB::raw('COUNT(panellist_id) as fraudcount').','.DB::raw('GROUP_CONCAT(project_id) as projectcode').' FROM froud_users GROUP BY (panellist_id)
                      ) as T1 '), function ($join) {
                          $join->on ('users.panellist_id', '=', 'T1.panellist_id');
                      })  
            //->where('users.confirmed',"1")
            //->where('users.unsubscribed',"0")
           // ->where('users.is_blacklist',"0")
            ->whereNull('users.deleted_at')
            ->get();
        }
       
        //return $roles;

        //echo "<pre>";print_r($data);die;
    }

    public function getActiveUsersold()
    {
        
        return $this->model
            ->with(['roles' => function($q){
                $q->where('role_id', '4');
                }], 'permissions', 'providers')
            ->active()
            ->confirmed()
            ->get();
        //echo "<pre>";print_r($data);die;
    }
    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getInactivePaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->with('roles', 'permissions', 'providers')
            ->active(false)
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param int    $paged
     * @param string $orderBy
     * @param string $sort
     *
     * @return LengthAwarePaginator
     */
    public function getDeletedPaginated($paged = 25, $orderBy = 'created_at', $sort = 'desc') : LengthAwarePaginator
    {
        return $this->model
            ->with('roles', 'permissions', 'providers')
            ->onlyTrashed()
            ->orderBy($orderBy, $sort)
            ->paginate($paged);
    }

    /**
     * @param array $data
     *
     * @return User
     * @throws \Exception
     * @throws \Throwable
     */
    public function create(array $data) : User
    {
        return DB::transaction(function () use ($data) {
            $user = parent::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'active' => isset($data['active']) && $data['active'] == '1' ? 1 : 0,
                'confirmation_code' => md5(uniqid(mt_rand(), true)),
                'confirmed' => isset($data['confirmed']) && $data['confirmed'] == '1' ? 1 : 0,
            ]);

            // See if adding any additional permissions
            if (! isset($data['permissions']) || ! count($data['permissions'])) {
                $data['permissions'] = [];
            }

            if ($user) {
                // User must have at least one role
                if (! count($data['roles'])) {
                    throw new GeneralException(__('exceptions.backend.access.users.role_needed_create'));
                }

                // Add selected roles/permissions
                $user->syncRoles($data['roles']);
                $user->syncPermissions($data['permissions']);

                //Send confirmation email if requested and account approval is off
                if (isset($data['confirmation_email']) && $user->confirmed == 0 && ! config('access.users.requires_approval')) {
                    $user->notify(new UserNeedsConfirmation($user->confirmation_code));
                }

                event(new UserCreated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.create_error'));
        });
    }

    /**
     * @param User  $user
     * @param array $data
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function update(User $user, array $data) : User
    {

        $this->checkUserByEmail($user, $data['email']);

        // See if adding any additional permissions
        if (! isset($data['permissions']) || ! count($data['permissions'])) {
            $data['permissions'] = [];
        }

        return DB::transaction(function () use ($user, $data) {
            if ($user->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
            ])) {
                // Add selected roles/permissions
                $user->syncRoles($data['roles']);
                $user->syncPermissions($data['permissions']);

                event(new UserUpdated($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.update_error'));
        });
    }

    /**
     * @param User $user
     * @param      $input
     *
     * @return User
     * @throws GeneralException
     */
    public function updatePassword(User $user, $input) : User
    {
        if ($user->update(['password' => $input['password']])) {
            event(new UserPasswordChanged($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.update_password_error'));
    }

    /**
     * @param User $user
     * @param      $status
     *
     * @return User
     * @throws GeneralException
     */
    public function mark(User $user, $status) : User
    {
        if (auth()->id() == $user->id && $status == 0) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_deactivate_self'));
        }

        $user->active = $status;

        switch ($status) {
            case 0:
                event(new UserDeactivated($user));
            break;

            case 1:
                event(new UserReactivated($user));
            break;
        }

        if ($user->save()) {
            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.mark_error'));
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function confirm(User $user) : User
    {
        if ($user->confirmed) {
            throw new GeneralException(__('exceptions.backend.access.users.already_confirmed'));
        }

        $user->confirmed = 1;
        $confirmed = $user->save();

        if ($confirmed) {
            event(new UserConfirmed($user));

            // Let user know their account was approved
            if (config('access.users.requires_approval')) {
                $user->notify(new UserAccountActive);
            }

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.cant_confirm'));
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function unconfirm(User $user) : User
    {
        if (! $user->confirmed) {
            throw new GeneralException(__('exceptions.backend.access.users.not_confirmed'));
        }

        if ($user->id == 1) {
            // Cant un-confirm admin
            throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm_admin'));
        }

        if ($user->id == auth()->id()) {
            // Cant un-confirm self
            throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm_self'));
        }

        $user->confirmed = 0;
        $unconfirmed = $user->save();

        if ($unconfirmed) {
            event(new UserUnconfirmed($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.cant_unconfirm'));
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     * @throws \Exception
     * @throws \Throwable
     */
    public function forceDelete(User $user) : User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.delete_first'));
        }

        return DB::transaction(function () use ($user) {
            // Delete associated relationships
            $user->passwordHistories()->delete();
            $user->providers()->delete();
            $user->sessions()->delete();

            if ($user->forceDelete()) {
                event(new UserPermanentlyDeleted($user));

                return $user;
            }

            throw new GeneralException(__('exceptions.backend.access.users.delete_error'));
        });
    }

    /**
     * @param User $user
     *
     * @return User
     * @throws GeneralException
     */
    public function restore(User $user) : User
    {
        if (is_null($user->deleted_at)) {
            throw new GeneralException(__('exceptions.backend.access.users.cant_restore'));
        }

        if ($user->restore()) {
            event(new UserRestored($user));

            return $user;
        }

        throw new GeneralException(__('exceptions.backend.access.users.restore_error'));
    }

    /**
     * @param User $user
     * @param      $email
     *
     * @throws GeneralException
     */
    protected function checkUserByEmail(User $user, $email)
    {
        //Figure out if email is not the same
        if ($user->email != $email) {
            //Check to see if email exists
            if ($this->model->where('email', '=', $email)->first()) {
                throw new GeneralException(trans('exceptions.backend.access.users.email_error'));
            }
        }
    }

    public function getUserAnswersByUserIds($userIdsArray)
    {
        $userAnswers = UserAdditionalData::whereIn('uuid', $userIdsArray)->project([
            'uuid' => true,
            'u_id' => true,
            'user_answers' => true,

        ])->get();
        return $userAnswers;
    }

    public function getUseCompleteData($userid = null, $profile_sections = [], $countryCode, $userAddDataMap = [])
    {
        $exportData = [];
        $user = $userid ? $this->getById($userid) : $this->getById(auth()->id());
    
        $basicFields = [
            'panellist_id' => 'Panellist_Id',
            'dob' => 'DOB',
            'age' => 'Age',
            'zipcode' => 'Zipcode',
            'gender' => 'Gender',
            'device_preference' => 'Device_Preference'
        ];
    
        $get_user_Add_data = $userAddDataMap[$user->uuid] ?? null;
    
        if ($get_user_Add_data && $get_user_Add_data['user_answers']) {
            $locale = "en_" . $countryCode;
            $question_text = [];
    
            foreach ($get_user_Add_data['user_answers'] as $value) {
                if (!in_array($value['profile_section_code'], $profile_sections)) continue;
    
                $question_code = $value['profile_question_code'];
                $selectedAnswer = is_array($value['selected_answer'])
                    ? $value['selected_answer']
                    : explode(" ", $value['selected_answer']);
    
                $question_text[] = $this->getQuestionText(
                    $value['profile_section_code'],
                    $question_code,
                    $locale,
                    $selectedAnswer
                );
            }
    
            $exportData['Basic Profile'] = [];
    
            foreach ($question_text as $data) {
                foreach ($data as $key => $value) {
                    $basicFields[$key] = $value;
                }
            }
    
            foreach ($basicFields as $key => $value) {
                if ($key === 'dob' && !empty($user->$key)) {
                    $dob = is_string($user->$key) ? Carbon::parse($user->$key) : $user->$key;
                    $exportData['Basic Profile'][$value] = $dob->format('m-d-Y');
                } elseif ($key === 'age' && !empty($user->dob)) {
                    $exportData['Basic Profile'][$value] = Carbon::parse($user->dob)->age;
                } elseif ($key === 'device_preference') {
                    $exportData['Basic Profile'][$value] = $this->getDevicePreferenceName($user->device_preference);
                } elseif ($key === 'gender') {
                    $exportData['Basic Profile'][$value] = $this->getGender($user->gender);
                } elseif (!empty($user->$key)) {
                    $exportData['Basic Profile'][$value] = $user->$key;
                } else {
                    $exportData['Basic Profile'][$key] = $value;
                }
            }
    
            $exportData['Detailed Profile'] = [];
            return $exportData;
        }
    
        $exportData['Basic Profile'] = [];
        $exportData['Detailed Profile'] = [];
        return $exportData;
    }
    
    /**
     * This action is used for getting the User Question Details with their Answers.
     *
     * @param $fullName
     *
     * @return array
     */

    private function getQuestionText($profile_section_code,$question_code,$locale,$selected_answer)
    {
         $locale =explode('_',$locale);
        $country = $locale[1];
        $language = $locale[0];
        $sectionProjection = ProfileSection::getProjectionArray($country, strtoupper($language));
        $questionsProjection = ProfilerQuestions::getProjectionArray($country,strtoupper($language));
        //print_r($questionsProjection);
        $profile = ProfileSection::where('general_name', '=', $profile_section_code)->project($sectionProjection)->first();
        if($profile_section_code!=="BASIC" && $profile_section_code!=="HIDDEN"){
            $profileQuestion = ProfilerQuestions::where('profile_section_code', '=',$profile_section_code)
                ->where('general_name','=',$question_code)
                ->project($questionsProjection)
                ->first();

               
            $profile->questions = $profileQuestion;            
            $question_data = [];
            if(!empty($profileQuestion->translated)){
                foreach($profileQuestion->translated as $question){
                    //$question_text = $question['text'];
                    $question_text = $question_code;
                    $answer_text = [];
                    foreach($question['answers'] as $key=>$value){
                        if(in_array(@$value['precode'],$selected_answer)){
                            $answer_text[] = $value['display_name'];
                        }
                    }

                    $question_data[$question_text] = implode('|',$answer_text);
                }
            }
            
           // print_r($question_data);die;
           
        }elseif($profile_section_code=="BASIC"&& $profile_section_code!=="HIDDEN") {
            $profileQuestion = GlobalProfileQuestion::where('general_name','=',$question_code)
                ->project($questionsProjection)
                ->first();
            $profile->questions = $profileQuestion;
            
            $question_data = [];
            if(!empty($profileQuestion->translated)){
                foreach($profileQuestion->translated as $question){
                    //$question_text = $question['text'];
                    $question_text = $question_code;
                    $answer_text = [];
                    if($question['answers']) {
                        foreach ($question['answers'] as $key => $value) {
                            if (in_array($value['precode'], $selected_answer)) {
                                $answer_text[] = $value['display_name'];
                            }
                        }
                    } else {
                        $answer_text = $selected_answer;
                    }
                    $question_data[$question_text] = implode('|',$answer_text);
                }
            }
           
        } else {
            $question_text = $question_code;
            $answer_text[] = $selected_answer;
            $question_data[$question_text] = implode('|',$selected_answer);
        }
      // print_r($question_data);//die;
        return $question_data;
    }

    public function getDevicePreferenceName($devicePreference){
        $devicepreference = [];
        $deviceArray = explode(',',$devicePreference);
        if(in_array("1", $deviceArray)){
            $devicepreference[]="All Device";
        }else{
            foreach($deviceArray as $device){
                if($device==2){
                    $devicepreference[]="Desktop/Laptop";
                }else if($device==3){
                    $devicepreference[]="Mobile/Phone";
                }else if($device==4){
                    $devicepreference[]="Tablet";
                }
            }
        }
        
        return implode(',',$devicepreference);
    }

    public function getGender($gender) {
        if (Str::startsWith(strtolower($gender), 'm')) {
            $gender = "Male";
        } else {
            $gender = "Female";
        }

        return $gender;
    }
    
/*****
        Developer : Parshant Sharma 
        Date  : 05-03-2024
        This function is used to fetch the top three Panelist for LUCKY DRAW        
    *****/  
    public function getTopPanelists()
    {
 
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
 
        return $activeUsers = User::with(['roles' => function ($q) {
            $q->whereIn('role_id', ['4']);}], 'permissions', 'providers')
            ->select('users.id', 'users.email', 'users.locale', 'users.first_name', 'users.last_name', 'users.uuid', 'users.panellist_id', 'users.dob', 'users.gender', 'users.country', 'users.updated_at','users.password_changed_at','users.created_at','users.last_login_at','users.*',
                DB::raw("(SELECT count(*) FROM user_projects WHERE user_id = users.id AND status IS NOT NULL) as Total_survey_taken")
                //DB::raw("(SELECT count(*) FROM user_projects WHERE user_id = users.id AND created_at BETWEEN '{$currentMonthStart}' AND '{$currentMonthEnd}' AND status IS NOT NULL) as Total_survey_taken")
            )
            //->leftJoin('user_projects', 'user_projects.user_id', '=', 'users.id')
            ->active()
            ->orderBy('Total_survey_taken', 'desc')
            ->orderBy('users.created_at', 'desc') // Adding secondary order by clause if needed
            ->take(3)
            ->get();  
        //return $roles;
        //echo "<pre>";print_r($data);die;

    }  

	/*****
        Developer : Parshant Sharma 
        Date  : 13-06-2024
        This function is used to fetch the Survey Particiation for Real Panelist         
    *****/  
    
    // Code added by Vikas Dhull(Starting)
// public function getRealPanelists($fromDate = null, $toDate = null, $datePeriod = null, $country)
// {
//     $cntry = $country === "" ? "US" : $country;

//     // Step 1: Build base query WITHOUT users and user_projects joins
//     $query = DB::table('survey_reports')
//         ->select(
//             'survey_reports.uuid',
//             'survey_reports.project_code',
//             'survey_reports.survey_code',
//             'survey_reports.status',
//             'survey_reports.status_name',
//             'survey_reports.resp_status',
//             'survey_reports.resp_status_name',
//             'survey_reports.RespID',
//             'survey_reports.createdOn as started_at',
//             'survey_reports.cpi',
//             'survey_reports.channel_id',
//             'projects.cpi as proj_cpi'
//         )
//         ->leftJoin(DB::raw('projects'),
//             DB::raw('CONVERT(projects.apace_project_code USING utf8mb4)'),
//             '=',
//             DB::raw('CONVERT(survey_reports.project_code USING utf8mb4)')
//         )
//         ->where('survey_reports.country_code', $cntry)
//         ->orderBy('survey_reports.createdOn', 'desc')
//         ->groupBy(
//             'survey_reports.uuid',
//             'survey_reports.project_code',
//             'survey_reports.survey_code',
//             'survey_reports.status',
//             'survey_reports.status_name',
//             'survey_reports.resp_status',
//             'survey_reports.resp_status_name',
//             'survey_reports.RespID',
//             'survey_reports.createdOn',
//             'survey_reports.cpi',
//             'survey_reports.channel_id',
//             'projects.cpi'
//         );

//     // Step 2: Add date filter
//     if ($fromDate && $toDate) {
//         $query->whereBetween('survey_reports.createdOn', [
//             Carbon::parse($fromDate),
//             Carbon::parse($toDate)->endOfDay(),
//         ]);
//     } elseif ($datePeriod) {
//         $query->where('survey_reports.createdOn', '>=', $datePeriod);
//     }

//     // Step 3: Fetch main report data
//     $results = $query->get();
//     // Step 4: Fetch users using UUIDs directly from the result (without filtering)
//     // dd($results);
    
//     $users = User::withTrashed()->whereIn('uuid', $results->pluck('uuid')->toArray())->get()->keyBy('uuid');

//     // Step 5: Fetch project approval data
//     $userIds = $users->pluck('id', 'uuid')->filter();

//     $projectCodes = $results->pluck('project_code')->filter()->unique();

//     $userProjects = DB::table('user_projects')
//         ->select('user_id', 'apace_project_code', 'status')
//         ->whereIn('user_id', $userIds->values())
//         ->whereIn('apace_project_code', $projectCodes)
//         ->get()
//         ->groupBy(function ($item) {
//             return $item->user_id . '_' . $item->apace_project_code;
//         });

//     // Step 6: Attach user & project data to each record
//     foreach ($results as $record) {
//         $user = $users->get($record->uuid);

//         if ($user) {
//             try {
//                 $record->panelist_id = User::getPanelistsId($user->uuid);
//             } catch (\Throwable $e) {
//                 Log::warning('Failed to decrypt panelist_id', ['uuid' => $user->uuid]);
//                 $record->panelist_id = '';
//             }

//             $record->first_name = $user->first_name ?? '';
//             $record->unsubscribed = $user->unsubscribed ?? 0;
//             $record->is_blacklist = $user->is_blacklist ?? 0;
//             $record->deactivate = $user->active ?? null;
//             $record->deleted_at = $user->deleted_at ?? null;

//             $key = ($user->id ?? 'missing') . '_' . $record->project_code;
//             $record->approval_status = $userProjects[$key]->first()->status ?? null;
//         } else {
//             // Hard-deleted user
//             $record->panelist_id = '';
//             $record->first_name = '';
//             $record->unsubscribed = 0;
//             $record->is_blacklist = 0;
//             $record->deactivate = null;
//             $record->deleted_at = null;
//             $record->approval_status = null;
//         }
//     }
//     return $results;
// }


    // Code added by Vikas Dhull(Ending)
  
    public function getRealPanelists($fromDate = null, $toDate = null, $datePeriod = null, $country)
    {

          $cntry = $country === "" ? "US" : $country;
          //$cntry='IN';
         
                
        // Step 1: Build base query WITHOUT users and user_projects joins
        if($cntry == 'all'){
            $query = DB::table('survey_reports')
            ->select(
                'survey_reports.uuid',
                'survey_reports.project_code',
                'survey_reports.survey_code',
                'survey_reports.status',
                'survey_reports.status_name',
                'survey_reports.resp_status',
                'survey_reports.resp_status_name',
                'survey_reports.RespID',
                'survey_reports.createdOn as started_at',
                'survey_reports.cpi',
                'survey_reports.channel_id',
                'projects.cpi as proj_cpi'
            )
            ->leftJoin(DB::raw('projects'),
                DB::raw('CONVERT(projects.apace_project_code USING utf8mb4)'),
                '=',
                DB::raw('CONVERT(survey_reports.project_code USING utf8mb4)')
            )
            ->orderBy('survey_reports.createdOn', 'desc')
            ->groupBy(
                'survey_reports.uuid',
                'survey_reports.project_code',
                'survey_reports.survey_code',
                'survey_reports.status',
                'survey_reports.status_name',
                'survey_reports.resp_status',
                'survey_reports.resp_status_name',
                'survey_reports.RespID',
                'survey_reports.createdOn',
                'survey_reports.cpi',
                'survey_reports.channel_id',
                'projects.cpi'
            );
        } else {
            $query = DB::table('survey_reports')
                ->select(
                    'survey_reports.uuid',
                    'survey_reports.project_code',
                    'survey_reports.survey_code',
                    'survey_reports.status',
                    'survey_reports.status_name',
                    'survey_reports.resp_status',
                    'survey_reports.resp_status_name',
                    'survey_reports.RespID',
                    'survey_reports.createdOn as started_at',
                    'survey_reports.cpi',
                    'survey_reports.channel_id',
                    'projects.cpi as proj_cpi'
                )
                ->leftJoin(DB::raw('projects'),
                    DB::raw('CONVERT(projects.apace_project_code USING utf8mb4)'),
                    '=',
                    DB::raw('CONVERT(survey_reports.project_code USING utf8mb4)')
                )
                ->where('survey_reports.country_code', $cntry)
                ->orderBy('survey_reports.createdOn', 'desc')
                ->groupBy(
                    'survey_reports.uuid',
                    'survey_reports.project_code',
                    'survey_reports.survey_code',
                    'survey_reports.status',
                    'survey_reports.status_name',
                    'survey_reports.resp_status',
                    'survey_reports.resp_status_name',
                    'survey_reports.RespID',
                    'survey_reports.createdOn',
                    'survey_reports.cpi',
                    'survey_reports.channel_id',
                    'projects.cpi'
                );
        }
        // Step 2: Add date filter
        if ($fromDate && $toDate) {
            $query->whereBetween('survey_reports.createdOn', [
                Carbon::parse($fromDate),
                Carbon::parse($toDate)->endOfDay(),
            ]);
        } elseif ($datePeriod) {
            $query->where('survey_reports.createdOn', '>=', $datePeriod);
        }

        // Step 3: Fetch main report data
        $results = $query->get();
        // Step 4: Fetch users using UUIDs directly from the result (without filtering)
        // dd($results);
        
        $users = User::withTrashed()->whereIn('uuid', $results->pluck('uuid')->toArray())->get()->keyBy('uuid');

        // Step 5: Fetch project approval data
        $userIds = $users->pluck('id', 'uuid')->filter();

        $projectCodes = $results->pluck('project_code')->filter()->unique();

        $userProjects = DB::table('user_projects')
            ->select('user_id', 'apace_project_code', 'status')
            ->whereIn('user_id', $userIds->values())
            ->whereIn('apace_project_code', $projectCodes)
            ->whereNotNull('status')
            ->get()
            ->groupBy(function ($item) {
                return $item->user_id . '_' . $item->apace_project_code;
            });

        $platforms = DB::table('user_platform_actions')
            ->select('user_uuid', 'action_id', 'platform')
            ->where('action_type', 'survey_participation')
            ->whereIn('user_uuid', $results->pluck('uuid')->toArray())
            ->whereIn('action_id', $projectCodes)
            ->get()
            ->keyBy(function ($item) {
                return $item->user_uuid . '_' . $item->action_id;
            });
           
        // Step 6: Attach user & project data to each record
        foreach ($results as $record) {
            $user = $users->get($record->uuid);

            if ($user) {
                try {
                    $panelistId = User::getPanelistsId($user->uuid);
                    $record->panelist_id = $panelistId;
                } catch (\Throwable $e) {
                    \Log::warning('Failed to decrypt panelist_id', ['uuid' => $user->uuid]);
                    $record->panelist_id = '';
                }

                $record->first_name = $user->first_name ?? '';
                $record->unsubscribed = ($user->unsubscribed == 1) ? 'Yes' : 'No';
                $record->is_blacklist = $user->is_blacklist ? 'Yes' : 'No';
                $record->deactivate = ($user->active == 0) ? 'Yes' : 'No';
                $record->deleted_at = $user->deleted_at ? 'Yes' : 'No';
                $key = ($user->id ?? 'missing') . '_' . $record->project_code;
               if($userProjects->has($key)) {

                $record->approval_status = $userProjects[$key]->first()->status ?? null;
                }else{
                   $record->approval_status =null; 
                }
                $platformKey = $record->uuid . '_' . $record->project_code;
                $platformRecord = $platforms->get($platformKey);
                
                $record->device_type = $platformRecord && $platformRecord->platform
                ? ucfirst(strtolower($platformRecord->platform))
                : '-';
            } else {
                // Hard-deleted user
                $record->panelist_id = '';
                $record->first_name = '';
                $record->unsubscribed = 'No';
                $record->is_blacklist = 'No';
                $record->deactivate = 'No';
                $record->deleted_at = 'Yes';
                $record->approval_status = '';
                $record->device_type = '-';
            }

        }
   
        /* $activeUsers = User::whereHas('roles',function($query){$query->where('id',4);})
            ->select('users.uuid', 'users.uuid', 'users.panellist_id','users.first_name','survey_reports.project_code','survey_reports.survey_code','survey_reports.status_name','survey_reports.resp_status','survey_reports.resp_status_name','survey_reports.started_at')
            //->leftJoin('survey_reports', 'survey_reports.uuid', '=', 'users.uuid')
            ->leftJoin('survey_reports', DB::raw('CONVERT(survey_reports.uuid USING utf8mb4)'), '=', DB::raw('CONVERT(users.uuid USING utf8mb4)'))
            ->active()
            ->orderBy('survey_reports.createdOn', 'desc') // Adding secondary order by clause if needed
            //->take(3)
            ->confirmed()
            ->get(); */  
        
        return $results;

    }
	/**
     * Function Name : fetch Users by search
     * Created by : Priyanka(11-june-2024)
     **/
   public function getFilterUsers($post=null)
   {
        $dateLimit = "";
        $dateTimeLimit="";
        $dateTimeLimitChannel="";
        $startDate="";
        $endDate="";
        $post=1;
        if ($post) {
            //$startDate = $post['fromDate'];

            //$endDate = $post['toDate'];
              $startDate = '2025-10-01';

             $endDate = '2025-10-31';

            $dateLimit = "  updated_at >= '".$startDate."' AND updated_at <= '".$endDate."'";
            $dateTimeLimit = "  updated_at >= '".$startDate." 00:00:00' AND updated_at <= '".$endDate." 23:59:59'"; 
            $dateTimeLimitChannel = "  updatedOn >= '".$startDate." 00:00:00' AND updatedOn <= '".$endDate." 23:59:59'"; 
        }


         $activeUsers = User::query()
                    ->select(
                        'users.id',
                        'users.uuid',
                        'users.panellist_id',
                        'users.gender',
                        'users.zipcode',
                        'users.country',
                        'users.locale',
                        'users.country_code',
                        'users.email',
                        'users.first_name',
                        'users.last_name',
                        'users.dob',
                        'users.created_at',
                        'users.updated_at',
                        DB::raw("TIMESTAMPDIFF(YEAR, DATE(users.dob), CURDATE()) AS age"),
                        'profile_log.profile_filled',
                        'last_login_log.last_login',
                        'survey_data.Total_survey_taken',
                        'survey_data.survey_status',
                        'survey_data.Total_survey_completed',
                        'unsubscribe_log.unsubscribed_on'
                    )
                    ->whereHas('roles', function ($query) {
                        $query->where('id', 4);
                    });

                // Profile filled subquery
                $profileFilledSub = DB::table('activity_log')
                    ->select('causer_id', DB::raw('COUNT(*) as profile_filled'))
                    ->where('log_name', 'default')
                    ->where('description', 'like', '%inpanel.activity_log.profile%')
                    ->whereRaw($dateTimeLimit) // your $dateTimeLimit string should be safe
                    ->groupBy('causer_id');

                $activeUsers->leftJoinSub($profileFilledSub, 'profile_log', function ($join) {
                    $join->on('profile_log.causer_id', '=', 'users.id');
                });

                // Last login subquery
                $lastLoginSub = DB::table('activity_log')
                    ->select('causer_id', DB::raw('MAX(updated_at) as last_login'))
                    ->where('description', 'inpanel.activity_log.log_in')
                    ->whereRaw($dateTimeLimit)
                    ->groupBy('causer_id');

                $activeUsers->leftJoinSub($lastLoginSub, 'last_login_log', function ($join) {
                    $join->on('last_login_log.causer_id', '=', 'users.id');
                });

                // Survey data subquery
                $surveySub = DB::table('user_projects')
                    ->select(
                        'user_id',
                        DB::raw("COUNT(CASE WHEN status IS NOT NULL THEN 1 END) as Total_survey_taken"),
                        DB::raw("MAX(status) as survey_status"),
                        DB::raw("COUNT(CASE WHEN status IN (1, 50) THEN 1 END) as Total_survey_completed")
                    )
                    ->whereRaw($dateTimeLimit)
                    ->groupBy('user_id');

                $activeUsers->leftJoinSub($surveySub, 'survey_data', function ($join) {
                    $join->on('survey_data.user_id', '=', 'users.id');
                });

                // Unsubscribe subquery
                $unsubSub = DB::table('user_unsubscribes')
                    ->select(
                        DB::raw('SHA1(email) as hashed_email'),
                        DB::raw('MAX(created_at) as unsubscribed_on')
                    )
                    ->groupBy('hashed_email');

                $activeUsers->leftJoinSub($unsubSub, 'unsubscribe_log', function ($join) {
                    $join->on('unsubscribe_log.hashed_email', '=', 'users.email_hash');
                });

                // Optional filter by updated_at or survey activity
                if ($post) {
                    $activeUsers->leftJoin('user_projects', 'user_projects.user_id', '=', 'users.id'); // Only if not already joined
                    $activeUsers->where(function ($q) use ($startDate, $endDate) {
                        $q->whereBetween(DB::raw('DATE(users.updated_at)'), [$startDate, $endDate])
                          ->orWhereBetween(DB::raw('DATE(user_projects.updated_at)'), [$startDate, $endDate]);
                    });
                }


                $MonthlyAward = $activeUsers
                    ->groupBy('users.id')
                    ->orderBy('users.created_at', 'desc')
                    ->get();

       return $MonthlyAward;
	   
		/* $users = User::select([
				'users.id',
				'users.email',
				'users.locale',
				'users.first_name',
				'users.last_name',
				'users.uuid',
				'users.panellist_id',
				'users.dob',
				'users.gender',
				'users.country',
				'users.updated_at',
				'users.password_changed_at',
				'users.created_at',
				'users.last_login_at',
				'users.*',
				DB::raw('TIMESTAMPDIFF(YEAR, users.dob, CURDATE()) AS age'),

				// Profile filled count
				DB::raw("(SELECT COUNT(*) 
						  FROM activity_log 
						  WHERE causer_id = users.id 
							AND log_name = 'default' 
							AND description LIKE '%inpanel.activity_log.profile%' 
							AND updated_at BETWEEN '{$startDate}' AND '{$endDate}') AS profile_filled"),

				// Unsubscribe date
				DB::raw("(SELECT created_at 
						  FROM user_unsubscribes 
						  WHERE SHA1(user_unsubscribes.email) = SHA1(users.email) 
						  ORDER BY id DESC 
						  LIMIT 1) AS unsubscribed_on"),

				// Last login in the period
				DB::raw("(SELECT updated_at 
						  FROM activity_log 
						  WHERE causer_id = users.id 
							AND description = 'inpanel.activity_log.log_in' 
							AND updated_at BETWEEN '{$startDate}' AND '{$endDate}' 
						  ORDER BY updated_at DESC 
						  LIMIT 1) AS last_login"),

				// Activities in the period
				DB::raw("(SELECT GROUP_CONCAT(DISTINCT description ORDER BY updated_at DESC) 
						  FROM activity_log 
						  WHERE causer_id = users.id) AS Activities"),

				// Most recent survey taken
				DB::raw("(SELECT MAX(updated_at) 
						  FROM user_projects 
						  WHERE user_id = users.id 
							AND status IS NOT NULL 
							AND updated_at BETWEEN '{$startDate}' AND '{$endDate}') AS survey_taken"),

				// Latest channel ID for surveys
				DB::raw("(SELECT channel_id 
						  FROM survey_reports 
						  WHERE uuid = users.uuid 
							AND updatedOn BETWEEN '{$startDate}' AND '{$endDate}' 
						  ORDER BY updatedOn DESC 
						  LIMIT 1) AS channel_id"),

				// Total surveys taken in the period
				DB::raw("(SELECT COUNT(*) 
						  FROM user_projects 
						  WHERE user_id = users.id 
							AND status IS NOT NULL 
							AND updated_at BETWEEN '{$startDate}' AND '{$endDate}') AS Total_survey_taken"),

				// Latest survey status
				DB::raw("(SELECT status 
						  FROM user_projects 
						  WHERE user_id = users.id 
							AND status IS NOT NULL 
							AND updated_at BETWEEN '{$startDate}' AND '{$endDate}' 
						  ORDER BY updated_at DESC 
						  LIMIT 1) AS survey_status"),

				// Total completed surveys
				DB::raw("(SELECT COUNT(*) 
						  FROM user_projects 
						  WHERE user_id = users.id 
							AND status IN (1, 50) 
							AND updated_at BETWEEN '{$startDate}' AND '{$endDate}') AS Total_survey_completed"),

				// Last completed survey date
				DB::raw("(SELECT MAX(updated_at) 
						  FROM user_projects 
						  WHERE user_id = users.id 
							AND status IN (1, 50) 
							AND updated_at BETWEEN '{$startDate}' AND '{$endDate}') AS last_survey_completed_on"),
			])
			->leftJoin('user_projects', 'user_projects.user_id', '=', 'users.id')
			->whereHas('roles', function ($query) {
				$query->where('roles.id', 4);
			})
			->where('users.active', 1)
			->whereNull('users.deleted_at')
			->where(function($query) use ($startDate, $endDate) {
				$query->whereBetween(DB::raw('DATE(users.updated_at)'), [$startDate, $endDate])
					  ->orWhereBetween(DB::raw('DATE(user_projects.updated_at)'), [$startDate, $endDate]);
			})
			->groupBy('users.id')
			->orderByDesc('users.created_at')
			->get(); */	   
			   
	   
	   


   }
   
   
	/**
     * Function Name : 
     * Created by : Priyanka(11-june-2024)
     **/   
   public function getFeasibilePanelist($data = null)
   {
        // Enable query logging
        DB::enableQueryLog();
       // Build your query using Eloquent or Query Builder
       $activeUsersQuery = User::whereHas('roles', function ($query) {
           $query->where('id', 4); // Adjust 'id' condition according to your needs
       })
       ->select('users.id', 'users.email', 'users.locale', 'users.first_name', 'users.last_name', 'users.uuid', 'users.panellist_id', 'users.dob', 'users.gender', 'users.country', 'users.created_at', 'users.last_login_at','users.confirmed',DB::raw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age"))
       ->active();
 
       // Apply conditions based on $data array
       if ($data && is_array($data)) {
           if (!empty($data['u_id']) && is_array($data['u_id'])) {
               $activeUsersQuery->whereIn('id', $data['u_id']);
           }
           if (isset($data['country_code'])) {
               $activeUsersQuery->where('country', $data['country_code']);
           }
           if (isset($data['device'])) {
               $activeUsersQuery->whereIn('device_preference', $data['device']);
               //$activeUsersQuery->where('device_preference', 'like', '%' . $data['device'] . '%');
           }
           if (isset($data['local'])) {
               $activeUsersQuery->where('locale', $data['local']);
           }
       }
       $activeUsersQuery = $activeUsersQuery->orderBy('users.created_at', 'desc')->get();
       /*$queries = DB::getQueryLog();
       $lastQuery = end($queries)['query'];
       $bindings = end($queries)['bindings'];
       echo "Last Query: " . $lastQuery . "\n";
       echo "Bindings: " . json_encode($bindings) . "\n";exit*/;
       return $activeUsersQuery;


   }
   
    public function getCountry($country_code)
    {
		dd($country_code);
        $lang = [];
        $country_data = CountryTrans::where('country_code','=',$country_code)->first();
        if($country_data){
            $con_lang = array_column($country_data['translation'], 'con-lang');
            foreach ($country_data['translation'] as $trans){
                $lang_data = explode('-', $trans['con-lang']);
                $lang[$lang_data[1]] = $trans['language_name'];
            }
        }
        return $lang;
    }

    /*****
        Developer : Vikas Dhull 
        Date  : 04-03-2025
        This function is used to fetch the All data of completed and attempted surveys for Real Panelist         
    *****/  
    public function getRealPanelistsAttemptedCompletedSurveys($fromDate = null, $toDate = null, $datePeriod = null, $country = null)
    {
        if ($fromDate && $toDate) {
            $date = Carbon::parse($toDate)->endOfDay();
            $surveyQuery = User::whereHas('roles', function ($query) {
                    $query->where('id', 4);
                })
                ->leftJoin('survey_reports', DB::raw('CONVERT(survey_reports.uuid USING utf8mb4)'), '=', DB::raw('CONVERT(users.uuid USING utf8mb4)'))
                ->leftJoin('projects', DB::raw('CONVERT(projects.apace_project_code USING utf8mb4)'), '=', DB::raw('CONVERT(survey_reports.project_code USING utf8mb4)'))
                ->active()
                ->whereBetween('survey_reports.createdOn', [Carbon::parse($fromDate), $date])
                ->confirmed()
                ->distinct();
        } else {
            $surveyQuery = User::whereHas('roles', function ($query) {
                    $query->where('id', 4);
                })
                ->leftJoin('survey_reports', DB::raw('CONVERT(survey_reports.uuid USING utf8mb4)'), '=', DB::raw('CONVERT(users.uuid USING utf8mb4)'))
                ->leftJoin('projects', DB::raw('CONVERT(projects.apace_project_code USING utf8mb4)'), '=', DB::raw('CONVERT(survey_reports.project_code USING utf8mb4)'))
                ->active()
                ->where('survey_reports.createdOn', '>=', $datePeriod)
                ->orderBy('survey_reports.started_at', 'desc')
                ->confirmed()
                ->distinct();
        }
 
        if (!empty($country)) {
            $surveyQuery->where('users.country', $country);
        }
        // Total Attempted Surveys
        $totalAttemptedSurveys = $surveyQuery->count();
        // Total Completed Surveys (`resp_status = 1`)
        $totalCompletedSurveys = (clone $surveyQuery)->where('survey_reports.resp_status', 1)->count();
        return [
            'totalAttemptedSurveys' => $totalAttemptedSurveys,
            'totalCompletedSurveys' => $totalCompletedSurveys
        ];
    }
	
}