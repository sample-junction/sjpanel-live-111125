<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Models\Auth\User;
use App\Models\Auth\PanellistAddress;
use App\Models\Auth\Role;
use App\Models\Auth\FroudUsers;
use App\Models\Report\SurveyReport;
use App\Models\Report\SurveyStartCount;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Profiler\ProfilerQuestions;
use App\Mail\Backend\FraudInformation\FraudInformationEmail;
use App\Mail\Backend\FraudInformation\BlacklistInformationEmail;
use App\Repositories\Inpanel\Profiler\DetailedProfileRepository;
use App\Models\Redeem\RequestRedeem;
use App\Http\Controllers\Controller;
use App\Events\Backend\Auth\User\UserDeleted;
use App\Repositories\Backend\Auth\RoleRepository;
use App\Repositories\Backend\Auth\UserRepository;
use App\Repositories\Backend\Auth\PermissionRepository;
use App\Http\Requests\Backend\Auth\User\StoreUserRequest;
use App\Http\Requests\Backend\Auth\User\ManageUserRequest;
use App\Http\Requests\Backend\Auth\User\UpdateUserRequest;
use Freshbitsweb\Laratables\Laratables;
use Illuminate\Http\Request;
use anlutro\LaravelSettings\SettingStore as Setting;
use Carbon\Carbon;
use App\Repositories\Inpanel\Traffic\TrafficRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Response;
use App\Models\Setting\Setting as settings;
use Illuminate\Support\Facades\Config;
use App\Mail\Frontend\UserConfirm\UserConfirmation;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\App;
use DB;
use App\Models\Affiliate\AffiliateCampaignData;
use Illuminate\Support\Facades\Cache;
use App\Jobs\DoiRemainderAllEmail;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Traffics\Traffic;
use MongoDB\BSON\UTCDateTime;
use App\Models\Project\ProjectQuota;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
use App\Mail\Inpanel\UserProject\SurveyTestInvite;



/**
 * Class UserController.
 */
class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        TrafficRepository $trafficRepo,
        DetailedProfileRepository $detailedProfileRepo,
        CountriesCurrenciesRepository $countriesCurrenciesRepository
    ) {
        $this->userRepository = $userRepository;
        $this->trafficRepo = $trafficRepo;
        $this->detailedProfileRepo = $detailedProfileRepo;
        $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
    }


    /**
     * @param ManageUserRequest $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ManageUserRequest $request)
    {


        /*dd($this->userRepository->getActivePaginated(25, 'id', 'asc'));*/
        /*$users = $this->userRepository->getUsers();*/
        // echo "<pre>";
        // print_r(count($this->userRepository->getUsers()));exit();

        $user = auth()->user();

        /*$Panthera = AffiliateCampaignData::whereIn("medium", ["PANT","NEGM","LESC"])->get();
        $data = [];
        foreach ($Panthera as $affiliate) {
            $data[$affiliate->user_id] = $affiliate->medium;
        }*/

        $data = AffiliateCampaignData::whereIn('medium', ["PANT", "NEGM", "LESC"])
            ->select('user_id', 'medium')
            ->get()
            ->pluck('medium', 'user_id')
            ->toArray();

        $invite_emails = DB::table("invite_campaigns")
            ->where("email_sent", 1)
            ->pluck("email")
            ->toArray();
        $invite_emails = array_map("strtolower", $invite_emails);
        //print_r($invite_emails);
        //exit;
        // echo '<pre>';
        // print_r($user->roles[0]->name);die;



        /*if(empty($request->get('id'))){

            return view("backend.auth.user.index")
            ->with("affiliate", $data)
            ->with("invite_emails", $invite_emails)
            ->withUsers($this->userRepository->getActiveUsers1());
        }else{
            return view("backend.auth.user.index")
            ->with("affiliate", $data)
            ->with("invite_emails", $invite_emails)
            ->withUsers($this->userRepository->getActiveUsersByPanelistId($request->get('id')));

        }*/

        $users = null;
        if (!empty($request->get('id'))) {
            $users = $this->userRepository->getActiveUsersByPanelistId($request->get('id'));
        } else {
            $users = $this->userRepository->getActiveUsers1();
        }
        return view("backend.auth.user.index")
            ->with("affiliate", $data)
            ->with("invite_emails", $invite_emails)
            ->withUsers($users);
    }

    //Function Added By Ramesh Kamboj//
    public function surveyReport()
    {
        $survey_report = DB::table("projects")
            ->select(
                "apace_project_code",
                "country_code",
                "created_at",
                "updated_at",
                "survey_status_code"
            )
            ->orderBy("id", "desc")
            ->get();

        // print_r(count($survey_report));die;

        return view("backend.auth.user.new_survey-report")->with(
            "survey_report",
            $survey_report
        );
    }
    //End Here

    public function reportincentive(ManageUserRequest $request)
    {
        $fromDate = $request->get("fromDate");
        $toDate = $request->get("toDate");
        $searchType = $request->input("searchType");

        if (!empty($fromDate) && !empty($toDate)) {
            /* $get_redeem_data = \DB::table('users')        
                        ->select('users.panellist_id', 'table1.user_uuid','table1.earned_points')
                        ->rightJoin(\DB::raw('(SELECT '.\DB::raw('SUM(redeem_points) as earned_points').' ,user_uuid FROM request_redeems WHERE status = "completed" GROUP BY user_uuid
                                    ) as table1'), function ($join) {
                                        $join->on ('users.uuid', '=', 'table1.user_uuid' );
                                    })
                        ->whereBetween('users.updated_at', [$fromDate, $toDate])
                        ->get();*/

            $get_redeem_data = UserAdditionalData::whereBetween("created_at", [
                Carbon::parse($fromDate),
                Carbon::parse($toDate),
            ])->get();
        } elseif (!empty($searchType)) {
            /* $query = \DB::table('users')        
                        ->select('users.panellist_id', 'table1.user_uuid','table1.earned_points')
                        ->rightJoin(\DB::raw('(SELECT '.\DB::raw('SUM(redeem_points) as earned_points').' ,user_uuid FROM request_redeems WHERE status = "completed" GROUP BY user_uuid
                        ) as table1'), function ($join) {
                            $join->on ('users.uuid', '=', 'table1.user_uuid' );
                        });
                if($searchType == "emailid"){
                    $emailids = explode(',',$request->input('userids'));
                    $query->whereIn('users.email', $emailids);
                    
                }
                        
                if($searchType == "panelists_id"){
                    $panelists_ids = explode(',',$request->input('userids'));
                    $query->whereIn('users.panellist_id', $panelists_ids);
                }
                
            $get_redeem_data = $query->get();*/

            if ($searchType == "uuid") {
                $uuids = explode(",", $request->input("userids"));
                $get_redeem_data = UserAdditionalData::whereIn(
                    "uuid",
                    $uuids
                )->get();
            }
        } else {
            /*$get_redeem_data = \DB::table('users')        
                        ->select('users.panellist_id', 'table1.user_uuid','table1.earned_points')
                        ->rightJoin(\DB::raw('(SELECT user_uuid, '.\DB::raw('SUM(redeem_points) as earned_points').' FROM request_redeems WHERE status = "completed" GROUP BY user_uuid
                                    ) as table1'), function ($join) {
                                        $join->on ('users.uuid', '=', 'table1.user_uuid' );
                                    })
                        ->get();*/

            $get_redeem_data = UserAdditionalData::get();
        }

        foreach ($get_redeem_data as $data) {
            $user = User::where('uuid', $data->uuid)->first();

            if ($user) {
                $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale ?? 'US');
                $data->countryPoints = $countryPoint->points ?? 1000;
                $data->currencies = [
                    'currency_logo' => $countryPoint->currency_symbols ?? '$',
                    'currency_denom_singular' => 'cent',
                    'currency_denom_plural' => 'cents',
                ];
            } else {
                $data->countryPoints = 1000;
                $data->currencies = [
                    'currency_logo' => '$',
                    'currency_denom_singular' => 'cent',
                    'currency_denom_plural' => 'cents',
                ];
            }
        }

        /*echo '<pre>';
        foreach($get_redeem_data as $result){
            echo $result->user_points['completed'].'<br>';
            echo $result->user_points['redeemed_points'];
        }
        die;*/

        // print_r($get_redeem_data);die;
        return view("backend.auth.user.reports-incentive")->with(
            "get_redeem_data",
            $get_redeem_data
        );
    }

    public function reportactive(ManageUserRequest $request)
    {
        //print_r(Carbon::now()->subMonths(6));die;
        //Carbon::parse($user->dob)->age;
        $modifiedActiveUsers = [];

        if ($request->input()) {
            $searchType = $request->input("searchType");
            if ($searchType == "uuid") {
                $uuids = explode(",", $request->input("userids"));
                $activeUsers = $this->userRepository->getActiveUsers($uuids);
            } elseif ($searchType == "panelists_id") {
                $panelists_ids = explode(",", $request->input("userids"));
                $activeUsers = $this->userRepository->getActiveUsers(
                    null,
                    $panelists_ids
                );
            }
        } else {
            $activeUsers = $this->userRepository->getActiveUsers();
        }

        return view("backend.auth.user.reports-active")->with(
            "activeUsers",
            $activeUsers
        );
    }

    public function reportrejection(ManageUserRequest $request)
    {
        /*$froudUsers =  FroudUsers::get();
       echo '<pre>';
       print_r($froudUsers); die;*/

        $fromDate = $request->get("fromDate");
        $toDate = $request->get("toDate");
        if (!empty($fromDate) && !empty($toDate)) {
            $trafficRejectionData = $this->trafficRepo->getTrafficsStatsRejected(
                $fromDate,
                $toDate
            );
        } else {
            $trafficRejectionData = $this->trafficRepo->getTrafficsStatsRejected();
        }

        //print_r($trafficRejectionData);die;

        return view("backend.auth.user.reports-rejection")->with(
            "trafficRejectionData",
            $trafficRejectionData
        );
    }

    public function panelResponse(ManageUserRequest $request)
    {
        //$api_url = "https://test3.sjpanel.com";

        $timePeriod = $request->get("timeperiod");
        $fromDate = $request->get("fromDate");
        $toDate = $request->get("toDate");
        $selectPeriod = true;
        $country = $request->get("country") ? $request->get("country") : "";


        //$fromLastDay = config('app.update_response_rate.days');

        if (!empty($fromDate) && !empty($toDate)) {
            $selectPeriod = false;
        } elseif (!empty($timePeriod)) {
            $timePeriod = $timePeriod;
        } else {
            $timePeriod = 30;
        }

        if ($selectPeriod) {
            $fromLastDays = Carbon::now()->subDays($timePeriod)->startOfDay();
            $fromDate = Carbon::now('UTC')->subDays($timePeriod)->startOfDay();
            $filterDate = new UTCDateTime($fromDate->getTimestamp() * 1000);
            // dd($filterDate->toDateTime()->format('Y-m-d H:i:s'));

            // $query = \DB::table('user_projects')

            //     ->whereNotNull('status')
            //     ->where('status', '!=', 0)
            //     ->where('updated_at', '>=', $fromLastDays);
            $query = Traffic::where('source_code', 'SJPL')
                ->where(function ($q) {
                    $q->where('channel_id', '2')
                        ->orWhere('channel_id', 2);
                })
                ->where('updated_at', '>=', $filterDate);

            if (!empty($country)) {
                $query->where('country_code', '=', $country);
            }
            $trafficStats = $query->count();

            $invite_sent_details = \DB::table("invite_sent_details")
                ->join("projects", "invite_sent_details.project_id", "=", "projects.id")
                ->select(
                    \DB::raw("SUM(reminder) as rcnt"),
                    \DB::raw("SUM(invitecnt) as icnt"),
                    \DB::raw("SUM(surveycnt) as scnt")
                )
                ->where(function ($query) use ($fromLastDays) {
                    $query->where("invite_sent_details.created_at", ">=", $fromLastDays)
                        ->orWhere("invite_sent_details.updated_at", ">=", $fromLastDays);
                })
                ->when(!empty($country), function ($query) use ($country) {
                    $query->where("projects.country_code", $country);
                })
                ->first();
        } else {
            // $trafficStats = $this->trafficRepo->getTrafficsStatsByDateRange(
            //     $fromDate,
            //     $toDate
            // );
            // $query = \DB::table('user_projects')
            //     ->whereNotNull('status')
            //     ->where('status', '!=', 0)
            //     ->whereBetween('updated_at', [$fromDate, $toDate]);
            $fromDate = Carbon::parse($fromDate);
            $toDate = Carbon::parse($toDate);
            $fromMongoDate = new UTCDateTime($fromDate->getTimestamp() * 1000);
            $toMongoDate = new UTCDateTime($toDate->getTimestamp() * 1000);

            $query = Traffic::where('source_code', 'SJPL')
                ->where(function ($q) {
                    $q->where('channel_id', '2')
                        ->orWhere('channel_id', 2);
                })
                ->whereBetween('updated_at', [$fromMongoDate, $toMongoDate]);

            if (!empty($country)) {
                $query->where('country_code', $country);
            }

            $trafficStats = $query->count();

            $invite_sent_details = \DB::table("invite_sent_details")
                ->join("projects", "invite_sent_details.project_id", "=", "projects.id")
                ->select(
                    \DB::raw("SUM(reminder) as rcnt"),
                    \DB::raw("SUM(invitecnt) as icnt"),
                    \DB::raw("SUM(surveycnt) as scnt")
                )
                ->where(function ($query) use ($fromDate, $toDate) {
                    $query->whereBetween("invite_sent_details.created_at", [$fromDate, $toDate])
                        ->orWhereBetween("invite_sent_details.updated_at", [$fromDate, $toDate]);
                })
                ->when(!empty($country), function ($query) use ($country) {
                    $query->where("projects.country_code", $country);
                })
                ->first();
        }
        // $totalStart  = count($trafficStats);
        $totalStart = $trafficStats;
        //print_r($totalStart);die;
        $totalInvite = $invite_sent_details->icnt;
        //$totalStart =  2;
        if ($totalInvite > 0) {
            $resposeRate = round(($totalStart / $totalInvite) * 100);
        } else {
            $resposeRate = 0;
            $totalInvite = 0;
        }
        return view("backend.auth.user.reports-response")
            ->with("totalInvite", $totalInvite)
            ->with("totalStart", $totalStart)
            ->with("resposeRate", $resposeRate);
    }
    //Function Added By Ramesh Kamboj//
    public function reportallsurvey(ManageUserRequest $request)
    {
        /*$data = SurveyReport::get();
         print_r($data); die;*/

        $timePeriod = $request->get("timeperiod");
        $fromDate = $request->get("fromDate");
        $toDate = $request->get("toDate");
        $selectPeriod = true;

        if (!empty($fromDate) && !empty($toDate)) {
            $selectPeriod = false;
        } elseif (!empty($timePeriod)) {
            $timePeriod = $timePeriod;
        } else {
            $timePeriod = 30;
        }

        if ($selectPeriod) {
            $fromLastDays = now()
                ->subDays($timePeriod)
                ->endOfDay();
            $trafficStats = $this->trafficRepo->getTrafficsStatsAllUsers(
                null,
                null,
                $fromLastDays
            );
        } else {
            $trafficStats = $this->trafficRepo->getTrafficsStatsAllUsers(
                $fromDate,
                $toDate
            );
        }

        //echo '<pre>';
        // foreach($trafficStats as $trafficStat){
        //     $uuids = explode('_',$trafficStat->vvars['sjpid']);

        //     $trafficStat->uuid = $uuids[0];
        // }

        //dd($trafficStats);die;

        // print_r(count($trafficStats));
        //  echo '<pre>';
        //  print_r($trafficStats);die;
        return view("backend.auth.user.reports-all-survey")
            //->withUsers($this->userRepository->getActiveUsers());
            ->with("trafficStats", $trafficStats);
    }
    //End Here

    public function reportsurvey(ManageUserRequest $request)
    {


        if ($request->ajax()) {


            $timePeriod = $request->get('timeperiod');
            $fromDate = $request->get('fromDate');
            $toDate = $request->get('toDate');
            $selectPeriod = true;

            if (!empty($fromDate) && !empty($toDate)) {
                $selectPeriod = false;
            } elseif (!empty($timePeriod)) {
                // use provided timePeriod
            } else {
                $timePeriod = 30; // default last 30 days
            }

            if ($selectPeriod) {

                 $fromLastDays = now()->subDays($timePeriod)->endOfDay();
                
                $trafficStats = $this->trafficRepo->getTrafficsStatsAllUsers(null, null, $fromLastDays);
            } else {

                $trafficStats = $this->trafficRepo->getTrafficsStatsAllUsers($fromDate, $toDate);
            }

            // Normalize and filter
            $trafficStats = collect($trafficStats);
            /*$trafficStats = collect($trafficStats)
        ->map(function ($item) {
            return is_array($item) ? $item : (array) $item;
        })
        ->filter(function ($item) {
            return !empty($item['uuid']);
        });*/

            // Get UUIDs and map panelist IDs
            $uuids = $trafficStats->pluck('uuid')->unique()->toArray();

            $panelistMap = User::whereIn('uuid', $uuids)
                ->pluck('panellist_id', 'uuid')
                ->toArray();

            // Device label helper
            $formatDeviceLabel = function ($deviceType) {
                $type = strtolower(trim($deviceType));
                if ($type === 'android') {
                    return 'App (Android)';
                } elseif ($type === 'ios') {
                    return 'App (iOS)';
                } elseif ($type === '') {
                    return 'Web';
                }
                return ucfirst($type);
            };

            // Map trafficStats with panelist ID and formatted device type
            $trafficStats = $trafficStats->map(function ($item) use ($panelistMap, $formatDeviceLabel) {
                $uuid = $item['uuid'] ?? '';
                $panelist_id = isset($panelistMap[$uuid]) ? $panelistMap[$uuid] : '';

                return [
                    'uuid' => $uuid,
                    'panelist_id' => $panelist_id,
                    'assignCount' => $item['assignCount'] ?? 0,
                    'startCount' => $item['startCount'] ?? 0,
                    'completesCount' => $item['completesCount'] ?? 0,
                    'terminatesCount' => $item['terminatesCount'] ?? 0,
                    'quotafullCount' => $item['quotafullCount'] ?? 0,
                    'quality_terminateCount' => $item['quality_terminateCount'] ?? 0,
                    'abandonsCount' => $item['abandonsCount'] ?? 0,
                    'rejectCount' => $item['rejectCount'] ?? 0,
                    'user_id' => $item['user_id'] ?? null,
                    'device_type' => $formatDeviceLabel($item['device_type'] ?? ''),
                ];
            });
            // Search filter
            $searchValue = $request->input('search.value', '');
            if (!empty($searchValue)) {
                $trafficStats = $trafficStats->filter(function ($item) use ($searchValue) {
                    return stripos($item['uuid'], $searchValue) !== false ||
                        stripos((string)$item['panelist_id'], $searchValue) !== false;
                });
            }

            // Pagination
            $start = (int) $request->input('start', 0);
            $length = (int) $request->input('length', 25);
            $page = intval($start / $length) + 1;
            $paginatedData = $trafficStats->forPage($page, $length);

            // Format data for frontend
            $formattedData = $paginatedData->map(function ($item) {
                return [
                    'uuid' => $item['uuid'],
                    'panelist_id' => $item['panelist_id'],
                    'assignCount' => $item['assignCount'],
                    'startCount' => $item['startCount'],
                    'completesCount' => $item['completesCount'],
                    'terminatesCount' => $item['terminatesCount'],
                    'quotafullCount' => $item['quotafullCount'],
                    'quality_terminateCount' => $item['quality_terminateCount'],
                    'abandonsCount' => $item['abandonsCount'],
                    'rejectCount' => $item['rejectCount'],
                    'device_type' => $item['device_type'],
                    'action' => $item['uuid'] ? '<a href="' . route('admin.auth.reports.survey_details', $item['uuid']) . '"><i class="fa fa-eye" title="View"></i></a>                     &nbsp;
                     <a href="' . route('admin.auth.reports.panelist_live_survey_details', $item['panelist_id']) . '">
                         <i class="fa fa-list" title="Listing"></i>
                     </a>' : '',
                ];
            });

            return response()->json([
                'draw' => intval($request->input('draw')),
                'recordsTotal' => $trafficStats->count(),
                'recordsFiltered' => $trafficStats->count(),
                'data' => $formattedData->values(),
            ]);
        }

        return view('backend.auth.user.reports-survey');
    }
    // public function surveyReport(ManageUserRequest $request){

    //     return view('backend.auth.user.reports-survey');

    // }

    public function reportDetails(ManageUserRequest $request, $uuid)
    {
        $panelist_id = User::getPanelistsId($uuid);

        $surveyData = DB::table('survey_reports')
            ->leftJoin('user_platform_actions', function ($join) use ($uuid) {
                $join->on(
                    DB::raw("user_platform_actions.action_id COLLATE utf8mb4_unicode_ci"),
                    '=',
                    DB::raw("survey_reports.project_code COLLATE utf8mb4_unicode_ci")
                )
                    ->whereRaw(
                        "user_platform_actions.user_uuid COLLATE utf8mb4_unicode_ci = ?",
                        [$uuid]
                    )
                    ->where('user_platform_actions.action_type', 'survey_participation');
            })
            ->select(
                'survey_reports.*',
                DB::raw("IFNULL(user_platform_actions.platform, '-') as device_type")
            )
            ->whereRaw("survey_reports.uuid COLLATE utf8mb4_unicode_ci = ? COLLATE utf8mb4_unicode_ci", [$uuid])
            ->get()
            ->map(function ($item) {
                return (array) $item; // Convert each stdClass object to array
            })
            ->toArray();

        return view("backend.auth.user.reports-survey-details")
            ->with("uuid", $uuid)
            ->with("panelist_id", $panelist_id)
            ->with("surveyData", $surveyData);
    }


    public function userFraud(ManageUserRequest $request)
    {
         //echo"<pre>";
         //print_r($request->all());
         //exit;

        if ($request->input()) {
            $searchType = $request->input('searchType');
            if ($searchType == "uuid") {
                $uuids = explode(',', $request->input('userids'));
                $activeUsers = $this->userRepository->getActiveUsersForFraud($uuids);
            } elseif ($searchType == "panelists_id") {
                $panelists_ids = explode(',', $request->input('userids'));
                $activeUsers = $this->userRepository->getActiveUsersForFraud(null, $panelists_ids);
            }
        }

        $user = auth()->user();
        $post = 1;

        if ($post) {
            $startDate = '2025-03-01';
            $endDate = '2025-03-31';
            $dateLimit = " AND updated_at >= '" . $startDate . "' AND updated_at <= '" . $endDate . "'";
            $dateTimeLimit = " AND updated_at >= '" . $startDate . " 00:00:00' AND updated_at <= '" . $endDate . " 23:59:59'";
            $dateTimeLimitChannel = " AND updatedOn >= '" . $startDate . " 00:00:00' AND updatedOn <= '" . $endDate . " 23:59:59'";
        }

        $activeUsers = User::query()
            ->select(
                'users.*',
                DB::raw("TIMESTAMPDIFF(YEAR, DATE(users.dob), CURDATE()) AS age"),
                'profile_log.profile_filled',
                'last_login_log.last_login',
                'survey_data.Total_survey_taken',
                'survey_data.survey_status',
                'survey_data.Total_survey_completed',
                'unsubscribe_log.unsubscribed_on',
                'froud_users1.froud_count',
                'panellist_address.state',
                'panellist_address.city',
                'panellist_address.region',
                'user_platform_actions.platform',
                DB::raw("
                    CASE 
                        WHEN user_tokens.id IS NOT NULL 
                            THEN CONCAT('Yes (', user_tokens.device_type, ')') 
                        ELSE 'No' 
                    END AS downloaded_app
                "),
                'recent_activity.has_active' // added by Himanshu 25-09-2025
            )
            ->whereHas('roles', function ($query) {
                $query->where('id', 4);
            })
            // Join Added by Vikas for tracking Downloaded app(Code Starting)
            ->leftJoin('user_tokens', 'users.id', '=', 'user_tokens.user_id')
            // Code Ending

            // Join Added by Vikas for tracking Platform(Code Starting)
            ->leftJoin('user_platform_actions', function ($join) {
                $join->on('users.uuid', '=', 'user_platform_actions.user_uuid')
                    ->where('user_platform_actions.action_type', '=', 'registration');
            })
            // Code Ending
            ->leftJoin('panellist_address', 'users.id', '=', 'panellist_address.user_id');
        $profileFilledSub = DB::table('activity_log')
            ->select('causer_id', DB::raw('COUNT(*) as profile_filled'))
            ->where('log_name', 'default')
            ->where('description', 'like', '%inpanel.activity_log.profile%')
            ->groupBy('causer_id');

        $activeUsers->leftJoinSub($profileFilledSub, 'profile_log', function ($join) {
            $join->on('profile_log.causer_id', '=', 'users.id');
        });

        $froud_count = DB::table('froud_users')
            ->select(DB::raw('COUNT(*) as froud_count'), 'panellist_id')
            ->groupBy('panellist_id');

        $activeUsers->leftJoinSub($froud_count, 'froud_users1', function ($join) {
            $join->on('froud_users1.panellist_id', '=', 'users.panellist_id');
        });

        $lastLoginSub = DB::table('activity_log')
            ->select('causer_id', DB::raw('MAX(updated_at) as last_login'))
            ->where('description', 'inpanel.activity_log.log_in')
            ->groupBy('causer_id');

        $activeUsers->leftJoinSub($lastLoginSub, 'last_login_log', function ($join) {
            $join->on('last_login_log.causer_id', '=', 'users.id');
        });

        $surveySub = DB::table('user_projects')
            ->select(
                'user_id',
                DB::raw("COUNT(CASE WHEN status IS NOT NULL THEN 1 END) as Total_survey_taken"),
                DB::raw("MAX(status) as survey_status"),
                DB::raw("COUNT(CASE WHEN status IN (1, 50) THEN 1 END) as Total_survey_completed")
            )
            ->groupBy('user_id');

        $activeUsers->leftJoinSub($surveySub, 'survey_data', function ($join) {
            $join->on('survey_data.user_id', '=', 'users.id');
        });

        $unsubSub = DB::table('user_unsubscribes')
            ->select(
                DB::raw('SHA1(email) as hashed_email'),
                DB::raw('MAX(created_at) as unsubscribed_on')
            )
            ->groupBy('hashed_email');

        $activeUsers->leftJoinSub($unsubSub, 'unsubscribe_log', function ($join) {
            $join->on('unsubscribe_log.hashed_email', '=', 'users.email_hash');
        });

        // added by Himanshu to check User is active or not 25-09-2025
        $getActiveMonthsLimit = settings::where(
            "key",
            "=",
            "PANEL_ACTIVE_MONTH_LIMIT"
        )->value('value');

        $recentActivitySub = DB::table('user_projects')
            ->select(
                'user_id',
                DB::raw("CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END as has_active")
            )
            ->where('created_at', '>=', now()->subMonths($getActiveMonthsLimit)) // filter for months
            ->where('status', '!=', null)
            ->groupBy('user_id');

        $activeUsers->leftJoinSub($recentActivitySub, 'recent_activity', function ($join) {
            $join->on('recent_activity.user_id', '=', 'users.id');
        });
        // end here 25-09-2025

        if ($post) {
            $activeUsers->leftJoin('user_projects', 'user_projects.user_id', '=', 'users.id');
        }

        $activeUsers1 = $activeUsers
            ->groupBy('users.id')
            ->orderBy('users.created_at', 'desc')
            ->get();

        // dd($activeUsers1);
        $stateToRegionMapping = [
            // Northeast
            "CT" => "Northeast",
            "ME" => "Northeast",
            "MA" => "Northeast",
            "NH" => "Northeast",
            "RI" => "Northeast",
            "VT" => "Northeast",
            "NJ" => "Northeast",
            "NY" => "Northeast",
            "PA" => "Northeast",
            "DE" => "Northeast", // Delaware
            "MD" => "Northeast", // Maryland
            "DC" => "Northeast", // District of Columbia
            "WV" => "Northeast", // West Virginia

            // South
            "VA" => "South",
            "NC" => "South",
            "SC" => "South",
            "GA" => "South",
            "FL" => "South",
            "AL" => "South",
            "MS" => "South",
            "TN" => "South",
            "KY" => "South",
            "LA" => "South",
            "AR" => "South",
            "OK" => "South",
            "TX" => "South",

            // Midwest
            "OH" => "Midwest",
            "MI" => "Midwest",
            "IN" => "Midwest",
            "IL" => "Midwest",
            "WI" => "Midwest",
            "MN" => "Midwest",
            "IA" => "Midwest",
            "MO" => "Midwest",
            "KS" => "Midwest",
            "NE" => "Midwest",
            "SD" => "Midwest",
            "ND" => "Midwest",

            // West
            "WA" => "West",
            "OR" => "West",
            "CA" => "West",
            "NV" => "West",
            "ID" => "West",
            "MT" => "West",
            "WY" => "West",
            "CO" => "West",
            "UT" => "West",
            "AZ" => "West",
            "NM" => "West",
            "AK" => "West",
            "HI" => "West",

            // India
            /*"AP" => "India",
            "AR" => "India",
            "AS" => "India",
            "BR" => "India",
            "CG" => "India",
            "GA" => "India",
            "GJ" => "India",
            "HR" => "South West",
            "GJ" => "West",
            "GJ" => "India",
            "DL" => "North",
            "WB" => "East" ,
            "CH" => "North",*/
        ];

        if (isset(session()->get("current_user")->id)) {
            $userid = session()->get("current_user")->id;
        } else {
            $userid = auth()->id();
        }
        //$Panthera = AffiliateCampaignData::where("medium", "PANT")->get(); //[10-09-2024]
        // added the new type in where In condition by Anil
        $Panthera = AffiliateCampaignData::whereIn("medium", ["PANT", "NEGM", "Facebook", "Instagram", "Twitter", "LinkedIn", "Quora", "SEO", "Paid_Ads", "Email", "LESC", "NEGM", "MONE", "PAPL", "GoogleAd", "ANTK", "PFMS", "FRKM", "PSOS", "LEDM", "LFDM", "Youtube", "ChatGPT", "Ryan"])->get();
        // added the new type in where In condition by Anil


        $arr  = [];
        $data = [];
        foreach ($Panthera as $affiliate) {
            $arr['userId'] = $affiliate->user_id;
            $arr['medium'] = $affiliate->medium;

            $data[] = $arr;
        }

        $users = $activeUsers1;
        $profile_filled_count = [];
        foreach ($users as $user) {
            $pro_filled_data = UserAdditionalData::where("uuid", $user->uuid)->first();

            if ($pro_filled_data) {
                $user_filled_profiles = $pro_filled_data->user_filled_profiles;
                $profile_filled_count[$user->uuid] = count($user_filled_profiles ?? []);
            } else {
                $profile_filled_count[$user->uuid] = 0;
            }
        }

        $invite_emails = DB::table("invite_campaigns")
            ->where("email_sent", 1)
            ->pluck("email")
            ->toArray();
        $invite_emails = array_map("strtolower", $invite_emails);

        $getFraudLimit = settings::where(
            "key",
            "=",
            "PANEL_FRAUD_LIMIT"
        )->first();


        //$allActiveInactiveUsers = $this->userRepository->getActiveUsers1(null,null,"allUsers");

        $allActiveInactiveUsers = $activeUsers1;
        //$allActiveInactiveUsers = $this->userRepository->getActiveUsers1();
        //dd($allActiveInactiveUsers->toArray(),$this->userRepository->getActiveUsers1()->toArray());
        return view('backend.auth.user.fraud-users')
            ->withUsers($allActiveInactiveUsers)
            // ->withUsers($this->userRepository->getUsers())
            ->with("userid", $userid)
            ->with("activeUsers", $activeUsers1)
            ->with("getFraudLimit", $getFraudLimit)
            ->with("profile_filled_count", $profile_filled_count)
            ->with("invite_emails", $invite_emails)
            ->with("affiliate", $data);
    }
    // public function userFraud(ManageUserRequest $request){

    //    /* if (Cache::has('activeUsers')) {
    //         echo"<pre>";

    //         $activeUsers1=Cache::get('activeUsers');
    //        foreach($activeUsers1 as $user){
    //         print_r($user);
    //         exit;
    //        } 


    //     }
    //     exit;*/
    //     if($request->input()){
    //         $searchType = $request->input('searchType');
    //         if($searchType == "uuid"){
    //             $uuids = explode(',',$request->input('userids'));
    //             $activeUsers = $this->userRepository->getActiveUsersForFraud($uuids);
    //         }elseif($searchType == "panelists_id"){
    //             $panelists_ids = explode(',',$request->input('userids'));
    //             $activeUsers = $this->userRepository->getActiveUsersForFraud(null,$panelists_ids);
    //         }
    //     } else {
    //         //$activeUsers= $this->userRepository->getActiveUsersForFraud();

    //           /*$activeUsers = Cache::remember('users', 60*24, function () {
    //          return $this->userRepository->getActiveUsersForFraud();
    //       });*/

    //     }


    //     $user = auth()->user();

    //     /* $Panthera = AffiliateCampaignData::whereIn("medium", ["PANT","NEGM"])->get();
    //     $data = [];
    //     foreach ($Panthera as $affiliate) {
    //         $data[] = $affiliate->user_id;
    //     } */


    //     /*$activeUsers1 = user::with(

    //         [
    //             "roles" => function ($q) {
    //                 $q->where("role_id", "4");
    //             },
    //         ],
    //         "permissions",
    //         "providers"
    //     )->select('users.id', 'users.email', 'users.locale', 'users.first_name', 'users.last_name', 'users.uuid', 'users.panellist_id', 'users.dob', 'users.gender', 'users.country', 'users.updated_at','users.password_changed_at','users.created_at','users.last_login_at','users.*',
    //                     DB::raw("TIMESTAMPDIFF(YEAR, DATE(users.dob), current_date) AS age"),
    //                     DB::raw("(SELECT COUNT(*) FROM froud_users WHERE panellist_id = users.panellist_id) as froud_count"),
    //                     DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND description = 'inpanel.activity_log.log_in' ORDER BY updated_at DESC LIMIT 1) as last_login"),
    //                     DB::raw("(SELECT updated_at FROM activity_log WHERE causer_id = users.id AND (description = 'inpanel.activity_log.registration' OR description = 'inpanel.activity_log.user_confirm') ORDER BY updated_at DESC LIMIT 1) as date_of_join"),
    //                     DB::raw("(SELECT CONCAT_WS(',', description) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities"),
    //                     DB::raw("(SELECT CONCAT_WS(',', properties) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as property"),
    //                     DB::raw("(SELECT max(updated_at) FROM activity_log WHERE causer_id = users.id ORDER BY updated_at DESC LIMIT 1) as Activities_date"),
    //                     DB::raw("(SELECT GROUP_CONCAT(project_id ORDER BY created_at DESC) FROM (SELECT project_id, created_at FROM froud_users WHERE panellist_id = users.panellist_id ORDER BY created_at DESC LIMIT 3) AS subquery) as project_ids"),
    //                     DB::raw("(SELECT max(updated_at) FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC) as survey_taken"),
    //                     DB::raw("(SELECT MAX(updated_at) FROM user_projects WHERE user_id = users.id AND status NOT IN (50, NULL) ORDER BY updated_at DESC) as survey_taken_date"),
    //                     DB::raw("(SELECT count(*) FROM user_projects WHERE user_id  = users.id AND status IS NOT NULL) as Total_survey_taken"),
    //                     DB::raw("(SELECT status FROM user_projects WHERE user_id = users.id AND status IS NOT NULL ORDER BY updated_at DESC LIMIT 1) as survey_status"),
    //                     //DB::raw("(SELECT channel_id FROM survey_reports WHERE uuid COLLATE utf8mb4_unicode_ci = users.uuid COLLATE utf8mb4_unicode_ci ORDER BY updatedOn DESC LIMIT 1) as channel_id"),
    //                     DB::raw("(SELECT count(*) FROM user_projects WHERE user_id = users.id AND status IN (1, 50)) as Total_survey_completed"),
    //                     DB::raw("(SELECT created_at FROM request_redeems WHERE user_uuid COLLATE utf8mb4_unicode_ci = users.uuid ORDER BY created_at DESC LIMIT 1) as redeem_request"),
    //                     DB::raw("(SELECT created_at FROM user_referral_codes WHERE user_id = users.id ORDER BY created_at DESC LIMIT 1) as user_refer_date"),
    //                     DB::raw("(SELECT updated_at FROM support_chats WHERE user_id = users.id ORDER BY updated_at DESC LIMIT 1) as support_date"),
    //                     DB::raw("(SELECT updated_at FROM user_projects WHERE user_id = users.id AND status IN (1, 50) ORDER BY updated_at DESC LIMIT 1) as last_survey_completed_on")
    //                 )
    //         ->active()
    //         // ->confirmed()
    //         // ->orderByRaw('created_at DESC, NOW() DESC')
    //         ->orderBy("created_at", "desc")
    //         ->get();*/


    //         $activeUsers1=Cache::get('activeUsers');
    //       // echo 'app2<pre>'; print_r($activeUsers1); exit;

    //     //echo 'app2'; print_r($activeUsers1); exit;

    //          //$activeUsers1 =$activeUsers;



    //     // $states = [];
    //     // foreach ($activeUsers1 as $activeUsers) {
    //     // $state = $this->getStateFromZipCode($activeUsers->zipcode);
    //     // $states[$activeUsers->id] = $state;
    //     // }
    //     $stateToRegionMapping = [
    //         // Northeast
    //         "CT" => "Northeast",
    //         "ME" => "Northeast",
    //         "MA" => "Northeast",
    //         "NH" => "Northeast",
    //         "RI" => "Northeast",
    //         "VT" => "Northeast",
    //         "NJ" => "Northeast",
    //         "NY" => "Northeast",
    //         "PA" => "Northeast",
    //         "DE" => "Northeast", // Delaware
    //         "MD" => "Northeast", // Maryland
    //         "DC" => "Northeast", // District of Columbia
    //         "WV" => "Northeast", // West Virginia

    //         // South
    //         "VA" => "South",
    //         "NC" => "South",
    //         "SC" => "South",
    //         "GA" => "South",
    //         "FL" => "South",
    //         "AL" => "South",
    //         "MS" => "South",
    //         "TN" => "South",
    //         "KY" => "South",
    //         "LA" => "South",
    //         "AR" => "South",
    //         "OK" => "South",
    //         "TX" => "South",

    //         // Midwest
    //         "OH" => "Midwest",
    //         "MI" => "Midwest",
    //         "IN" => "Midwest",
    //         "IL" => "Midwest",
    //         "WI" => "Midwest",
    //         "MN" => "Midwest",
    //         "IA" => "Midwest",
    //         "MO" => "Midwest",
    //         "KS" => "Midwest",
    //         "NE" => "Midwest",
    //         "SD" => "Midwest",
    //         "ND" => "Midwest",

    //         // West
    //         "WA" => "West",
    //         "OR" => "West",
    //         "CA" => "West",
    //         "NV" => "West",
    //         "ID" => "West",
    //         "MT" => "West",
    //         "WY" => "West",
    //         "CO" => "West",
    //         "UT" => "West",
    //         "AZ" => "West",
    //         "NM" => "West",
    //         "AK" => "West",
    //         "HI" => "West",

    //         // India
    //         /*"AP" => "India",
    //     "AR" => "India",
    //     "AS" => "India",
    //     "BR" => "India",
    //     "CG" => "India",
    //     "GA" => "India",
    //     "GJ" => "India",
    //     "HR" => "South West",
    //     "GJ" => "West",
    //     "GJ" => "India",
    //     "DL" => "North",
    //     "WB" => "East" ,
    //     "CH" => "North",*/

    //  ];

    // //$userrs = User::select('zipcode', 'country', 'panellist_id')->get();
    // $usersData = [];
    // $userData=[];
    // $cityname=[];
    // foreach ($activeUsers1 as $userr) {
    //     $zipcode = $userr->zipcode;
    //     $country = $userr->country;
    //     $panellist_id = $userr->panellist_id;


    //     // Check if the zipcode is empty or null, then skip this user
    //     if (empty($zipcode)) {
    //         continue;
    //     }
    //     //$pro_filled_data = UserAdditionalData::where('uuid', $userr->uuid)->first();


    //     //$data=array_column($pro_filled_data->user_answers[0], 'FAMILY')
    //    // print_r($pro_filled_data->user_answers);

    //     // Get state from zip code using your method
    //     $state = $this->getStateFromZipCode($zipcode, $country, $panellist_id, $stateToRegionMapping);

    //     // Check if state is valid
    //     if ($state !== null) {
    // /*if(isset($pro_filled_data->user_answers)){

    //         foreach($pro_filled_data->user_answers as $key=>$value){
    //             if(!empty($value)){
    //                 if(@$value['profile_question_code']=='DMA_NAME'){
    //                     $cityname[$userr->panellist_id]=$value['selected_answer'][0];
    //                 }
    //             }else{
    //                 $cityname[$userr->panellist_id]='';
    //             }
    //         }


    //     } */  


    //         // Do something with $state, for example, add it to the usersData array
    //         $stateName = $state[0] ?? null;
    //         $cityName = $state[1] ?? null;
    //         $regionName = $state[2] ?? '-';

    //         $userData[$userr->panellist_id] = [
    //             'state' => $stateName,
    //             'city' => $cityname[$userr->panellist_id] ?? null,
    //             'region' => $regionName
    //         ];

    //         // Add user data to the usersData array

    //         $panellistAddressArr=[
    //             'user_id'=>$userr->id,
    //             'city' => $cityname[$userr->panellist_id] ?? null,
    //             'state' => $stateName,
    //             'region' => $regionName
    //         ];

    //         $this->savePanellistAddress($panellistAddressArr);
    //     }
    // }

    //     $usersData[] = $userData;

    //     //print_r(session()->get('current_user')->id);
    //     if (isset(session()->get("current_user")->id)) {
    //         $userid = session()->get("current_user")->id;
    //     } else {
    //         $userid = auth()->id();
    //     }
    //     //$Panthera = AffiliateCampaignData::where("medium", "PANT")->get(); //[10-09-2024]

    //     $Panthera = AffiliateCampaignData::whereIn("medium", ["PANT","NEGM","Facebook","Instagram","Twitter","LinkedIn","Quora","SEO","Paid_Ads","Email","LESC","NEGM","MONE","PAPL","GoogleAd","ANTK","PFMS","FRKM","PSOS","LEDM","LFDM"])->get();

    //     $arr  = [];
    //     $data = [];
    //     foreach ($Panthera as $affiliate) {
    //         //$data[] = $affiliate->user_id;
    //         $arr['userId'] = $affiliate->user_id;
    //         $arr['medium'] = $affiliate->medium;

    //      $data[] = $arr;
    //     }
    //  //dd($data);


    //     //$users = $this->userRepository->getActiveUsers1();
    //     $users =$activeUsers1;
    //     // $pro_filled_data = UserAdditionalData::where('uuid', '9f73c98c-2df4-4270-ad21-4652ff8b21fd')->first();
    //     // echo "<pre>";
    //     // print_r($pro_filled_data);
    //     // die;
    //     $profile_filled_count = [];
    //     foreach ($users as $user) {
    //         $pro_filled_data = UserAdditionalData::where(
    //             "uuid",
    //             $user->uuid
    //         )->first();

    //         if ($pro_filled_data) {
    //             $user_filled_profiles = $pro_filled_data->user_filled_profiles;
    //             $filled_profiles_count = count($user_filled_profiles ?? []);
    //             $profile_filled_count[$user->uuid] = $filled_profiles_count;
    //         } else {
    //             $profile_filled_count[$user->uuid] = 0;
    //         }

    //         if(isset($pro_filled_data->user_answers)){
    //             foreach($pro_filled_data->user_answers as $key=>$value){
    //                 if(!empty($value)){
    //                     if(@$value['profile_question_code']=='DMA_NAME'){
    //                         $cityname[$userr->panellist_id]=$value['selected_answer'][0];
    //                     }
    //                 }else{
    //                     $cityname[$userr->panellist_id]='';
    //                 }
    //             }
    //         }
    //         $userData[$user->panellist_id] = [

    //              'city' => $cityname[$user->panellist_id] ?? null,

    //         ];


    //     }
    //      $usersData[] = $userData;

    //     $invite_emails = DB::table("invite_campaigns")
    //         ->where("email_sent", 1)
    //         ->pluck("email")
    //         ->toArray();
    //     $invite_emails = array_map("strtolower", $invite_emails);

    //     $getFraudLimit = settings::where(
    //         "key",
    //         "=",
    //         "PANEL_FRAUD_LIMIT"
    //     )->first();


    //     //$allActiveInactiveUsers = $this->userRepository->getActiveUsers1(null,null,"allUsers");

    //     $allActiveInactiveUsers =$activeUsers1;

    //     //$allActiveInactiveUsers = $this->userRepository->getActiveUsers1();
    //     //dd($allActiveInactiveUsers->toArray(),$this->userRepository->getActiveUsers1()->toArray());
    //     return view('backend.auth.user.fraud-users')
    //         ->withUsers($allActiveInactiveUsers)
    //         // ->withUsers($this->userRepository->getUsers())
    //         ->with("userid", $userid)
    //         ->with("activeUsers", $activeUsers1)
    //         ->with("getFraudLimit", $getFraudLimit)
    //         ->with("profile_filled_count", $profile_filled_count)
    //         ->with("invite_emails", $invite_emails)
    //         ->with("affiliate", $data)
    //         ->with("usersData", $usersData);
    // }

    function getStateFromZipCode(
        $zipcode,
        $country,
        $panellist_id,
        $stateToRegionMapping
    ) {
        $country_code = "";
        switch ($country) {
            case "US":
                $country_code = "US";
                break;
            case "IN":
                $country_code = "IN";
                break;
            case "CA":
                $country_code = "CA";
                break;
            default:
                $country_code = "US"; // Default
        }

        $zipp = "08854";

        $url = "https://api.zippopotam.us/{$country_code}/{$zipcode}";
        //dd($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            // cURL request failed
            // echo "Error: " . curl_error($ch);
            return null;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            // HTTP request failed
            // echo "HTTP Error: " . $http_code;
            return null;
        }

        $data = json_decode($response, true);
        //dd($data);        
        if (isset($data["places"][0])) {
            $state = $data["places"][0]["state"];
            $city = $data["places"][0]["place name"];

            // Extract state abbreviation
            $stateAbbreviation = $data["places"][0]["state abbreviation"];

            // Determine region based on state abbreviation
            $region = $stateToRegionMapping[$stateAbbreviation] ?? "-";

            return [$state, $city, $region, $stateAbbreviation];
        } else {
            // ZIP code not found
            return null;
        }

        curl_close($ch);
    }

    // public function getStateFromZipCode($zipCode)
    // {
    //     $apiUrl = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($zipCode) . "&key=AIzaSyBFGl1FwE4cHYH_17dUvSOE9KQGnIefAkM";

    //     // $url = "https://example.com/search?query=" . urlencode("hello world");

    //     $response = file_get_contents($apiUrl);
    //     //  dd($response);
    //     $data = json_decode($response, true);

    //     // dd($data);

    //     if (!empty($data['results'])) {
    //         $state = $data['results'][0]['address_components'][3]['long_name'];
    //         return $state;
    //     } else {
    //         return null;
    //     }
    // }

    public function UpdateNotification(Request $request)
    {
        $userids = $request->get("userIds");
        $updateUsers = User::whereIn("id", $userids)->update([
            "confirmed" => 2,
        ]);
        return response()->json(["status" => 200], 200);
    }

    public function InsertuserFraud(ManageUserRequest $request)
    {
        $panelistsId = $request->input("panelistsId");
        $managerId = $request->input("managerId");
        $projectid = $request->input("projectid");
        $reason = $request->input("reason");

        $add_fraudUsers = [
            "panellist_id" => $panelistsId,
            "manager_id" => $managerId,
            "project_id" => $projectid,
            "reason" => $reason,
        ];

        //print_r($add_fraudUsers);die;
        $froudUsers1 = FroudUsers::create($add_fraudUsers);
        if ($froudUsers1) {
            $user = User::where("panellist_id", $panelistsId)->first();
            $email = new FraudInformationEmail($user, $projectid);
            Mail::send($email);
        }

        $fraudUsersData = FroudUsers::where(
            "panellist_id",
            $panelistsId
        )->get();
        $getFraudLimit = settings::where(
            "key",
            "=",
            "PANEL_FRAUD_LIMIT"
        )->first();
        if (count($fraudUsersData) >= $getFraudLimit->value) {
            $updateUsers = User::where(
                "panellist_id",
                "=",
                $panelistsId
            )->update(["is_blacklist" => 1]);
            // print_r($updateUsers);die;
            if ($updateUsers) {
                $user = User::where("panellist_id", $panelistsId)->first();
                $email = new BlacklistInformationEmail($user, $fraudUsersData);
                Mail::send($email);
            }
        }

        return response()->json(["status" => 200], 200);
    }

    /**
     * Export csv user Profile data
     * New changes in date 29-12-2022
     * */
    public function exportUserProfile(Request $request)
    {
        $panellist_id = $request->input("panellist_ids");
        $panellist_ids = array_map("trim", explode(",", $panellist_id));
        $profile_sections = $request->input("profile_section");
        $contryCode = $request->input("country_code");

        $date = date("d-m-Y");
        $file_name = "SJ Panel User Profile " . $date;

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$file_name}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0",
        ];

        $locale = Config::get('app.locale');
        $locale = explode('_', $locale);
        $language = strtoupper($locale[0]);

        $all_question = ProfilerQuestions::whereIn("profile_section_code", $profile_sections)
            ->where("country_code", $contryCode)
            ->pluck("general_name")
            ->toArray();

        if (in_array("HIDDEN", $profile_sections)) {
            array_unshift(
                $all_question,
                "Panellist_Id",
                "DOB",
                "Gender",
                "Age",
                "Zipcode",
                "STATE",
                "DMA",
                "DMA_NAME",
                "REGION",
                "Device_Preference",
                "Country",
                "Language",
                "DOI Date",
                "Source"
            );
        } else {
            array_unshift(
                $all_question,
                "Panellist_Id",
                "DOB",
                "Gender",
                "Age",
                "Zipcode",
                "Device_Preference",
                "Country",
                "Language",
                "DOI Date",
                "Source"
            );
        }

        $invite_emails = DB::table('invite_emails')->pluck('email')->map(function ($email) {
            return strtolower(trim($email));
        })->toArray();

        // Preload UUIDs by user ID
        $userUuidMap = User::whereIn("panellist_id", $panellist_ids)
            ->pluck('uuid', 'id')
            ->toArray();

        // Preload all UserAdditionalData by UUID
        $userAddDataMap = UserAdditionalData::whereIn('uuid', array_values($userUuidMap))
            ->get()
            ->keyBy('uuid');

        $callback = function () use (
            $profile_sections,
            $all_question,
            $contryCode,
            $panellist_ids,
            $language,
            $invite_emails,
            $userAddDataMap
        ) {
            $file = fopen("php://output", "w");
            fputcsv($file, $all_question);

            User::whereIn("panellist_id", $panellist_ids)
                ->where("unsubscribed", 0)
                ->where('affiliate_campaign_datas.status', 'sent') // added by Himanshu 03-10-2025
                ->leftJoin('affiliate_campaign_datas', 'users.id', '=', 'affiliate_campaign_datas.user_id')
                ->select('users.*', 'affiliate_campaign_datas.medium as source')
                ->chunk(500, function ($activeUsers) use (
                    $file,
                    $profile_sections,
                    $contryCode,
                    $all_question,
                    $language,
                    $invite_emails,
                    $userAddDataMap
                ) {
                    foreach ($activeUsers as $row) {
                        $userAllData = $this->userRepository->getUseCompleteData(
                            $row->id,
                            $profile_sections,
                            $contryCode,
                            $userAddDataMap
                        );

                        $basicData = $userAllData["Basic Profile"] ?? [];
                        if (count($basicData) > 0) {
                            $arr = [];
                            foreach ($all_question as $questionKey) {
                                if ($questionKey === "Country") {
                                    $arr[] = $row->country ?? "N/A";
                                } elseif ($questionKey === "Language") {
                                    $arr[] = $language;
                                } elseif ($questionKey === "DOI Date") {
                                    $arr[] = $row->confirm_at ? date('d/m/Y', strtotime($row->confirm_at)) : "";
                                } elseif ($questionKey === "Source") {
                                    $arr[] = in_array(strtolower($row->email), $invite_emails) ? "Email Invite" : ($row->source ?? "N/A");
                                } else {
                                    $arr[] = $basicData[$questionKey] ?? "";
                                }
                                // commented by Himanshu 30-09-2025
                                // fputcsv($file, $arr);
                                // fflush($file);
                                // flush();
                                // end here
                            }
                            fputcsv($file, $arr);
                            fflush($file);
                            flush();
                        }
                    }
                });

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    //import csv user for fraud
    public function importFraudUser(Request $request)
    {
        if (isset(session()->get("current_user")->id)) {
            $userid = session()->get("current_user")->id;
        } else {
            $userid = auth()->id();
        }
        $file = $request->file("importfile");
        $customerArr = $this->csvToArray($file);
        // echo '<pre>';
        if ($customerArr == "not_matched") {
            return \Redirect::back()->withErrors(
                "Please only 3 column record insert.Please download demo sample excel."
            );
        }
        //print_r($customerArr);die;
        if ($customerArr) {
            $i = 1;
            foreach ($customerArr as $row) {
                $i++;
                $userExit = User::where(
                    "panellist_id",
                    trim($row["panellist_id"])
                )->count();
                if ($userExit == 0) {
                    return \Redirect::back()->withErrors(
                        "Inserted row number " .
                            $i .
                            " Panellist id is not exit my database.Please checked."
                    );
                }
            }

            foreach ($customerArr as $row) {
                $panelistsId = trim($row["panellist_id"]);

                $add_fraudUsers = [
                    "panellist_id" => $panelistsId,
                    "manager_id" => $userid,
                    "project_id" => $row["project_id"],
                    "reason" => $row["reason"],
                ];

                //print_r($add_fraudUsers);die;
                $froudUsers1 = FroudUsers::create($add_fraudUsers);
                if ($froudUsers1) {
                    $user = User::where("panellist_id", $panelistsId)->first();
                    $email = new FraudInformationEmail(
                        $user,
                        $row["project_id"]
                    );
                    Mail::send($email);
                }

                $fraudUsersData = FroudUsers::where(
                    "panellist_id",
                    $panelistsId
                )->get();
                $getFraudLimit = settings::where(
                    "key",
                    "=",
                    "PANEL_FRAUD_LIMIT"
                )->first();

                if (count($fraudUsersData) >= $getFraudLimit->value) {
                    $updateUsers = User::where(
                        "panellist_id",
                        "=",
                        $panelistsId
                    )->update(["is_blacklist" => 1]);

                    if ($updateUsers) {
                        $user = User::where(
                            "panellist_id",
                            $panelistsId
                        )->first();
                        $email = new BlacklistInformationEmail($updateUsers);
                        Mail::send($email);
                    }
                }
            }
            return \Redirect::back()->withFlashSuccess("Successfully Imported");
        } else {
            return \Redirect::back()->withErrors(
                "Some error occure. Please again checked"
            );
        }
    }

    public function csvToArray($filename = "", $delimiter = ",")
    {
        if (!file_exists($filename) || !is_readable($filename)) {
            return false;
        }

        $header = null;
        $data = [];
        if (($handle = fopen($filename, "r")) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                // print_r($row);die;
                if (!$header) {
                    //$header = $row;
                    $header = ["panellist_id", "project_id", "reason"];
                } elseif (count($header) != count($row)) {
                    return "not_matched";
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        return $data;
    }

    /**
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     *
     * @return mixed
     */
    public function create(
        ManageUserRequest $request,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository
    ) {
        return view("backend.auth.user.create")
            ->withRoles(
                $roleRepository->with("permissions")->get(["id", "name"])
            )
            ->withPermissions($permissionRepository->get(["id", "name"]));
    }

    /**
     * @param StoreUserRequest $request
     *
     * @return mixed
     * @throws \Throwable
     */
    public function store(StoreUserRequest $request)
    {
        $this->userRepository->create(
            $request->only(
                "first_name",
                "last_name",
                "email",
                "password",
                "active",
                "confirmed",
                "confirmation_email",
                "roles",
                "permissions"
            )
        );

        return redirect()
            ->route("admin.auth.user.index")
            ->withFlashSuccess(__("alerts.backend.users.created"));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     */
    public function show(ManageUserRequest $request, User $user)
    {
        return view("backend.auth.user.show")->withUser($user);
    }

    /**
     * @param ManageUserRequest    $request
     * @param RoleRepository       $roleRepository
     * @param PermissionRepository $permissionRepository
     * @param User                 $user
     *
     * @return mixed
     */
    public function edit(
        ManageUserRequest $request,
        RoleRepository $roleRepository,
        PermissionRepository $permissionRepository,
        User $user
    ) {
        return view("backend.auth.user.edit")
            ->withUser($user)
            ->withRoles($roleRepository->get())
            ->withUserRoles($user->roles->pluck("name")->all())
            ->withPermissions($permissionRepository->get(["id", "name"]))
            ->withUserPermissions($user->permissions->pluck("name")->all());
    }

    /**
     * @param UpdateUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userRepository->update(
            $user,
            $request->only(
                "first_name",
                "last_name",
                "email",
                "roles",
                "permissions"
            )
        );

        return redirect()
            ->route("admin.auth.user.index")
            ->withFlashSuccess(__("alerts.backend.users.updated"));
    }

    /**
     * @param ManageUserRequest $request
     * @param User              $user
     *
     * @return mixed
     * @throws \Exception
     */
    public function destroy(ManageUserRequest $request, User $user)
    {
        $this->userRepository->deleteById($user->id);

        event(new UserDeleted($user));

        return redirect()
            ->route("admin.auth.user.deleted")
            ->withFlashSuccess(__("alerts.backend.users.deleted"));
    }

    public function uniqueIPCheck()
    {
        $unique_ip_check = setting()->get("unique_ip_check");
        return view("backend.unique_ip_check.index")->with(
            "unique_ip_check",
            $unique_ip_check
        );
    }
    public function postUniqueIPCheck(Request $request)
    {
        $ip_check = $request->input("unique_ip_check", false);
        if ($ip_check) {
            setting()->set("unique_ip_check", $ip_check);
            setting()->save();
        } else {
            setting()->set("unique_ip_check", "0");
            setting()->save();
        }
        return \Redirect::back()->withFlashSuccess("IP check enabled");
    }

    public function blackListedIps()
    {
        $row = [];
        if (
            file_exists(
                resource_path() .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips" .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips.csv"
            )
        ) {
            $link_file = fopen(
                resource_path() .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips" .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips.csv",
                "r"
            );
            while (($line = fgetcsv($link_file)) !== false) {
                $row[] = $line;
            }
            unset($row[0]);
        }
        $ip_array = array_values($row);
        $blacklisted_ips = [];
        foreach ($ip_array as $val) {
            $blacklisted_ips[] = $val[0];
        }
        return view("backend.blacklisted_ip.index")->with(
            "blacklisted_ips",
            $blacklisted_ips
        );
    }

    public function addIps()
    {
        return view("backend.blacklisted_ip.add");
    }

    public function postIps(Request $request)
    {
        $ips = $request->input("ips", false);
        $ip_data = preg_split('/\r\n|[\r\n]/', $ips);
        $row = [];
        if (
            file_exists(
                resource_path() .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips" .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips.csv"
            )
        ) {
            $link_file = fopen(
                resource_path() .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips" .
                    DIRECTORY_SEPARATOR .
                    "blacklisted_ips.csv",
                "r"
            );
            while (($line = fgetcsv($link_file)) !== false) {
                $row[] = $line;
            }
            unset($row[0]);
        }
        $ip_array = array_values($row);
        $blacklisted_ips = [];
        foreach ($ip_array as $val) {
            $blacklisted_ips[] = $val[0];
        }
        $new_blacklisted_ips = array_merge($blacklisted_ips, $ip_data);
        $handle = fopen(
            resource_path() .
                DIRECTORY_SEPARATOR .
                "blacklisted_ips" .
                DIRECTORY_SEPARATOR .
                "blacklisted_ips.csv",
            "w+"
        );
        fputcsv($handle, ["Blacklisted Ips"]);
        if ($new_blacklisted_ips) {
            foreach ($new_blacklisted_ips as $data) {
                fputcsv($handle, [$data]);
            }
            fclose($handle);
            $headers = [
                "Content-Type" => "text/csv",
            ];
        }
        return \Redirect::back()->withFlashSuccess("New Ips Added");
    }

    public function doiRemainderAll()
    {
        $handle = fopen(
            resource_path() .
                DIRECTORY_SEPARATOR .
                "blacklisted_ips" .
                DIRECTORY_SEPARATOR .
                "DOI_USER.csv",
            "a+"
        );
        $get_reffer_point = settings::whereIn("key", [
            "PANEL_SIGNUP_POINTS",
            "PANEL_ACCOUNT_ACTIVATION_POINTS",
            "PANEL_BASIC_PROFILE_POINTS",
        ])->sum("value");

        $last30Days = now()->subDays(30);

        $users = User::where("created_at", ">=", $last30Days)
            ->where("confirmed", "=", 0)
            ->active()
            ->get();

        if ($users->isNotEmpty()) {
            foreach ($users as $user) {
                $str = $user->panellist_id . ";" . $user->uuid . "\r\n";

                fwrite($handle, $str);
                // Dispatch job to queue
                dispatch(new DoiRemainderAllEmail(
                    $user,
                    $user->confirmation_code,
                    $get_reffer_point,
                    1
                ));
            }
            fclose($handle);

            return redirect()
                ->back()
                ->with(
                    "success",
                    __("strings.emails.auth.confirmation.doi_success")
                );
        } else {
            return redirect()
                ->back()
                ->with("fail", __("strings.emails.auth.confirmation.doi_fail"));
        }
    }

    public function doiRemainder($panelist_id)
    {
        /*$panelist_id=["240326280003", 
"240323490009", 
"240323590007", 
"240323120006", 
"240323010002", 
"240323540001", 
"240322560003", 
"240322130001", 
"240321560008", 
"240321190006", 
"240321090003", 
"240321220001", 
"240320150004", 
"240320210003", 
"240320540001", 
"240319000005", 
"240318060003", 
"240316570012", 
"240316460008", 
"240316170003", 
"240316380001", 
"240314570012", 
"240314560010", 
"240314330006", 
"240314500005", 
"240313450002", 
"240308300001", 
"240302370001", 
"240229260011", 
"240229110009", 
"240229160003", 
"240219040006", 
"240216570023", 
"240216140022", 
"240213430001", 
"240212200004", 
"240206240005", 
"240206030004", 
"240204400002", 
"240204390001", 
"240102310017", 
"231217530002", 
"231217460001", 
"231031480014", 
"231028570002", 
"231017530013", 
"231017220007", 
"231014500001"];*/

        // $panelist_id = [$panelist_id];
        // $handle = fopen(
        //     resource_path() .
        //         DIRECTORY_SEPARATOR .
        //         "blacklisted_ips" .
        //         DIRECTORY_SEPARATOR .
        //         "DOI_USER.csv",
        //     "a+"
        // );

        // $get_reffer_point = settings::whereIn("key", [
        //     "PANEL_SIGNUP_POINTS",
        //     "PANEL_ACCOUNT_ACTIVATION_POINTS",
        //     "PANEL_BASIC_PROFILE_POINTS",
        // ])->sum("value");
        // for ($i = 0; $i < count($panelist_id); $i++) {
        //     $user = User::where("panellist_id", $panelist_id[$i])->first();
        //     // echo "<pre>";
        //     // print($user);
        //     $str = $user->panellist_id . ";" . $user->uuid . "\r\n";
        //     fwrite($handle, $str);
        //     $email = new UserConfirmation(
        //         $user,
        //         $user->confirmation_code,
        //         $get_reffer_point,
        //         1
        //     );

        //     Mail::send($email);
        // }
        // fclose($handle);

        // return redirect()
        //     ->back()
        //     ->with(
        //         "success",
        //         __("strings.emails.auth.confirmation.doi_success")
        //     );



       //       echo $startOfLastMonth = Carbon::create(2025, 6, 1)->startOfDay();   // 2025-06-01 00:00:00
       // echo  $endOfLastMonth   = Carbon::create(2025, 7, 31)->endOfDay();
       // exit;
           $activeUsers1 =DB::table("users_indian")->where('run_status',0)->limit(29)->get();
        $stateToRegionMapping='';
        foreach($activeUsers1 as $user)
        {

                $new_data = [];
                $answersArray=[];
                if($user->zipcode!=''){
                $code['age'] = 'GLOBAL_AGE';
                $code['gender'] = 'GLOBAL_GENDER';
                $code['zip'] = 'GLOBAL_ZIP';
                $gender = \Crypt::decrypt($user->gender);
                if ($gender == 'Male' || $gender == 'male' || $gender == 'Masculino' || $gender == 'mâle' || $gender == 'homme' || $gender == 'Mâle' || $gender == 'Homme') {
                    $gender = 1;
                } else if ($gender == 'Female' || $gender == 'Hembra' || $gender == 'femelle' || $gender == 'femme' || $gender == 'Femelle' || $gender == 'Femme') {
                    $gender = 2;
                }

                  $zip_code = \Crypt::decrypt($user->zipcode);
                
                $dob = $user->dob;
                $country = $user->country_code;
                $age = date_diff(date_create($dob), date_create('today'))->y;
                $basic_profile_general_name = 'MY_PROFILE';

                [$state, $city, $region, $stateAbbreviation] = $this->getCity($user->country, $zip_code);
                $cityName = $city ?? null;
                $preCode = $this->CheckIndiaCity($cityName);

                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => 'STANDARD_INDIAN_CITIES',
                    'selected_answer' => [$preCode]
                ];
                $stateName = $state;
                $preCode = $this->CheckIndiaState($stateName);
                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => 'STANDARD_INDIAN_STATE',
                    'selected_answer' => [$preCode]
                ];
                 
                $basic_profile_general_name = 'BASIC';

                foreach ($code  as $key => $value) {
                    if ($key == 'age') {
                        $answersArray[] = [
                            'profile_section_code' => $basic_profile_general_name,
                            'profile_question_code' => 'GLOBAL_AGE',
                            'selected_answer' => [$age]
                        ];
                    } elseif ($key == 'gender') {
                        $answersArray[] = [
                            'profile_section_code' => $basic_profile_general_name,
                            'profile_question_code' => 'GLOBAL_GENDER',
                            'selected_answer' => [$gender]
                        ];
                    } elseif ($key == 'zip') {
                        $answersArray[] = [
                            'profile_section_code' => $basic_profile_general_name,
                            'profile_question_code' => 'GLOBAL_ZIP',
                            'selected_answer' => [$zip_code]
                        ];
                    }
                }

                //$new_data = $answersArray;
                $get_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)
                    ->first();
                if ($get_user_add_data->user_answers) 
                {
                    //$new_data = [];

                            $userAnswers = collect($get_user_add_data->user_answers);
                            $basicProfile = $userAnswers
                                ->where('profile_section_code', '=', 'BASIC');
                            $newUserAnswers = $userAnswers
                                ->where('profile_section_code', '!=', 'BASIC')
                                ->toArray();

                            if ($basicProfile->isEmpty()) {
                                $new_data = $answersArray;
                            } else {
                                foreach ($basicProfile as $basic_user_answers) {
                                    foreach ($answersArray as $answer) {
                                        if ($answer['profile_question_code'] == $basic_user_answers['profile_question_code']) {
                                            $new_data[] = [
                                                'profile_section_code' => $basic_user_answers['profile_section_code'],
                                                'profile_question_code' => $basic_user_answers['profile_question_code'],
                                                'selected_answer' => $answer['selected_answer'],
                                            ];
                                        }
                                    }
                                }
                            }

                            $new_data = $answersArray;
                        
                                   
                                if(!empty($new_data)){
                                            $newUserAnswers = array_merge( $newUserAnswers, $new_data);
                                        }
                                    UserAdditionalData::where('uuid', $user->uuid)
                                    ->push('user_answers', $newUserAnswers, true);
                                                            
                                    DB::table('users_indian')->where('uuid', $user->uuid)->update(array('run_status' => 1)); 

                        }else{
                            $new_data= $answersArray;
                            if(!empty($new_data)){
                                $newUserAnswers = $new_data;
                            }

                             UserAdditionalData::where('uuid', $user->uuid)

                            ->push('user_answers', $newUserAnswers, true);
                           DB::table('users_indian')->where('uuid', $user->uuid)->update(array('run_status' => 1)); 

                    if (!empty($new_data)) {
                        $newUserAnswers = array_merge($newUserAnswers, $new_data);
                    }
                    
                    $user_Add_data = UserAdditionalData::where('uuid', '=', $user->uuid)
                        ->first();
                    $user_Add_data->user_answers = $newUserAnswers;
                    $user_Add_data->save();
                    DB::table('users_indian')->where('uuid', $user->uuid)->update(array('run_status' => 1));
                } 
            
        
        }
        $activeUserstotal = DB::table("users_indian")->count();
        $activeUsersrunning = DB::table("users_indian")->where('run_status', 1)->count();

        echo "Total Records=" . $activeUserstotal . "<br>";
        echo "Total Records Updated=" . $activeUsersrunning . "<br>";
        echo "Pending Entries=" . ($activeUserstotal - $activeUsersrunning);

        } 
            

    }

    public function nomineeCount()
    {
        return view("backend.nominee_count.index")->with("blacklisted_ips", "");
    }

    /**
     * Function Name : Monthly Award
     * Created by : Priyanka(11-june-2024)
     **/

    public function monthlyAward(ManageUserRequest $request)
    {

        Cache::forget('usersfilter');

        Cache::forget('users');

        // $users=Cache::get('users');
        // print_r($users);
        //exit;


        $seconds = 7200;
        if ($request->input()) {
            if (!empty($_GET['fromDate']) && !empty($_GET['toDate'])) {

                $users = Cache::remember('usersfilter', $seconds, function () use ($request) {


                    return $this->userRepository->getFilterUsers($request->input());
                });
            } else {
                return \Redirect::back()->withErrors(
                    "Please select from date & to date."
                );
            }
        } else {
            $users = Cache::remember('users', 60 * 24 * 30, function () {
                return $this->userRepository->getFilterUsers();
            });
        }
        $user = auth()->user();

        /* $activeUsers1 = user::with(

            [
                "roles" => function ($q) {
                    $q->where("role_id", "4");
                },
            ],
            "permissions",
            "providers"
        )
            ->active()
            // ->confirmed()
            // ->orderByRaw('created_at DESC, NOW() DESC')
            ->orderBy("created_at", "desc")
            ->get();*/
        $activeUsers1 = $users;
        $stateToRegionMapping = [
            // Northeast
            "CT" => "Northeast",
            "ME" => "Northeast",
            "MA" => "Northeast",
            "NH" => "Northeast",
            "RI" => "Northeast",
            "VT" => "Northeast",
            "NJ" => "Northeast",
            "NY" => "Northeast",
            "PA" => "Northeast",
            "DE" => "Northeast", // Delaware
            "MD" => "Northeast", // Maryland
            "DC" => "Northeast", // District of Columbia
            "WV" => "Northeast", // West Virginia

            // South
            "VA" => "South",
            "NC" => "South",
            "SC" => "South",
            "GA" => "South",
            "FL" => "South",
            "AL" => "South",
            "MS" => "South",
            "TN" => "South",
            "KY" => "South",
            "LA" => "South",
            "AR" => "South",
            "OK" => "South",
            "TX" => "South",

            // Midwest
            "OH" => "Midwest",
            "MI" => "Midwest",
            "IN" => "Midwest",
            "IL" => "Midwest",
            "WI" => "Midwest",
            "MN" => "Midwest",
            "IA" => "Midwest",
            "MO" => "Midwest",
            "KS" => "Midwest",
            "NE" => "Midwest",
            "SD" => "Midwest",
            "ND" => "Midwest",

            // West
            "WA" => "West",
            "OR" => "West",
            "CA" => "West",
            "NV" => "West",
            "ID" => "West",
            "MT" => "West",
            "WY" => "West",
            "CO" => "West",
            "UT" => "West",
            "AZ" => "West",
            "NM" => "West",
            "AK" => "West",
            "HI" => "West",

            // India
            /*"AP" => "India",
        "AR" => "India",
        "AS" => "India",
        "BR" => "India",
        "CG" => "India",
        "GA" => "India",
        "GJ" => "India",
        "HR" => "South West",
        "GJ" => "West",
        "GJ" => "India",
        "DL" => "North",
        "WB" => "East" ,
        "CH" => "North",*/
        ];

        //$userrs = User::select('zipcode', 'country', 'panellist_id')->get();
        $usersData = [];
        $cityname = [];
        $userData = [];
        foreach ($activeUsers1 as $userr) {
            $zipcode = $userr->zipcode;
            $country = $userr->country;
            $panellist_id = $userr->panellist_id;

            // Check if the zipcode is empty or null, then skip this user
            if (empty($zipcode)) {
                continue;
            }
            $pro_filled_data = UserAdditionalData::where(
                "uuid",
                $userr->uuid
            )->first();
            $state = $this->getStateFromZipCode(
                $zipcode,
                $country,
                $panellist_id,
                $stateToRegionMapping
            );
            if ($state !== null) {
                if (!empty($pro_filled_data)) {
                    foreach ($pro_filled_data->user_answers as $key => $value) {
                        if (!empty($value)) {
                            if (
                                @$value["profile_question_code"] == "DMA_NAME"
                            ) {
                                $cityname[$userr->panellist_id] =
                                    $value["selected_answer"][0];
                            }
                        } else {
                            $cityname[$userr->panellist_id] = "";
                        }
                    }
                }

                // Do something with $state, for example, add it to the usersData array
                //$stateName = $state[0] ?? null;
                $stateName = $state[3] ?? null;
                $cityName = $state[1] ?? null;
                $regionName = $state[2] ?? "-";

                $userData[$userr->panellist_id] = [
                    "state" => $stateName,
                    "city" => $cityname[$userr->panellist_id] ?? null,
                    "region" => $regionName,
                ];

                // Add user data to the usersData array
            }
        }

        $usersData[] = $userData;
        if (isset(session()->get("current_user")->id)) {
            $userid = session()->get("current_user")->id;
        } else {
            $userid = auth()->id();
        }

        return view("backend.auth.user.monthly-award")
            ->withUsers($users)
            ->with("userid", $userid)
            ->with("usersData", $usersData);
    }
    /* function created by Parshant Sharma [10 june'2024] */
    public function surveyParticipation(ManageUserRequest $request)
    {


        // $timePeriod = $request->get('timeperiod');
        // $fromDate = $request->get('fromDate');
        // $toDate = $request->get('toDate');
        // $selectPeriod = true;
        // $country = $request->get("country") ? $request->get("country") : "US";
        // if (!empty($fromDate) && !empty($toDate)) {
        //     $selectPeriod = false;
        // } elseif (!empty($timePeriod)) {
        //     $timePeriod = $timePeriod;
        // } else {
        //     $timePeriod = 30;
        // }

        // if ($selectPeriod) {
        //     $fromLastDays = now()->subDays($timePeriod)->endOfDay();
        //     $trafficStats = $this->userRepository->getRealPanelists(null, null, $fromLastDays, $country);
        // } else {
        //     $trafficStats = $this->userRepository->getRealPanelists($fromDate, $toDate, null, $country);
        // }
        //  return view('backend.auth.user.survey-participation', [
        //     'country' => $country,
        //     'trafficStats' => $trafficStats ?? []
        // ]);
        // // ✅ Handle AJAX request (DataTables)
        // if ($request->ajax()) {
        //     if ($trafficStats instanceof \Illuminate\Support\Collection) {
        //         $trafficStats = $trafficStats->all();
        //     }

        //     $start = $request->input('start', 0);
        //     $length = $request->input('length', 25);
        //     $searchValue = $request->input('search.value', '');
        //     $orderColumnIndex = $request->input('order.0.column', 7);
        //     $orderDirection = $request->input('order.0.dir', 'desc');

        //     // 🔍 Filtering
        //     if (!empty($searchValue)) {
        //         $trafficStats = array_filter($trafficStats, function ($item) use ($searchValue) {
        //             $firstName = is_array($item) ? ($item['first_name'] ?? '') : ($item->first_name ?? '');
        //             $panellistId = is_array($item) ? ($item['panelist_id'] ?? '') : ($item->panelist_id ?? '');
        //             $projectCode = is_array($item) ? ($item['project_code'] ?? '') : ($item->project_code ?? '');
        //             $respId = is_array($item) ? ($item['RespID'] ?? '') : ($item->RespID ?? '');

        //             return stripos($firstName, $searchValue) !== false ||
        //                 stripos($panellistId, $searchValue) !== false ||
        //                 stripos($projectCode, $searchValue) !== false ||
        //                 stripos($respId, $searchValue) !== false;
        //         });
        //     }


        //     // 🔃 Sorting
        //     usort($trafficStats, function ($a, $b) use ($orderColumnIndex, $orderDirection) {
        //         $columns = [
        //             'first_name', 'panelist_id', 'project_code', 'RespID',
        //             'channel_id', 'status_name', 'resp_status_name', 'started_at',
        //             'cpi', 'proj_cpi', 'user_project_status','device_type' ,'unsubscribed','is_blacklist','deactivate','deleted_at','device_type','approval_status'
        //         ];
        //         $columnName = $columns[$orderColumnIndex] ?? 'started_at';

        //         $valueA = is_array($a) ? ($a[$columnName] ?? '') : ($a->{$columnName} ?? '');
        //         $valueB = is_array($b) ? ($b[$columnName] ?? '') : ($b->{$columnName} ?? '');

        //         return $orderDirection === 'asc' ? $valueA <=> $valueB : $valueB <=> $valueA;
        //     });

        //     // 📊 Pagination
        //     $paginatedData = array_slice($trafficStats, $start, $length);

        //     // 🧾 Format Data
        //     $formattedData = array_map(function ($item) {
        //         if (is_object($item)) {
        //             return [
        //                 'first_name' => $item->first_name ?? '',
        //                 'panelist_id' => $item->panelist_id ?? '',
        //                 'project_code' => $item->project_code ?? '',
        //                 'RespID' => $item->RespID ?? '',
        //                 'channel_id' => $item->channel_id ?? 0,
        //                 'status_name' => $item->status_name ?? '',
        //                 'resp_status_name' => $item->resp_status_name ?? '',
        //                 'started_at' => $item->started_at ?? null,
        //                 'cpi' => $item->cpi ?? 0,
        //                 'proj_cpi' => $item->proj_cpi ?? 0,
        //                 'user_project_status' => $item->user_project_status ?? null,
        //                 'unsubscribed' => $item->unsubscribed,
        //                 'device_type' => $item->device_type ?? 'Web',
        //                 'is_blacklist' => $item->is_blacklist,
        //                 'deactivate' => $item->deactivate,
        //                 'deleted_at' => $item->deleted_at,
        //                 'device_type' => $item->device_type,
        //                 'approval_status' => $item->approval_status,
        //             ];
        //         }
        //         return $item;
        //     }, $paginatedData);

        //     return response()->json([
        //         "draw" => intval($request->input('draw')),
        //         "recordsTotal" => count($trafficStats),
        //         "recordsFiltered" => count($trafficStats),
        //         "data" => $formattedData
        //     ]);
        // }

        // // 🖥️ Normal page load
        // return view('backend.auth.user.survey-participation', [
        //     'country' => $country,
        //     'trafficStats' => $trafficStats ?? []
        // ]);
        // dd('fgdf');
        $timePeriod = $request->get('timeperiod');
        $fromDate   = $request->get('fromDate');
        $toDate     = $request->get('toDate');
        $selectPeriod = true;
        $country = $request->get("country") ? $request->get("country") : "US";

        if (!empty($fromDate) && !empty($toDate)) {

            $selectPeriod = false;
        } elseif (!empty($timePeriod)) {
            $timePeriod = $timePeriod;
        } else {
            $timePeriod = 30;
        }

        if ($selectPeriod) {

             $fromLastDays = now()->subDays($timePeriod)->endOfDay();
           

            $trafficStats = $this->userRepository->getRealPanelists(null, null, $fromLastDays, $country);
        } else {
            $trafficStats = $this->userRepository->getRealPanelists($fromDate, $toDate, null, $country);
        }
        // ✅ Handle AJAX request (DataTables)
        if ($request->ajax()) {
            if ($trafficStats instanceof \Illuminate\Support\Collection) {
                $trafficStats = $trafficStats->all();
            }

            $start = $request->input('start', 0);
            $length = $request->input('length', 25);
            $searchValue = $request->input('search.value', '');
            $orderColumnIndex = $request->input('order.0.column', 7);
            $orderDirection = $request->input('order.0.dir', 'desc');

            // 🔍 Filtering
            if (!empty($searchValue)) {
                $trafficStats = array_filter($trafficStats, function ($item) use ($searchValue) {
                    $firstName = is_array($item) ? ($item['first_name'] ?? '') : ($item->first_name ?? '');
                    $panellistId = is_array($item) ? ($item['panelist_id'] ?? '') : ($item->panelist_id ?? '');
                    $projectCode = is_array($item) ? ($item['project_code'] ?? '') : ($item->project_code ?? '');
                    $respId = is_array($item) ? ($item['RespID'] ?? '') : ($item->RespID ?? '');

                    return stripos($firstName, $searchValue) !== false ||
                        stripos($panellistId, $searchValue) !== false ||
                        stripos($projectCode, $searchValue) !== false ||
                        stripos($respId, $searchValue) !== false;
                });
            }


            // 🔃 Sorting
            usort($trafficStats, function ($a, $b) use ($orderColumnIndex, $orderDirection) {
                $columns = [
                    'first_name',
                    'panelist_id',
                    'project_code',
                    'RespID',
                    'channel_id',
                    'status_name',
                    'resp_status_name',
                    'started_at',
                    'cpi',
                    'proj_cpi',
                    'user_project_status',
                    'device_type',
                    'unsubscribed',
                    'is_blacklist',
                    'deactivate',
                    'deleted_at',
                    'device_type',
                    'approval_status'
                ];
                $columnName = $columns[$orderColumnIndex] ?? 'started_at';

                $valueA = is_array($a) ? ($a[$columnName] ?? '') : ($a->{$columnName} ?? '');
                $valueB = is_array($b) ? ($b[$columnName] ?? '') : ($b->{$columnName} ?? '');

                return $orderDirection === 'asc' ? $valueA <=> $valueB : $valueB <=> $valueA;
            });

            // 📊 Pagination
            $paginatedData = array_slice($trafficStats, $start, $length);

            // 🧾 Format Data
            $formattedData = array_map(function ($item) {
                if (is_object($item)) {
                    return [
                        'first_name' => $item->first_name ?? '',
                        'panelist_id' => $item->panelist_id ?? '',
                        'project_code' => $item->project_code ?? '',
                        'RespID' => $item->RespID ?? '',
                        'channel_id' => $item->channel_id ?? 0,
                        'status_name' => $item->status_name ?? '',
                        'resp_status_name' => $item->resp_status_name ?? '',
                        'started_at' => $item->started_at ?? null,
                        'cpi' => $item->cpi ?? 0,
                        'proj_cpi' => $item->proj_cpi ?? 0,
                        'user_project_status' => $item->user_project_status ?? null,
                        'unsubscribed' => $item->unsubscribed,
                        'device_type' => $item->device_type ?? '-',
                        'is_blacklist' => $item->is_blacklist,
                        'deactivate' => $item->deactivate,
                        'deleted_at' => $item->deleted_at,
                        'device_type' => $item->device_type,
                        'approval_status' => $item->approval_status,
                    ];
                }
                return $item;
            }, $paginatedData);

            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => count($trafficStats),
                "recordsFiltered" => count($trafficStats),
                "data" => $formattedData
            ]);
        }


        return view('backend.auth.user.survey-participation')
            ->with('country', $country)
            ->with('trafficStats', $trafficStats);
    }

    public function exportSurveyParticipation(ManageUserRequest $request)
    {
        $timePeriod = $request->get('timeperiod');
        $fromDate = $request->get('fromDate');
        $toDate = $request->get('toDate');
        $country = $request->get("country") ?: "US";
        $format = $request->get('format', 'csv');
        $selectPeriod = true;
        $searchValue = $request->get('search');
        $orderColumnIndex = $request->get('order_column', 7);
        $orderDirection = $request->get('order_dir', 'desc');
        if (!empty($fromDate) && !empty($toDate)) {
            $selectPeriod = false;
        } elseif (!empty($timePeriod)) {
            $timePeriod = $timePeriod;
        } else {
            $timePeriod = 30;
        }
        if ($selectPeriod) {
            $fromLastDays = now()->subDays($timePeriod)->endOfDay();
            $trafficStats = $this->userRepository->getRealPanelists(null, null, $fromLastDays, $country);
        } else {
            $trafficStats = $this->userRepository->getRealPanelists($fromDate, $toDate, null, $country);
        }

        // Convert to array if Collection
        if ($trafficStats instanceof \Illuminate\Support\Collection) {
            $trafficStats = $trafficStats->all();
        }

        // Filtering (same as surveyParticipation)
        if (!empty($searchValue)) {
            $trafficStats = array_filter($trafficStats, function ($item) use ($searchValue) {
                $firstName = is_array($item) ? ($item['first_name'] ?? '') : ($item->first_name ?? '');
                $panellistId = is_array($item) ? ($item['panelist_id'] ?? '') : ($item->panelist_id ?? '');
                $projectCode = is_array($item) ? ($item['project_code'] ?? '') : ($item->project_code ?? '');
                $respId = is_array($item) ? ($item['RespID'] ?? '') : ($item->RespID ?? '');
                $statusName = is_array($item) ? ($item['status_name'] ?? '') : ($item->status_name ?? '');
                $approvalStatus = is_array($item) ? ($item['approval_status'] ?? '') : ($item->approval_status ?? '');

                return stripos($firstName, $searchValue) !== false ||
                    stripos($panellistId, $searchValue) !== false ||
                    stripos($projectCode, $searchValue) !== false ||
                    stripos($statusName, $searchValue) !== false ||
                    stripos($approvalStatus, $searchValue) !== false ||
                    stripos($respId, $searchValue) !== false;
            });
        }

        // Sorting
        usort($trafficStats, function ($a, $b) use ($orderColumnIndex, $orderDirection) {
            $columns = [
                'first_name',
                'panelist_id',
                'project_code',
                'RespID',
                'channel_id',
                'status_name',
                'resp_status_name',
                'started_at',
                'cpi',
                'proj_cpi',
                'user_project_status',
                'device_type',
                'unsubscribed',
                'is_blacklist',
                'deactivate',
                'deleted_at',
                'device_type',
                'approval_status'
            ];
            $columnName = $columns[$orderColumnIndex] ?? 'started_at';

            $valueA = is_array($a) ? ($a[$columnName] ?? '') : ($a->{$columnName} ?? '');
            $valueB = is_array($b) ? ($b[$columnName] ?? '') : ($b->{$columnName} ?? '');

            return $orderDirection === 'asc' ? $valueA <=> $valueB : $valueB <=> $valueA;
        });


        if ($format === 'excel') {
            // Generate Excel (XML) format
            $xml = '<?xml version="1.0"?>
            <ss:Workbook xmlns:ss="urn:schemas-microsoft-com:office:spreadsheet">
                <ss:Worksheet ss:Name="Survey Participation">
                    <ss:Table>
                        <ss:Row>';

            // Add headers
            $headers = [
                'First Name',
                'Panelist ID',
                'Survey ID',
                'Respondent ID',
                'Channel Name',
                'Survey Status',
                'Respondent Status',
                'Approved Status',
                'Survey Attempted Date',
                'Survey Incentive Amount',
                'Incentive credit date',
                'Unsubscribed',
                'Blacklisted',
                'Deactivated',
                'Deleted',
                'Platform'
            ];

            foreach ($headers as $header) {
                $xml .= '<ss:Cell><ss:Data ss:Type="String">' . htmlspecialchars($header) . '</ss:Data></ss:Cell>';
            }
            $xml .= '</ss:Row>';

            // Add data rows
            foreach ($trafficStats as $item) {
                $xml .= '<ss:Row>';
                $data = [
                    $item->first_name ?? '',
                    $item->panelist_id ?? '',
                    $item->project_code ?? '',
                    $item->RespID ?? '',
                    $item->channel_id == 1 || $item->channel_id == 0 ? 'Dashboard' : ($item->channel_id == 2 ? 'Email' : ''),
                    $item->status_name ? ucfirst(strtolower($item->status_name)) : 'Abandon',
                    $item->resp_status_name ? ucfirst(strtolower($item->resp_status_name)) : 'Abandon',
                    $item->approval_status == 50 ? 'Approved' : ($item->approval_status == 5 ? 'Rejected' : 'Pending'),
                    $item->started_at ? \Carbon\Carbon::parse($item->started_at)->format('Y M d H:i:s') : '',
                    $item->proj_cpi ? ($item->proj_cpi * 1000) : ($item->cpi ? ($item->cpi * 1000) : 0),
                    $item->approval_status == 50 ? ($item->started_at ? \Carbon\Carbon::parse($item->started_at)->format('Y M d') : '') : '',
                    $item->unsubscribed ?? 'No',
                    $item->is_blacklist ?? 'No',
                    $item->deactivate ?? 'No',
                    $item->deleted_at ? 'Yes' : 'No',
                    $item->device_type ?? 'Web'
                ];

                foreach ($data as $value) {
                    $xml .= '<ss:Cell><ss:Data ss:Type="String">' . htmlspecialchars($value) . '</ss:Data></ss:Cell>';
                }
                $xml .= '</ss:Row>';
            }

            $xml .= '</ss:Table>
                </ss:Worksheet>
            </ss:Workbook>';

            $headers = [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="survey_participation_' . date('YmdHis') . '.xls"',
            ];

            return response($xml, 200, $headers);
        } else {
            // Generate CSV format
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="survey_participation_' . date('YmdHis') . '.csv"',
            ];

            $callback = function () use ($trafficStats) {
                $file = fopen('php://output', 'w');

                // Add CSV headers
                fputcsv($file, [
                    'First Name',
                    'Panelist ID',
                    'Survey ID',
                    'Respondent ID',
                    'Channel Name',
                    'Survey Status',
                    'Respondent Status',
                    'Approved Status',
                    'Survey Attempted Date',
                    'Survey Incentive Amount',
                    'Incentive credit date',
                    'Unsubscribed',
                    'Blacklisted',
                    'Deactivated',
                    'Deleted',
                    'Platform'
                ]);

                // Add data rows
                foreach ($trafficStats as $item) {
                    fputcsv($file, [
                        $item->first_name ?? '',
                        $item->panelist_id ?? '',
                        $item->project_code ?? '',
                        $item->RespID ?? '',
                        $item->channel_id == 1 || $item->channel_id == 0 ? 'Dashboard' : ($item->channel_id == 2 ? 'Email' : ''),
                        $item->status_name ? ucfirst(strtolower($item->status_name)) : 'Abandon',
                        $item->resp_status_name ? ucfirst(strtolower($item->resp_status_name)) : 'Abandon',
                        $item->approval_status == 50 ? 'Approved' : ($item->approval_status == 5 ? 'Rejected' : 'Pending'),
                        $item->started_at ? \Carbon\Carbon::parse($item->started_at)->format('Y M d H:i:s') : '',
                        $item->proj_cpi ? ($item->proj_cpi * 1000) : ($item->cpi ? ($item->cpi * 1000) : 0),
                        $item->approval_status == 50 ? ($item->started_at ? \Carbon\Carbon::parse($item->started_at)->format('Y M d') : '') : '',
                        $item->unsubscribed ?? 'No',
                        $item->is_blacklist ?? 'No',
                        $item->deactivate ?? 'No',
                        $item->deleted_at ? 'Yes' : 'No',
                        $item->device_type ?? 'Web'
                    ]);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
    }

    public function getCountryLanguage(Request $request)
    {
        $country_code = $request->country_code;
        $language = $this->userRepository->getCountry($country_code);
        return response()->json($language);
    }

    public function conversionRate(Request $request)
    {
        $timePeriod = $request->get('timeperiod');
        $fromDate   = $request->get('fromDate');
        $toDate     = $request->get('toDate');
        $country    = $request->get('country') ?? null;
        $selectPeriod = true;
        if (!empty($fromDate) && !empty($toDate)) {
            $selectPeriod = false;
        } elseif (!empty($timePeriod)) {
            $timePeriod = $timePeriod;
        } else {
            $timePeriod = 30;
        }
        if ($selectPeriod) {
            $fromLastDays = now()->subDays($timePeriod)->endOfDay();
            $trafficStats = $this->userRepository->getRealPanelistsAttemptedCompletedSurveys(null, null, $fromLastDays, $country);
        } else {
            $trafficStats = $this->userRepository->getRealPanelistsAttemptedCompletedSurveys($fromDate, $toDate, null, $country);
        }
        // Check if request is AJAX
        if ($request->ajax()) {
            return response()->json([
                'totalCompletedSurveys' => $trafficStats['totalCompletedSurveys'] ?? 0,
                'totalAttemptedSurveys' => $trafficStats['totalAttemptedSurveys'] ?? 0,
            ]);
        }
        return view('backend.auth.conversion_rate.conversion-rate', compact('trafficStats', 'timePeriod'));
    }


    private function savePanellistAddress($panellistData = null)
    {
        try {
            PanellistAddress::firstOrCreate(
                ['user_id' => $panellistData['user_id']],
                $panellistData
            );
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }
    }

     private function getCity($country_code,$zipcode){
        //$url = "https://api.postalpincode.in/pincode/{$zipcode}";
        $url = "https://api.zippopotam.us/IN/{$zipcode}";

        //dd($url);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            // cURL request failed
            // echo "Error: " . curl_error($ch);
            return null;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            // HTTP request failed
            // echo "HTTP Error: " . $http_code;
            return null;
        }

        $data = json_decode($response, true);
        //dd($data);        

        /*if (isset($data[0]['PostOffice'][0])) {
            $postOffice = $data[0]['PostOffice'][0]; 

            $state = $postOffice['State'];
            $city = $postOffice['Region'];

            // Extract state abbreviation
            $stateAbbreviation = $postOffice["Region"];

            // Determine region based on state abbreviation
            $region = $stateToRegionMapping[$stateAbbreviation] ?? "-";

            return [$state, $city, $postOffice["Region"], $stateAbbreviation];
        }*/
        if (isset($data["places"][0])) {
            $state = $data["places"][0]["state"];
            $city = $data["places"][0]["place name"];

            // Extract state abbreviation
            $stateAbbreviation = $data["places"][0]["state abbreviation"];

            // Determine region based on state abbreviation
            $region = $stateToRegionMapping[$stateAbbreviation] ?? "-";

            return [$state, $city, $region, $stateAbbreviation];
        }
         else {
            // ZIP code not found
            return null;
        }
    }

    private function CheckIndiaCity($cityname)
    {


            $cityMap = [
                '1'   => 'Delhi',
    '2'   => 'Lucknow',
    '3'   => 'Kanpur',
    '4'   => 'Mumbai',
    '5'   => 'Hyderabad',
    '6'   => 'Coimbatore',
    '7'   => 'Vijayawada',
    '8'   => 'Chennai',
    '9'   => 'Agra',
    '10'  => 'Ahmedabad',
    '11'  => 'Ajmer',
    '12'  => 'Aligarh',
    '13'  => 'Allahabad',
    '14'  => 'Amravati',
    '15'  => 'Amritsar',
    '16'  => 'Asansol',
    '17'  => 'Aurangabad',
    '18'  => 'Bangalore',
    '19'  => 'Bareilly',
    '20'  => 'Belgaum',
    '21'  => 'Bhavnagar',
    '22'  => 'Bhilai',
    '23'  => 'Bhiwandi',
    '24'  => 'Bhopal',
    '25'  => 'Bhubaneswar',
    '26'  => 'Bijapur',
    '27'  => 'Bikaner',
    '28'  => 'Bilaspur',
    '29'  => 'Bokaro',
    '30'  => 'Chandigarh',
    '31'  => 'Cuttack',
    '32'  => 'Dehradun',
    '33'  => 'Dhanbad',
    '34'  => 'Dharwad',
    '35'  => 'Durgapur',
    '36'  => 'Erode',
    '37'  => 'Faridabad',
    '38'  => 'Firozabad',
    '39'  => 'Ghaziabad',
    '40'  => 'Goa',
    '41'  => 'Gorakhpur',
    '42'  => 'Gulbarga',
    '43'  => 'Guntur',
    '44'  => 'Gurgaon',
    '45'  => 'Guwahati',
    '46'  => 'Gwalior',
    '47'  => 'Hamirpur',
    '48'  => 'Hubli',
    '49'  => 'Indore',
    '50'  => 'Jabalpur',
    '51'  => 'Jaipur',
    '52'  => 'Jalandhar',
    '53'  => 'Jammu',
    '54'  => 'Jamnagar',
    '55'  => 'Jamshedpur',
    '56'  => 'Jhansi',
    '57'  => 'Jodhpur',
    '58'  => 'Kakinada',
    '59'  => 'Kannur',
    '60'  => 'Kochi',
    '61'  => 'Kolhapur',
    '62'  => 'Kolkata',
    '63'  => 'Kollam',
    '64'  => 'Kota',
    '65'  => 'Kottayam',
    '66'  => 'Kozhikode',
    '67'  => 'Kurnool',
    '68'  => 'Ludhiana',
    '69'  => 'Madurai',
    '70'  => 'Malappuram',
    '71'  => 'Mangalore',
    '72'  => 'Mathura',
    '73'  => 'Meerut',
    '74'  => 'Moradabad',
    '75'  => 'Mysore',
    '76'  => 'Nagpur',
    '77'  => 'Nanded',
    '78'  => 'Nashik',
    '79'  => 'Nellore',
    '80'  => 'Noida',
    '81'  => 'Palakkad',
    '82'  => 'Patna',
    '83'  => 'Pondicherry',
    '84'  => 'Pune',
    '85'  => 'Purulia',
    '86'  => 'Raipur',
    '87'  => 'Rajahmundry',
    '88'  => 'Rajkot',
    '89'  => 'Ranchi',
    '90'  => 'Rourkela',
    '91'  => 'Salem',
    '92'  => 'Sangli',
    '93'  => 'Shimla',
    '94'  => 'Siliguri',
    '96'  => 'Srinagar',
    '97'  => 'Solapur',
    '98'  => 'Surat',
    '99'  => 'Thiruvananthapuram',
    '100' => 'Thrissur',
    '101' => 'Tiruchirappalli',
    '102' => 'Tiruppur',
    '103' => 'Ujjain',
    '104' => 'Vadodara',
    '105' => 'Varanasi',
    '106' => 'Vasai-Virar',
    '107' => 'Vellore',
    '108' => 'Visakhapatnam',
    '109' => 'Warangal',
    '110' => 'Rest of India',
    '111' => 'Paderu',
    '112' => 'Anakapalli',
    '113' => 'Ananthapuramu',
    '114' => 'Rayachoti',
    '115' => 'Bapatla',
    '116' => 'Chittoor',
    '117' => 'Amalapuram',
    '118' => 'Rajamahendravaram',
    '119' => 'Eluru',
    '120' => 'Machilipatnam',
    '121' => 'Kurnool',
    '122' => 'Nandyal',
    '123' => 'Narasaraopet',
    '124' => 'Parvathipuram',
    '125' => 'Ongole',
    '126' => 'Srikakulam',
    '127' => 'Puttaparthi',
    '128' => 'Tirupati',
    '129' => 'Vizianagaram',
    '130' => 'Bhimavaram',
    '131' => 'Kadapa',
    '132' => 'Hawai',
    '133' => 'Changlang',
    '134' => 'Seppa',
    '135' => 'Pasighat',
    '136' => 'Raga',
    '137' => 'Palin',
    '138' => 'Koloriang',
    '139' => 'Basar',
    '140' => 'Tezu',
    '141' => 'Longding',
    '142' => 'Roing',
    '143' => 'Likabali',
    '144' => 'Ziro',
    '145' => 'Namsai',
    '146' => 'Lemmi',
    '147' => 'Yupia',
    '148' => 'Tato',
    '149' => 'Boleng',
    '150' => 'Tawang',
    '151' => 'Khonsa',
    '152' => 'Anini',
    '153' => 'Yingkiong',
    '154' => 'Daporijo',
    '155' => 'Bomdila',
    '156' => 'Aalo',
    '157' => 'Yachuli',
    '158' => 'Napangphung',
    '159' => 'Mushalpur',
    '160' => 'Pathsala',
    '161' => 'Barpeta',
    '162' => 'Biswanath Chariali',
    '163' => 'Bongaigaon',
    '164' => 'Silchar',
    '165' => 'Sonari',
    '166' => 'Kajalgaon',
    '167' => 'Mangaldoi',
    '168' => 'Dhemaji',
    '169' => 'Dhubri',
    '170' => 'Dibrugarh',
    '171' => 'Haflong',
    '172' => 'Goalpara',
    '173' => 'Golaghat',
    '174' => 'Hailakandi',
    '175' => 'Sankardev Nagar',
    '176' => 'Jorhat',
    '177' => 'Amingaon',
    '178' => 'Diphu',
    '179' => 'Karimganj',
    '180' => 'Kokrajhar',
    '181' => 'North Lakhimpur',
    '182' => 'Garamur',
    '183' => 'Marigaon',
    '184' => 'Nagaon',
    '185' => 'Nalbari',
    '186' => 'Sibsagar',
    '187' => 'Tezpur',
    '188' => 'Hatsingimari',
    '189' => 'Tamulpur',
    '190' => 'Tinsukia',
    '191' => 'Udalguri',
    '192' => 'Hamren',
    '193' => 'Araria',
    '194' => 'Arwal',
    '195' => 'Banka',
    '196' => 'Begusarai',
    '197' => 'Bhagalpur',
    '198' => 'Arrah',
    '199' => 'Buxar',
    '200' => 'Darbhanga',
    '201' => 'Motihari',
    '202' => 'Gaya',
    '203' => 'Gopalganj',
    '204' => 'Jamui',
    '205' => 'Jehanabad',
    '206' => 'Bhabua',
    '207' => 'Katihar',
    '208' => 'Khagaria',
    '209' => 'Kishanganj',
    '210' => 'Lakhisarai',
    '211' => 'Madhepura',
    '212' => 'Madhubani',
    '213' => 'Munger',
    '214' => 'Muzaffarpur',
    '215' => 'Bihar Sharif',
    '216' => 'Nawada',
    '217' => 'Purnia',
    '218' => 'Sasaram',
    '219' => 'Saharsa',
    '220' => 'Samastipur',
    '221' => 'Chhapra',
    '222' => 'Sheikhpura',
    '223' => 'Sheohar',
    '224' => 'Sitamarhi',
    '225' => 'Siwan',
    '226' => 'Supaul',
    '227' => 'Hajipur',
    '228' => 'Bettiah',
    '229' => 'Balod',
    '230' => 'Baloda Bazar',
    '231' => 'Balrampur',
    '232' => 'Jagdalpur',
    '233' => 'Bemetara',
    '234' => 'Dantewada',
    '235' => 'Dhamtari',
    '236' => 'Durg',
    '237' => 'Gariaband',
    '238' => 'Gaurela',
    '239' => 'Janjgir',
    '240' => 'Jashpur Nagar',
    '241' => 'Kawardha',
    '242' => 'Kanker',
    '243' => 'Khairagarh',
    '244' => 'Kondagaon',
    '245' => 'Korba',
    '246' => 'Baikunthpur',
    '247' => 'Mahasamund',
    '248' => 'Manendragarh',
    '249' => 'Mohla',
    '250' => 'Mungeli',
    '251' => 'Narayanpur',
    '252' => 'Raigarh',
    '253' => 'Rajnandgaon',
    '254' => 'Sarangarh',
    '255' => 'Sakti',
    '256' => 'Sukma',
    '257' => 'Surajpur',
    '258' => 'Ambikapur',
    '259' => 'Panaji',
    '260' => 'Margao',
    '261' => 'Amreli',
    '262' => 'Anand',
    '263' => 'Modasa',
    '264' => 'Palanpur',
    '265' => 'Bharuch',
    '266' => 'Botad',
    '267' => 'Chhota Udaipur',
    '268' => 'Dahod',
    '269' => 'Ahwa',
    '270' => 'Khambhalia',
    '271' => 'Gandhinagar',
    '272' => 'Veraval',
    '273' => 'Junagadh',
    '274' => 'Nadiad',
    '275' => 'Bhuj',
    '276' => 'Lunavada',
    '277' => 'Mehsana',
    '278' => 'Morbi',
    '279' => 'Rajpipla',
    '280' => 'Navsari',
    '281' => 'Godhra',
    '282' => 'Patan',
    '283' => 'Porbandar',
    '284' => 'Himatnagar',
    '285' => 'Surendranagar',
    '286' => 'Vyara',
    '287' => 'Valsad',
    '288' => 'Tharad',
    '289' => 'Ambala',
    '290' => 'Bhiwani',
    '291' => 'Charkhi Dadri',
    '292' => 'Fatehabad',
    '293' => 'Gurugram',
    '294' => 'Hisar',
    '295' => 'Jhajjar',
    '296' => 'Jind',
    '297' => 'Kaithal',
    '298' => 'Karnal',
    '299' => 'Kurukshetra',
    '300' => 'Narnaul',
     301 => "Nuh",
    302 => "Palwal",
    303 => "Panchkula",
    304 => "Panipat",
    305 => "Rewari",
    306 => "Rohtak",
    307 => "Sirsa",
    308 => "Sonipat",
    309 => "Yamunanagar",
    310 => "Bilaspur",
    311 => "Chamba",
    312 => "Hamirpur",
    313 => "Dharamshala",
    314 => "Reckong Peo",
    315 => "Kullu",
    316 => "Keylong",
    317 => "Mandi",
    318 => "Nahan",
    319 => "Solan",
    320 => "Una",
    321 => "Chatra",
    322 => "Deoghar",
    323 => "Dumka",
    324 => "Garhwa",
    325 => "Giridih",
    326 => "Godda",
    327 => "Gumla",
    328 => "Hazaribag",
    329 => "Jamtara",
    330 => "Khunti",
    331 => "Koderma",
    332 => "Latehar",
    333 => "Lohardaga",
    334 => "Pakur",
    335 => "Daltonganj",
    336 => "Ramgarh",
    337 => "Sahebganj",
    338 => "Seraikela",
    339 => "Simdega",
    340 => "Chaibasa",
    341 => "Bagalkote",
    342 => "Ballari",
    343 => "Bangalore",
    344 => "Bidar",
    345 => "Chamarajanagar",
    346 => "Chikkaballapur",
    347 => "Chikmagalur",
    348 => "Chitradurga",
    349 => "Davangere",
    350 => "Gadag-Betageri",
    351 => "Kalaburagi",
    352 => "Hassan",
    353 => "Haveri",
    354 => "Madikeri",
    355 => "Kolar",
    356 => "Koppal",
    357 => "Mandya",
    358 => "Raichur",
    359 => "Ramanagara",
    360 => "Shimoga",
    361 => "Tumakuru",
    362 => "Udupi",
    363 => "Karwar",
    364 => "Hospete",
    365 => "Bijapur",
    366 => "Yadgir",
    367 => "Alappuzha",
    368 => "Kakkanad",
    369 => "Painavu",
    370 => "Kasaragod",
    371 => "Pathanamthitta",
    372 => "Kalpetta",
    373 => "Agar",
    374 => "Alirajpur",
    375 => "Anuppur",
    376 => "Ashoknagar",
    377 => "Balaghat",
    378 => "Barwani",
    379 => "Betul",
    380 => "Bhind",
    381 => "Burhanpur",
    382 => "Chhatarpur",
    383 => "Chhindwara",
    384 => "Damoh",
    385 => "Datia",
    386 => "Dewas",
    387 => "Dhar",
    388 => "Dindori",
    389 => "Guna",
    390 => "Harda",
    391 => "Hoshangabad",
    392 => "Jhabua",
    393 => "Katni",
    394 => "Khandwa",
    395 => "Khargone",
    396 => "Maihar",
    397 => "Mandla",
    398 => "Mandsaur",
    399 => "Mauganj",
    400 => "Morena",
    401 => "Narsinghpur",
    402 => "Neemuch",
    403 => "Niwari",
    404 => "Panna",
    405 => "Pandhurna",
    406 => "Raisen",
    407 => "Rajgarh",
    408 => "Ratlam",
    409 => "Rewa",
    410 => "Sagar",
    411 => "Satna",
    412 => "Sehore",
    413 => "Seoni",
    414 => "Shahdol",
    415 => "Shajapur",
    416 => "Sheopur",
    417 => "Shivpuri",
    418 => "Sidhi",
    419 => "Waidhan",
    420 => "Tikamgarh",
    421 => "Umaria",
    422 => "Vidisha",
    423 => "Ahmednagar",
    424 => "Akola",
    425 => "Aurangabad",
    426 => "Beed",
    427 => "Bhandara",
    428 => "Buldhana",
    429 => "Chandrapur",
    430 => "Osmanabad",
    431 => "Dhule",
    432 => "Gadchiroli",
    433 => "Gondia",
    434 => "Hingoli",
    435 => "Jalgaon",
    436 => "Jalna",
    437 => "Latur",
    438 => "Bandra (East)",
    439 => "Nandurbar",
    440 => "Palghar",
    441 => "Parbhani",
    442 => "Alibag",
    443 => "Ratnagiri",
    444 => "Satara",
    445 => "Oros",
    446 => "Thane",
    447 => "Wardha",
    448 => "Washim",
    449 => "Yavatmal",
    450 => "Bishnupur",
    451 => "Chandel",
    452 => "Churachandpur",
    453 => "Porompat",
    454 => "Lamphelpat",
    455 => "Jiribam",
    456 => "Kakching",
    457 => "Kamjong",
    458 => "Kangpokpi",
    459 => "Noney (Longmai)",
    460 => "Pherzawl",
    461 => "Senapati",
    462 => "Tamenglong",
    463 => "Tengnoupal",
    464 => "Thoubal",
    465 => "Ukhrul",
    466 => "Williamnagar",
    467 => "Khliehriat",
    468 => "Shillong",
    469 => "Mairang",
    470 => "Resubelpara",
    471 => "Nongpoh",
    472 => "Baghmara",
    473 => "Ampati",
    474 => "Mawkyrwat",
    475 => "Tura",
    476 => "Jowai",
    477 => "Nongstoin",
    478 => "Aizawl",
    479 => "Champhai",
    480 => "Hnahthial",
    481 => "Khawzawl",
    482 => "Kolasib",
    483 => "Lawngtlai",
    484 => "Lunglei",
    485 => "Mamit",
    486 => "Saiha",
    487 => "Saitual",
    488 => "Serchhip",
    489 => "Chufcmoukedima",
    490 => "Dimapur",
    491 => "Kiphire",
    492 => "Kohima",
    493 => "Longleng",
    494 => "Mokokchung",
    495 => "Mon",
    496 => "Niuland",
    497 => "Noklak",
    498 => "Peren",
    499 => "Phek",
    500 => "Shamator",
    501 => "Tseminyu",
    502 => "Tuensang",
    503 => "Wokha",
    504 => "Zunheboto",
    505 => "Angul",
    506 => "Boudh",
    507 => "Bhadrak",
    508 => "Balangir",
    509 => "Bargarh",
    510 => "Balasore",
    511 => "Debagarh",
    512 => "Dhenkanal",
    513 => "Chhatrapur",
    514 => "Paralakhemundi",
    515 => "Jharsuguda",
    516 => "Jajpur",
    517 => "Jagatsinghpur",
    518 => "Khordha",
    519 => "Kendujhar",
    520 => "Phulbani",
    521 => "Koraput",
    522 => "Kendrapara",
    523 => "Malkangiri",
    524 => "Baripada",
    525 => "Nabarangpur",
    526 => "Nuapada",
    527 => "Nayagarh",
    528 => "Puri",
    529 => "Rayagada",
    530 => "Sambalpur",
    531 => "Subarnapur",
    532 => "Sundergarh",
    533 => "Barnala",
    534 => "Bathinda",
    535 => "Faridkot",
    536 => "Fatehgarh Sahib",
    537 => "Fazilka",
    538 => "Firozpur",
    539 => "Gurdaspur",
    540 => "Hoshiarpur",
    541 => "Kapurthala",
    542 => "Malerkotla",
    543 => "Mansa",
    544 => "Moga",
    545 => "Pathankot",
    546 => "Patiala",
    547 => "Rupnagar",
    548 => "Sahibzada Ajit Singh Nagar",
    549 => "Sangrur",
    550 => "Nawanshahr",
    551 => "Sri Muktsar Sahib",
    552 => "Tarn Taran Sahib",
    553 => "Alwar",
    554 => "Balotra",
    555 => "Banswara",
    556 => "Baran",
    557 => "Barmer",
    558 => "Beawar",
    559 => "Bharatpur",
    560 => "Bhilwara",
    561 => "Bundi",
    562 => "Chittorgarh",
    563 => "Churu",
    564 => "Dausa",
    565 => "Deeg",
    566 => "Dholpur",
    567 => "Didwana",
    568 => "Dungarpur",
    569 => "Hanumangarh",
    570 => "Jaisalmer",
    571 => "Jalore",
    572 => "Jhalawar",
    573 => "Jhunjhunu",
    574 => "Karauli",
    575 => "Khairthal",
    576 => "Kotputli",
    577 => "Nagaur",
    578 => "Pali",
    579 => "Phalodi",
    580 => "Pratapgarh",
    581 => "Rajsamand",
    582 => "Salumbar",
    583 => "Sawai Madhopur",
    584 => "Sikar",
    585 => "Sirohi",
    586 => "Sri Ganganagar",
    587 => "Tonk",
    588 => "Udaipur",
    589 => "Gangtok",
    590 => "Gyalshing",
    591 => "Mangan",
    592 => "Namchi",
    593 => "Pakyong",
    594 => "Soreng",
    595 => "Ariyalur",
    596 => "Chengalpattu",
    597 => "Cuddalore",
    598 => "Dharmapuri",
    599 => "Dindigul",
    600 => "Kallakurichi",
    601 => "Kanchipuram",
    602 => "Nagercoil",
    603 => "Karur",
    604 => "Krishnagiri",
    605 => "Mayiladuthurai",
    606 => "Nagapattinam",
    607 => "Ooty",
    608 => "Namakkal",
    609 => "Perambalur",
    610 => "Pudukkottai",
    611 => "Ramanathapuram",
    612 => "Ranipettai",
    613 => "Sivagangai",
    614 => "Tenkasi",
    615 => "Theni",
    616 => "Tirunelveli",
    617 => "Thanjavur",
    618 => "Thoothukudi",
    619 => "Tirupattur",
    620 => "Tiruvallur",
    621 => "Thiruvarur",
    622 => "Tiruvannaamalai",
    623 => "Viluppuram",
    624 => "Virudhunagar",
    625 => "Adilabad",
    626 => "Kothagudem",
    627 => "Hanamkonda",
    628 => "Jagtial",
    629 => "Jangaon",
    630 => "Bhupalpally",
    631 => "Gadwal",
    632 => "Kamareddy",
    633 => "Karimnagar",
    634 => "Khammam",
    635 => "Asifabad",
    636 => "Mahabubabad",
    637 => "Mahbubnagar",
    638 => "Mancherial",
    639 => "Medak",
    640 => "Shamirpet",
    641 => "Mulugu",
    642 => "Nalgonda",
    643 => "Narayanpet",
    644 => "Nirmal",
    645 => "Nizamabad",
    646 => "Peddapalli",
    647 => "Sircilla",
    648 => "Hyderabad",
    649 => "Sangareddy",
    650 => "Siddipet",
    651 => "Suryapet",
    652 => "Vikarabad",
    653 => "Wanaparthy",
    654 => "Bhongir",
    655 => "Ambassa",
    656 => "Udaipur",
    657 => "Khowai",
    658 => "Dharmanagar",
    659 => "Bishramganj",
    660 => "Belonia",
    661 => "Kailashahar",
    662 => "Agartala",
    663 => "Akbarpur",
    664 => "Gauriganj",
    665 => "Amroha",
    666 => "Auraiya",
    667 => "Ayodhya",
    668 => "Azamgarh",
    669 => "Baghpat",
    670 => "Bahraich",
    671 => "Ballia",
    672 => "Balrampur",
    673 => "Banda",
    674 => "Barabanki",
    675 => "Basti",
    676 => "Gyanpur",
    677 => "Bijnor",
    678 => "Budaun",
    679 => "Bulandshahr",
    680 => "Chandauli",
    681 => "Karwi",
    682 => "Deoria",
    683 => "Etah",
    684 => "Etawah",
    685 => "Fatehgarh",
    686 => "Fatehpur",
    687 => "Ghazipur",
    688 => "Gonda",
    689 => "Hapur",
    690 => "Hardoi",
    691 => "Hathras",
    692 => "Orai",
    693 => "Jaunpur",
    694 => "Kannauj",
    695 => "Kanpur",
    696 => "Kasganj",
    697 => "Manjhanpur",
    698 => "Padrauna",
    699 => "Lakhimpur",
    700 => "Lalitpur",
    701 => "Maharajganj",
    702 => "Mahoba",
    703 => "Mainpuri",
    704 => "Mau",
    705 => "Mirzapur",
    706 => "Muzaffarnagar",
    707 => "Pilibhit",
    708 => "Pratapgarh",
    709 => "Prayagraj",
    710 => "Raebareli",
    711 => "Rampur",
    712 => "Saharanpur",
    713 => "Sambhal",
    714 => "Khalilabad",
    715 => "Shahjahanpur",
    716 => "Shamli",
    717 => "Shravasti",
    718 => "Naugarh",
    719 => "Sitapur",
    720 => "Robertsganj",
    721 => "Sultanpur",
    722 => "Unnao",
    723 => "Almora",
    724 => "Bageshwar",
    725 => "Gopeshwar",
    726 => "Champawat",
    727 => "Haridwar",
    728 => "Nainital",
    729 => "Pauri",
    730 => "Pithoragarh",
    731 => "Rudraprayag",
    732 => "New Tehri",
    733 => "Rudrapur",
    734 => "Uttarkashi",
    735 => "Alipurduar",
    736 => "Bankura",
    737 => "Suri",
    738 => "Cooch Behar",
    739 => "Balurghat",
    740 => "Darjeeling",
    741 => "Chinsurah",
    742 => "Howrah",
    743 => "Jalpaiguri",
    744 => "Jhargram",
    745 => "Kalimpong",
    746 => "English Bazar",
    747 => "Baharampur",
    748 => "Krishnanagar",
    749 => "Barasat",
    750 => "Midnapore",
    751 => "Bardhaman",
    752 => "Tamluk",
    753 => "Alipore",
    754 => "Raiganj",
    755 => "Car Nicobar",
    756 => "Mayabunder",
    757 => "Port Blair",
    758 => "Silvassa",
    759 => "Daman",
    760 => "Diu",
    761 => "Budgam",
    762 => "Bandipore",
    763 => "Baramulla",
    764 => "Doda",
    765 => "Ganderbal",
    766 => "Jammu",
    767 => "Kathua",
    768 => "Kishtwar",
    769 => "Kulgam",
    770 => "Kupwara",
    771 => "Poonch",
    772 => "Pulwama",
    773 => "Rajouri",
    774 => "Ramban",
    775 => "Reasi",
    776 => "Samba",
    777 => "Shopian",
    778 => "Udhampur",
    779 => "Kargil",
    780 => "Leh",
    781 => "Kavaratti",
    782 => "Karaikal",
    783 => "Mahe",
    784 => "Yanam"
            ];

            $flag=false;

foreach ($cityMap as $key => $value) {
    if (stripos($cityname, $value) !== false) {
        return $matchKey = $key;
        break;
    }
}

       if($flag==false){
         //$key=110;
        return 110;
       }


    }
    private function CheckIndiaState($statename)
    {



        $states = [
            '1'  => 'Andhra Pradesh',
            '2'  => 'Arunachal Pradesh',
            '3'  => 'Assam',
            '4'  => 'Bihar',
            '5'  => 'Chhattisgarh',
            '6'  => 'Goa',
            '7'  => 'Gujarat',
            '8'  => 'Haryana',
            '9'  => 'Himachal Pradesh',
            '10' => 'Jammu and Kashmir',
            '11' => 'Jharkhand',
            '12' => 'Karnataka',
            '13' => 'Kerala',
            '14' => 'Madhya Pradesh',
            '15' => 'Maharashtra',
            '16' => 'Manipur',
            '17' => 'Meghalaya',
            '18' => 'Mizoram',
            '19' => 'Nagaland',
            '20' => 'Odisha',
            '21' => 'Punjab',
            '22' => 'Rajasthan',
            '23' => 'Sikkim',
            '24' => 'Tamil Nadu',
            '25' => 'Tripura',
            '26' => 'Uttar Pradesh',
            '27' => 'Uttarakhand',
            '28' => 'West Bengal',
            '29' => 'Andaman and Nicobar',
            '30' => 'Chandigarh',
            '31' => 'Dadra and Nagar Haveli and Daman and Diu (DD)',
            '32' => 'Ladakh',
            '33' => 'Lakshadweep',
            '34' => 'Puducherry',
        ];
        if (array_search($statename, $states)) {
            $key = array_search($statename, $states);
            return $key;
        } else {
            $key = 0;
            return 0;
        }
    }

 
    public function panelist_survey_detail(Request $request, $panelist_id)

    {

        $pmName = auth()->user()->first_name;

        $user = User::where("panellist_id", $panelist_id)->first();
        $uuid = $user->uuid;
        $languageCode = strtoupper(explode('_', $user->locale)[0]);
        $country_code = strtoupper(explode('_', $user->locale)[1]);
        if (!$user) {
            return back()->with('error', 'User not found.');
        }


        $surveys = \DB::table('projects')
            ->select([
                'projects.apace_project_code as survey',
                'projects.id',
                'projects.survey_status_code',
                'user_projects.status',
                'latest_invite.invite_sent_count',
                'users.first_name as pmName',
            ])
            ->join('user_projects', function ($join) use ($user, $languageCode, $country_code) {
                $join->on('projects.apace_project_code', '=', 'user_projects.apace_project_code')
                    ->where('user_projects.user_id', '=', $user->id)
                    ->where('projects.country_code', $country_code)
                    ->where('projects.language_code', $languageCode);
            })
            // Join the subquery (latest invite_sent_details)
            ->joinSub(function ($query) {
                $query->from('invite_sent_details')
                    ->select('invite_sent_details.*')
                    ->whereIn('id', function ($sub) {
                        $sub->from('invite_sent_details as isd2')
                            ->selectRaw('MAX(isd2.id)')
                            ->groupBy('isd2.project_id');
                    });
            }, 'latest_invite', function ($join) use ($uuid) {
                $join->on('projects.id', '=', 'latest_invite.project_id')
                    ->whereRaw('FIND_IN_SET(?, latest_invite.user_ids)', [$uuid]);
            })
            ->leftJoin('users', 'latest_invite.created_by', '=', 'users.id')
            ->where('projects.survey_status_code', 'LIVE')
            ->where('projects.is_active', 1)
            ->groupBy(
                'projects.id',
                'projects.apace_project_code',
                'projects.survey_status_code',
                'user_projects.status',
                'users.first_name',
                'latest_invite.invite_sent_count'
            )
            ->orderBy('latest_invite.created_at', 'desc')
            ->get();
        return view('backend.auth.user.panelist_survey_details', [
            'surveys'    => $surveys,
            'panelistId' => $user->panellist_id,
            'user_id'    => $user->id,
        ]);
    }
    public function sendPullInvite(Request $request)
    {
        $panel_manager_id = auth()->user()->id;

        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found',
            ], 404);
        }
        $projectIds = is_array($request->project_id) ? $request->project_id : [$request->project_id];

        foreach ($projectIds as $projectId) {
            $projectQuota = ProjectQuota::where('project_id', '=', $projectId)->first();
            $project = DB::table('projects')->where('id', $projectId)->first();
            if (!$project || !$projectQuota) {
                continue;
            }
            $userProject = DB::table('user_projects')
                ->where('user_id', $user->id)
                ->where('apace_project_code', '=', $project->apace_project_code)
                ->whereNull('status')
                ->first();

            $surveyLiveLink = $this->getSurveyLink($user, $project, 'live_url');
            $surveyTestLink = $this->getSurveyLink($user, $project, 'test_url');
            $pointsConversionMetric = config('app.points.metric.conversion');
            $pointsData = round($project->cpi / $pointsConversionMetric);

            $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($user->locale);
            $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
            $countrySymbol = $countryPoint->currency_symbols ?? '';
            $placeholders = $this->buildSurveyPlaceholders($user, $project, $projectQuota, $pointsData, $countryPoints, $countrySymbol, $surveyLiveLink, $surveyTestLink);

            $email_data = [
                'email' => $user->email,
                'from_name' => 'SJ Panel',
                'from_address' => 'do-not-reply@sjpanel.com',
                'subject' => __('inpanel.mail.survey.reminder_subject_new', [
                    'reminder_points' => number_format($pointsData / $countryPoints, 2)
                ]),
            ];

            $email = new SurveyTestInvite($email_data, $placeholders);
            Mail::send($email);
            $apaceProjectDetails = DB::connection('mysql_apace1')->table('projects')->where('code', $project->apace_project_code)->first();
            $apaceInviteDetails = DB::connection('mysql_apace1')
                ->table('invite_sent_details')
                ->where('project_id', $apaceProjectDetails->id)
                ->where('project_quota_id', $projectQuota->apace_quota_id)
                ->first();
            $data = [
                "project_id" => $project->id,
                "project_quota_id" => $projectQuota->id,
                "apace_project_code" => $project->apace_project_code,
                "apace_project_quota_id" => $projectQuota->apace_quota_id,
                "user_ids" => $user->uuid,
                "created_at" => now(),
                "created_by" => $panel_manager_id,
                'invite_sent_count' => 1,
                'reminder' => 0,
                'surveycnt' => 0
            ];
            $data2 = [
                "project_id" => $apaceProjectDetails->id,
                "project_quota_id" => $projectQuota->apace_quota_id,
                "user_ids" => $user->uuid,
                "created_at" => now(),
                "sjpanelinvitesentid" => $apaceInviteDetails->id,
                'invitecnt' => 0,
                'reminder' => 1,
            ];
            $data3 = [
                "inviteSentDetailsId" => $apaceInviteDetails->id,
                "uuids" => $user->uuid,
                "createdOn" => now(),
                'count' => 1,
                "updateOn" => now(),
            ];

            DB::table('invite_sent_details')->insert($data);
            DB::connection('mysql_apace1')->table('invite_sent_details')->insert($data2);
            DB::connection('mysql_apace1')->table('reminder_sent_details')->insert($data3);
        }

        return response()->json([
            'status' => true,
            'message' => 'Reminder Sent Successfully',
        ]);
    }
    private function getSurveyLink($user, $project, $url_type_column)
    {

        $client_var = [config('app.vvars.user_id')];
        $client_redirect_link = $project->$url_type_column;
        $parameters = explode('&', $client_redirect_link);
        foreach ($parameters as $key => $value) {
            $param = explode('=', $value);
            foreach ($param as $param_var) {
                if (in_array($param_var, $client_var)) {
                    unset($parameters[$key]);
                    $new_pid = $param_var . '=' . $user->uuid . '_' . $project->code;
                    $new_parameter = array_push($parameters, $new_pid);
                }
            }
        }
        $client_redirect_new_link = implode('&', $parameters);
        return $client_redirect_new_link;
    }
    public function getProjectDeviceName($project)
    {
        $allProjectDevice = $project->device_options;
        $projectDevice = explode(',', $allProjectDevice);

        $retunDevice = [];
        foreach ($projectDevice as $device) {

            if ($device == 2) {
                $retunDevice[] = "DESKTOP";
            }
            if ($device == 3) {
                $retunDevice[] = "PHONE";
            }
            if ($device == 4) {
                $retunDevice[] = "TABLET";
            }
        }

        return implode('/', $retunDevice);
    }
    public function panelist_survey_history(Request $request)
    {
        if ($request->ajax()) {

            $fromDate = $request->get('fromDate');
            $toDate   = $request->get('toDate');

            // Build the base query
            $query = \DB::table('invite_sent_details')
                ->select([
                    'projects.apace_project_code as survey',
                    'projects.id',
                    'projects.survey_status_code',
                    'user_projects.status',
                    'invite_sent_details.created_by',
                    'invite_sent_details.user_ids',
                    'invite_sent_details.invite_sent_count',
                    'users.first_name as pmName',
                    'invite_sent_details.created_at',
                ])
                ->join('projects', 'projects.id', '=', 'invite_sent_details.project_id')
                ->join('user_projects', function ($join) {
                    $join->on('projects.apace_project_code', '=', 'user_projects.apace_project_code')
                        ->whereNull('user_projects.status');
                })
                ->leftJoin('users', 'invite_sent_details.created_by', '=', 'users.id')
                ->where('projects.survey_status_code', 'LIVE')
                ->where('projects.is_active', 1)
                ->where('invite_sent_details.invite_sent_count', '>', 0)
                ->groupBy('projects.id');

            if ($fromDate && $toDate) {
                $fromDate = Carbon::parse($fromDate)->startOfDay();
                $toDate = Carbon::parse($toDate)->endOfDay();

                $query->whereBetween('invite_sent_details.created_at', [$fromDate, $toDate]);
            } elseif ($fromDate) {
                $query->whereDate('invite_sent_details.created_at', '>=', Carbon::parse($fromDate)->startOfDay());
            } elseif ($toDate) {
                $query->whereDate('invite_sent_details.created_at', '<=', Carbon::parse($toDate)->endOfDay());
            }


            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('projects.apace_project_code', 'like', "%{$search}%")
                        ->orWhere('users.first_name', 'like', "%{$search}%");
                });
            }

            // Count total distinct projects
            $totalRecords = \DB::table(\DB::raw("( 
                select projects.id
                from invite_sent_details
                join projects on projects.id = invite_sent_details.project_id
                join user_projects on projects.apace_project_code = user_projects.apace_project_code and user_projects.status IS NULL
                where projects.survey_status_code = 'LIVE'
                and projects.is_active = 1
                and invite_sent_details.invite_sent_count > 0
                group by projects.id
                ) as temp"))->count();
            $columns = [
                'pmName',
                'survey',
                'survey_status_code',
                'status',
                'invite_sent_count',
                'created_at',
            ];

            $orderColumnIndex = $request->input('order.0.column', 0);
            $orderColumn      = $columns[$orderColumnIndex] ?? 'invite_sent_details.created_at';
            $orderDir         = $request->input('order.0.dir', 'desc');

            $query->orderBy($orderColumn, $orderDir);
            $start  = $request->input('start', 0);
            $length = $request->input('length', 10);
            $surveys = $query->skip($start)->take($length)->get();

            foreach ($surveys as $survey) {
                $survey->pmName = decrypt($survey->pmName);
                $survey->panelist_id = User::getPanelistsId($survey->user_ids);
            }

            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $totalRecords,
                "data" => $surveys
            ]);
        }

        return view("backend.auth.user.panelist_survey_history");
    }

    private function buildSurveyPlaceholders($user, $project, $projectQuota, $pointsData, $countryPoints, $countrySymbol, $surveyLiveLink, $surveyTestLink)
    {

        return [
            '{%S_POINTS%}'          => $pointsData,
            '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
            '{%S_CODE%}'            => $project->apace_project_code,
            '{%DEVICE%}'            => $this->getProjectDeviceName($project),
            '{%S_LOI%}'             => $project->loi,
            '{%VALUE%}'   =>  number_format(($pointsData / $countryPoints), 2),
            '{%S_SDATE%}'           => $project->start_date,
            '{%S_EDATE%}'           => $project->end_date,
            '{%S_LINK%}'            => (!empty($surveyLiveLink)) ? $surveyLiveLink . '&ch=1&points=' . $pointsData : "test.com",
            '{%S_TEST_LINK%}'       => (!empty($surveyTestLink)) ? $surveyTestLink . '&ch=1&points=' . $pointsData : "test.com",
            '{%Points_Data%}'       => $pointsData,
            '{%S_TOPIC%}'           => $project->project_topic_name,
            '{%U_NAME%}'            => $user->first_name,
            '{%U_EMAIL%}'           => $user->email,
            '{%P_VALUE%}' => __('inpanel.mail.survey.value'),
            '{%DETAILS_1%}'         => __('inpanel.mail.survey.salutation'),
            '{%DETAILS_2%}' => __('inpanel.mail.survey.reminderdetails_1', ['survey_num' => $project->apace_project_code]),
            '{%MINUTE%}' => __('inpanel.mail.survey.minutes'),
            '{%device_use%}'         => __('inpanel.mail.survey.device_use'),
            '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
            '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
            '{%DETAILS_3%}'         => __('inpanel.mail.survey.details_2', ['points' => $pointsData]),
            '{%DETAILS_4%}'         => __('inpanel.mail.survey.details_3', ['points' => $pointsData, 'loi' => $project->loi]),
            '{%DETAILS_5%}'         => __('inpanel.mail.survey.details_4'),
            '{%DETAILS_6%}'         => __('inpanel.mail.survey.details_5'),
            '{%device_use%}'        => __('inpanel.mail.survey.device_use'),
            '{%safe_sender%}'       =>  __('frontend.index.footer.links.safe_sender'),
            '{%office_address%}'    =>  __('frontend.index.footer.links.office_address'),
            '{%LABELS_1%}'          => __('inpanel.mail.survey.label_1'),
            '{%LABELS_2%}'          => __('inpanel.mail.survey.label_2'),
            '{%LABELS_3%}'          => __('inpanel.mail.survey.label_3'),
            '{%POINTS%}'            => __('inpanel.mail.survey.points'),
            '{%LABELS_4%}'          => __('inpanel.mail.survey.label_4'),
            '{%BUTTON_S%}'          => __('inpanel.mail.survey.button'),
            '{%LINE_TEXT%}'         => __('inpanel.mail.survey.link_text'),
            '{%ENTER%}'             => __('inpanel.mail.survey.enter'),
            // '{%HAPPY%}'             => __('inpanel.mail.survey.happy'),
            '{%FOOTER_1%}'          => __("strings.emails.auth.confirmation.footer"),
            '{%FOOTER_2%}'          => __("strings.emails.auth.confirmation.footer_1"),
            '{%FOOTER_3%}'          => __("frontend.welcome_mail.team"),
            '{%FOOTER_DETAILS%}'    => __("strings.emails.auth.confirmation.details_3"),
            '{%REGARDS%}'           => __('inpanel.mail.survey.regards'),
            '{%ROUTE_R%}'           => route('frontend.cms.rewards'),
            '{%REWARDS%}'           => __('strings.emails.auth.confirmation.rewards'),
            '{%POLICY%}'            => __("frontend.index.footer.links.privacy_policy"),
            '{%SAFEGUARDS%}'        => __("strings.emails.auth.confirmation.safeguards"),
            '{%COOKIE%}'            => __("strings.emails.auth.confirmation.cookie"),
            '{%REWARDS_POLICY%}'    => __('frontend.index.footer.links.reward_policy'),
            '{%T_CONDITION%}'       => __("frontend.index.footer.links.term_condition"),
            '{%ROUTE_REWARD_P%}'    => route('frontend.cms.rewards_policy'),
            '{%ROUTE_REFERRAL_P%}'  => route('frontend.cms.referral_policy'),
            '{%REFERRAL_POLICY%}'   => __('frontend.index.footer.links.referral_policy'),
            '{%ROUTE_TC%}'          => route('frontend.cms.term_condition'),
            '{%ROUTE_S%}'           => route('frontend.cms.safeguard'),
            '{%ROUTE_C%}'           => route('frontend.cms.cookie'),
            '{%ROUTE_P%}'           => route('frontend.cms.privacy'),
            '{%ROUTE_F%}'           => route('frontend.cms.faq'),
            '{%ROUTE_CONT%}'        => route('frontend.cms.help_support'),
            '{%FAQ%}'               => __("strings.emails.auth.confirmation.faq"),
            '{%CONTACT%}'           => __("strings.emails.auth.confirmation.contact"),
            '{%DISCLAIMER%}'        => __("strings.frontend.disclaimer"),
            '{%DISCLAIMER_1%}'      => __("strings.frontend.disclaimer_1"),
            '{%UNSUBSCRIBE%}'       => \Illuminate\Support\Facades\URL::signedRoute('inpanel.mail.unsubscribe', ['email' =>  $user->email]),
            '{%UNSUBSCRIBE_LABEL%}' => __("strings.emails.auth.confirmation.unsubscribe"),
            '{%COPYRIGHT%}'         => __("strings.emails.auth.confirmation.copyright"),
            '{%COPYRIGHT_COMPANY%}' => __("strings.emails.auth.confirmation.copyrightcompany"),
            '{%ALL_RIGHT%}'         => __("strings.emails.auth.confirmation.all_right"),
            '{%YEAR%}'              => date("Y"),
            '{%LOGO%}'              => asset('img/frontend/logo.png'),
            '{%IMAGE%}'             => asset('img/img_email/survey1.png'),
            '{%LOGOLINK%}'          => (env('APP_URL')),
            '{%MAIL_CONTENT%}'      => __("strings.emails.auth.confirmation.mail_content"),
            '{%LINK%}'              => __("strings.emails.auth.confirmation.link"),
            '{%LINK1%}'             => __("strings.emails.auth.confirmation.link1"),
            '{%device_before_content%}' => __('inpanel.mail.invitation.device_before_content'),
            '{%MINUTE%}'            => __('inpanel.mail.survey.minutes'),
            '{%NEW_CONTENT%}' => __('inpanel.mail.survey.new_content'),
            '{%countrySymbol%}' => __('inpanel.redeem.index.title_history_2'),
        ];
    }

    public function listActivePanallistCounts(Request $request)
    {
        $countriesArr = $request->countries;
        $month = $request->month;
        // dd($countriesArr , $month);
        $getActiveMonthsLimit = settings::where("key", "=", "PANEL_ACTIVE_MONTH_LIMIT")
            ->value('value');

        $recentActivitySub = DB::table('user_projects')
            ->select(
                'user_id',
                DB::raw("CASE WHEN COUNT(*) > 0 THEN 1 ELSE 0 END as has_active")
            )
            ->where('created_at', '>=', now()->subMonths($getActiveMonthsLimit))
            ->where('status', '!=', null)
            ->groupBy('user_id');

        $data = User::query()
            ->select('users.id', 'users.country_code', 'recent_activity.has_active')
            ->whereHas('roles', function ($query) {
                $query->where('id', 4);
            })
            ->leftJoinSub($recentActivitySub, 'recent_activity', function ($join) {
                $join->on('recent_activity.user_id', '=', 'users.id');
            })
            ->where('recent_activity.has_active', 1);

        if ($countriesArr) {
            $data->whereIn('country_code', $countriesArr);
        }

        if ($month) {
            $data->where('created_at', '>=', now()->subMonths($month));
        }

        $data = $data->get();

        $result = $data->groupBy('country_code')
            ->map->count();

        $countries = DB::table('countries')->pluck('name', 'country_code');
        // dd($countries);  

        return view('backend.auth.user.active_users_count', [
            'count_by_country' => $result->toArray(),
            'filtered month' => $getActiveMonthsLimit,
            'countries' => $countries
        ]);
    }
}
