<?php

namespace App\Http\Controllers\Inpanel;
//comm
use App\Http\Controllers\Controller;
use App\Models\Profiler\UserAdditionalData;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Mail\Inpanel\Invite\ReferPointsConfirm;
use App\Mail\Inpanel\UserProject\SurveyAssaigned;
use Illuminate\Support\Facades\Cookie;
use Spatie\Activitylog\Models\Activity;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Inpanel\Traffic\TrafficStatuses;
use App\Models\Project\Project;
use App\Repositories\Inpanel\Project\ProjectRepository;
use App\Repositories\Inpanel\Profiler\DetailedProfileRepository;
use App\Models\Auth\User;
use App\Models\Auth\SjDfiqApiResponse;
use Auth;
use DateTime;
use Response;
use App\Models\Setting\Setting;
use App\Mail\Frontend\UserConfirm\ProfilePromptMail;
use GuzzleHttp\Client;
use App\Mail\Frontend\UserConfirm\UserConfirmation;
use Carbon\Carbon;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
use App\Services\RewardService;
use App\Models\Redeem\RequestRedeem;

/**
 * This class is used for showing the Dashboard to the User where he get all the information regarding
 * available,complete,total surveys and directly can take the survey and also can check the recent activities.
 *
 * Class DashboardController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Inpanel\DashboardController
 */
class DashboardController extends Controller
{
    /**
     * @param $profileSectionRepo, $$detailedProfileRepo, $userAddRepo, $projectRepo, $tempRepo, $userRepositor.
     */
    use TrafficStatuses;

    protected $profileSectionRepo, $detailedProfileRepo, $userAddRepo, $projectRepo, $tempRepo, $userRepository, $notificationRepo, $countriesCurrenciesRepository;

    /**
     * DashboardController constructor.
     * @param ProfileSectionRepository $profileSectionRepo
     * @param UserAdditionalDataRepository $userAddRepo
     * @param DetailedProfileRepository $detailedProfileRepo
     * @param UserRepository $userRepository
     */
    public function __construct(
        ProfileSectionRepository $profileSectionRepo,
        UserAdditionalDataRepository $userAddRepo,
        DetailedProfileRepository $detailedProfileRepo,
        UserRepository $userRepository,
        ProjectRepository $projectRepo,
        UserNotificationRepository $notificationRepo,
        CountriesCurrenciesRepository $countriesCurrenciesRepository

    ) {

        $this->profileSectionRepo = $profileSectionRepo;
        $this->userAddRepo = $userAddRepo;
        $this->detailedProfileRepo = $detailedProfileRepo;
        $this->userRepository = $userRepository;
        $this->projectRepo = $projectRepo;
        $this->notificationRepo = $notificationRepo;
        $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;

    }
    /*public function __construct(
        ProjectManagementRepository $projectRepo,
        TempProjectRepository $tempRepo,
        UserRepository $userRepository
    )
    {
        $this->projectRepo = $projectRepo;
        $this->tempRepo = $tempRepo;
        $this->userRepository = $userRepository;
    }*/
    /**
     * This action is used to redirect the User to Dashboard View Page.
     *
     * @param Request $request
     * @return resource inpanel/dashboard.blade.php
     */
    public function index(Request $request)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $user = auth()->user();
        // $this->projectRepo->updateReferralUserPoints($user);
        $surveys = $this->projectRepo->getActiveUserProjectByUserId($user->id);
        $hsurveys = $this->projectRepo->getUserTakenSurveys($user->id);
        $unsuccessful_count = 0;

        if(isset($hsurveys)){
            foreach($hsurveys as $survey){
                if($survey['status'] != 1 || $survey['status'] != 50){
                    $unsuccessful_count++;
                }
            }
        }        
        
        $pending_count = 0;

        if(isset($hsurveys)){
            foreach($hsurveys as $survey){
                if($survey['status'] == 1){

                    $pending_count++;
                }
            }
        }
        
        $locale=str_replace('_','_',$request->session()->get('locale'));
        $request->session()->put('locale', $locale);
        $locale=str_replace('_','-',$request->session()->get('locale'));
        
        $locale = app()->getLocale();
        
        //echo  __('strings.frontend.user.profile_updated');
        
        list($country_code, $language_code) = get_codes_from_locale($locale);
        $profile_sections_all = $this->profileSectionRepo->getPublicProfileSections($country_code, $language_code);
        // $profile_sections = $profile_sections_all;

        //echo '<pre>';
        //print_r(count($profile_sections));die();
        $DFIQ = config('settings.dfiq.status');
        $availableProfilesCount = $this->profileSectionRepo->getAvailableProfilesCount();
        // print($availableProfilesCount);exit();

        $user_filled_profiles = $this->userAddRepo->getFilledProfiles($user);
       // $userFilledProfiles = $this->userAddRepo->getFilledProfilesCount($user);
        $userFilledProfiles = (!empty($user_filled_profiles) && !empty($user_filled_profiles->user_filled_profiles))

            ? count($user_filled_profiles->user_filled_profiles)
            : 0;
        $profilePercent = 0;
        if ($userFilledProfiles) {
            $profilePercent = ($userFilledProfiles / $availableProfilesCount) * 100;
        }
        
        $pendingProfilecount_v1 = ($availableProfilesCount - $userFilledProfiles);

        $displayProfilePrompt = false;
        $promptDisplayed = request()->cookie('user_profileprompt', false);
        
        if (empty($promptDisplayed) && $user->detailed_profile_filled == false) {
            Cookie::queue('user_profileprompt', 'true', 120);
            $displayProfilePrompt = true;
        }

        //$detailed_profile_survey = $this->profileSectionRepo->getDetailedProfileSurvey();

        $detailed_profile_survey=[];
        $filledProfilesCount = 0;
        $filledProfilesCodes = [];
        $filledProfilesPoints = [];

       // $user_filled_profiles = $this->userAddRepo->getFilledProfiles($user);

        $completedProfiles = [];
        if (!empty($user_filled_profiles) && !empty($user_filled_profiles->user_filled_profiles)) {
            foreach ($user_filled_profiles->user_filled_profiles as $profiles) {
                $current = reset($profiles);
                $filledProfilesCodes[] = $current['code'];
                $filledProfilesCount += $current['points'];
                $filledProfilesPoints[$current['code']] = $current['points'];
            }
            if (!empty($filledProfilesCodes)) {
                $profile_sections = $this->profileSectionRepo->getPublicProfileSectionsExcept($filledProfilesCodes, $country_code, $language_code);
                $completedProfiles = $this->profileSectionRepo->getPublicProfilesByCode($filledProfilesCodes, $country_code, $language_code);
            }
        }
        //echo '<pre>';
        //print_r(count($profile_sections));exit();

        //27-9-23 SM
        $getAllUserTakenSurveys = $this->projectRepo->getAllUserTakenSurveys($user->id);

        // $getAllUserTakenSurveys=[];

        // echo '<pre>';
        // print_r($getAllUserTakenSurveys);exit();

        $user_points = $this->userRepository->getUserPoints($user);
        $userPoints = $user_points->user_points['completed'];
        //print($userPoints);exit();
        $user_awaited_points = $user_points->user_points['pending'];
        $user_missed_points = $user_points->user_points['rejected'];
        // print($user_awaited_points);exit();
        $user_activity = Activity::causedBy($user)->take(4)->orderBy('created_at', 'desc')->get();
        // echo "<pre>";
        // print_r($user_activity);exit();
        $get_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        // echo "<pre>";
        // print_r($get_user_add_data);exit();

        $getSettingData = setting::where('key', '=', 'PANEL_POPUP_DASHBOARD_MONTH_LIMIT')->first();
        $getShowPopupMsgMonth = $getSettingData->value;
        /*
            added code on 1 july 2022 via dushyant
            starts
            code is for show profile update popup every six month 
        */
        $tour_taken = 0;
        $minute = 1;
        $registration_date          = $user->created_at;
        $profile_updatetoken_date   = $user->profile_updatetoken_date;
        $profile_updatetoken        = $user->profile_updatetoken;
        $email                      = $user->email;
        if (is_null($profile_updatetoken_date)) { //then check from registeration date 
            $diff = round(abs(strtotime(now()) - strtotime($registration_date)) / 86400);
            if ($diff >= 180) {
                $minute = 0;
            }
        } else {
            if (strtotime(now()) > strtotime($profile_updatetoken_date)) {
                $minute = 0;
            }
        }
        //dd($get_user_add_data);
        // if ($user->email == 'ddushyant03@gmail.com' || $user->email == 'pramod@webdecorum.com' || $user->email == "vikash@optimumlogic.com") {
        //     $minute = 0;
        //     //dd($user);
        // }

        if ($minute == 0) {
            //echo $user->id;die;
            $profileInputs['profile_updatetoken_date'] = date("Y-m-d h:i:s", strtotime("+" . $getShowPopupMsgMonth . " month"));
            $output = $this->userRepository->update($user->id, $profileInputs);
            //$this->userRepository->updateProfileToken($user->email);
        }


        /*
            added code on 1 july 2022 via dushyant
            end
        */


        if ($get_user_add_data) {
            $tour_detail = isset($get_user_add_data->user_tour_taken) ? $get_user_add_data->user_tour_taken : 0;
            if ($tour_detail) {
                foreach ($tour_detail as $key => $value) {
                    if ($value['section'] == 'dashboard' && $value['taken'] == true) {
                        $tour_taken = 1;
                    }
                }
            }
        }
        $user_assign_projects_info = $this->userRepository->getUserAssignProject($user); 
        // dd($user_assign_projects_info);
        // echo "<pre>";
        // print_r($user_assign_projects_info);exit();

        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);

        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);
        $user_active_surveys = $this->userRepository->getUserActiveSurveys($user);
        //echo "<pre>";
        //print_r(count($user_assign_projects));exit();
        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $user_activity1 = Activity::causedBy($user)->where('description', 'inpanel.activity_log.log_in')->take(1)->orderBy('created_at', 'desc')->get();
        //echo "<pre>";
        //print_r(($user_expire_surveys));exit();
        $updated_user_add_data = $get_user_add_data;
        $fetch_user_achievement = $updated_user_add_data->user_filled_profiles;
        if (!empty($fetch_user_achievement)) {
            $count_User = count(@$fetch_user_achievement);
        } else {
            $count_User = 0;
        }

        $active_user_add_data = $get_user_add_data;
        $fetch_user_achievement1 = $active_user_add_data->user_achievement;
        $active_user_count = count($fetch_user_achievement1);

        /*$zipcode = app()->make('PragmaRX\ZipCode\Contracts\ZipCode');
        $zipcode->setCountry('DE');

        $data = $zipcode->find('79283');
        dd($data);*/

        /*$userPoints = $user->point()->first();


        if($profilePercent == 100 && $user->detailed_profile_filled == 0){
            $user->detailed_profile_filled = 1;
            $user->save();
        }

        /*$completedSurveys = $this->projectRepo->getCompletedUserProjectBy($user->id);
        $userActiveSurveys = $this->projectRepo->getActiveUserProjectByUserId($user->id);
        $allUserSurveys = $this->projectRepo->getUserSurveys($user->id);*/
        // $allUserSurveys = $this->projectRepo->getUserSurveys($user->id);

        // echo "<pre>";
        // print_r($user_assign_projects_info);exit();

        // Code Commented by Vikas
        // $userActivities = Activity::causedBy($user)->take(5)->orderBy('created_at', 'desc')->get();
        // End Comment Vikas
        //  echo "<pre>";
        //  print_r( $userActivities);exit();
        /*return view('inpanel.dashboard',
            compact('userPoints',
                'userActivities',
                'profilePercent',
                'displayProfilePrompt',
                'userActiveSurveys',
                'allUserSurveys',
                'completedSurveys'
                
            ));*/
        $notifications = $this->notificationRepo->getNotification($user->uuid);
        // new code sm
        // $profile_sections1 = $this->profileSectionRepo->getPublicProfileSections($country_code, $language_code);
        // $allPointsCount = $profile_sections1->sum('points');
        // $user = auth()->user();
        // echo "<pre>";
        // print_r($user);die;

        // Code Commented by Vikas
        // $filledProfilesCount = 0;
        // $filledProfilesCodes = [];
        // $filledProfilesPoints = [];
        // $user_filled_profiles = $this->userAddRepo->getFilledProfiles($user);
        // $completedProfiles = [];
        // if (!empty($user_filled_profiles) && !empty($user_filled_profiles->user_filled_profiles)) {
        //     foreach ($user_filled_profiles->user_filled_profiles as $profiles) {
        //         $current = reset($profiles);
        //         $filledProfilesCodes[] = $current['code'];
        //         $filledProfilesCount += $current['points'];
        //         $filledProfilesPoints[$current['code']] = $current['points'];
        //     }
        //     if (!empty($filledProfilesCodes)) {
        //         // $profile_sections = $this->profileSectionRepo->getPublicProfileSectionsExcept($filledProfilesCodes, $country_code, $language_code);
        //         $completedProfiles = $this->profileSectionRepo->getPublicProfilesByCode($filledProfilesCodes, $country_code, $language_code);
        //     }
        // }

        // $get_user_add_data = UserAdditionalData::where('uuid', '=', auth()->user()->uuid)->first();
        // $tour_detail = isset($get_user_add_data->user_tour_taken) ? $get_user_add_data->user_tour_taken : 0;
        // $tour_taken = 0;
        // End comment Vikas

        if ($tour_detail) {
            foreach ($tour_detail as $key => $value) {
                if ($value['section'] == 'detailed-profile' && $value['taken'] == true) {
                    $tour_taken = 1;
                }
            }
        }

        // /**
        //  * Common code for all controllers
        //  * need to be moved to common file later
        //  * RAS
        //  */
        // $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);

        // $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        // $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        // $user_points = $this->userRepository->getUserPoints($user);
        // $userPoints = $user_points->user_points['completed'];
        // $fetch_user_achievement1 = $get_user_add_data->user_achievement;
        // $active_user_count=count($fetch_user_achievement1);
        // $updated_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        // $fetch_user_achievement = $updated_user_add_data->user_filled_profiles;
        //     if(!empty($fetch_user_achievement)){
        //         $count_User=count(@$fetch_user_achievement);
        //     }else{
        //         $count_User=0;
        //     }
        // $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        // $notifications = $this->notificationRepo->getNotification($user->uuid); 
        // /**
        //  * End of common code - also added in return
        //  */

        /**Code added by RAS for new ui Ibtegrtion */

 
        $age= Carbon::parse($user->dob)->age;
        $gender = $user->gender;
        // $userAddData = UserAdditionalData::where('uuid','=',$user->uuid)->first();

        if(($gender=='Female' || $gender=='Femenina') && $age>18){
            $q_id=1000;
        } elseif(($gender=='Male' || $gender=='Masculina') && $age>18){
            $q_id=1001;
        } else{
            $q_id=10;

        }


        $profile_survey = [];
        $count = 0;
        $filled_pro_survey = [];
        $filled_hours_gap = [];
        $filled_up_date = [];
        $dependent_survey_ques = [];

        foreach ($profile_sections as $pro_sec) {
            //echo $pro_sec->_id."<br>";
            $ques = $this->detailedProfileRepo->getSingleProfileWithAllData_newIntegration($pro_sec->_id, $user, $q_id, $country_code, $language_code);
            foreach ($ques->questions as $pro_ques) {
                if ($pro_ques->dependency) {
                    array_push($dependent_survey_ques, $pro_ques);
                }
            }

            $profile_survey[$count] = $ques;
            $count++;
        }

        foreach ($profile_survey as $pro_sur) {
            if (in_array($pro_sur->general_name, $filledProfilesCodes)) {
                [$filled_survey, $hours_gap, $updated_date] = $this->showUpdateProfile($pro_sur->_id);
                array_push($filled_pro_survey, $filled_survey);
                array_push($filled_hours_gap, $hours_gap);
                array_push($filled_up_date, $updated_date);
            }
        }
        //     echo '<pre>';
        // print_r(count($filled_pro_survey));die();

        $reffer_count = DB::table('invite_emails')

            ->join('user_referral_codes', 'invite_emails.refer_code', '=', 'user_referral_codes.ref_code')
            ->where('user_referral_codes.user_id', $user->id)
            ->whereIn('invite_emails.status', ['Yes', 'Completed'])
            ->select('invite_emails.id')
            ->count();

        /* Parshant Sharma [21-08-2024] Starts */

        $locale = app()->getLocale();

        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

            $cntry = explode('_', $countryPoint->country_language);

            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang' => $cntry[1],
            );
        }
        /* Parshant Sharma [21-08-2024] Ends */

        /* Anil Sharma [09-08-2024] Start */
        
        $panelist_id= $user->panellist_id;
        $showRewardPopUp = DB::table('reward_page_pole')
        ->where('panelist_id', $panelist_id)
        ->where('status', 1)
        ->get();
        /* Anil Sharma [09-08-2024] End */
        // $notifications=[];

        /* Anil Sharma [01-09-2025] Start */
        $redeem_requests = RequestRedeem::where('user_uuid', '=', $user->uuid)->where('status', '=', 'pending')->first();
        $hasRedeemRequest = false;   
        $hasThresholdReached = false;   
        if($redeem_requests){
         $hasRedeemRequest = true;   
        }
        $redeem_points = session()->has('redeem_requests_points') ? session()->get('redeem_requests_points') : 0;
        $redeem_points = isset($redeem_points) ? $redeem_points : 0;
        $remaining_points = $userPoints - $redeem_points;
        $calPoints = ( $currencies['lang'] == 'IN') ? ( $countryPoints * 5 * 40 ): $countryPoints * 5;

        if(isset($remaining_points) && $remaining_points >= $calPoints){
        $hasThresholdReached = true;
        }
 
        /* Anil Sharma [01-09-2025] End */

        return view('inpanel.dashboard_new', compact(
            'profilePercent',
            'displayProfilePrompt'

        ))->with('userPoints',$user_points)
            ->with('userActivities',$user_activity)
            ->with('activity',$user_activity1)
            ->with('tour_taken',$tour_taken)
            ->with('minute',$minute)
            ->with('user',$user)
            ->with('surveys',$surveys)
            ->with('dfiq',$DFIQ)
            ->with('allUserSurveys',$user_assign_projects)
            ->with('completedSurveys',$user_completed_surveys)
            ->with('userActiveSurveys',$user_active_surveys)
            ->with('detailed_profile_survey',$detailed_profile_survey)
            ->with('attemptedSurvey',$user_attempted_surveys)
            ->with('userExpireSurveys',$user_expire_surveys)
            ->with('user_count' , $count_User)
            ->with('user_point' , $userPoints)
            ->with('user_notifications' , $notifications)
            ->with('user_awaited_points' , $user_awaited_points)
            ->with('user_missed_points' , $user_missed_points)
            ->with('pendingProfilecount_v1',$pendingProfilecount_v1)
            ->with('availableProfilesCount',$availableProfilesCount)
            ->with('profile_sections_all',$profile_sections_all)
            ->with('completedProfiles',$completedProfiles)
            ->with('filled_pro_survey',$filled_pro_survey)
            ->with('hsurveys',$hsurveys)
            ->with('unsuccessful_count',$unsuccessful_count)
            ->with('pending_count',$pending_count)
            ->with('profile_sections',$profile_sections)
            ->with('active_user_count' , $active_user_count) 
            ->with('reffer_count',$reffer_count)
            ->with('getAllUserTakenSurveys' , $getAllUserTakenSurveys)
            ->with('user_assign_projects_info',$user_assign_projects_info)
            ->with('countryPoints',$countryPoints)
            ->with('showRewardPopUp',$showRewardPopUp)
            ->with('currentCountry',$currentCountry)
            ->with('hasRedeemRequest',$hasRedeemRequest)
            ->with('hasThresholdReached',$hasThresholdReached)
            ->with('currencies',$currencies);

    }


    /**
     *updateDetailProfile_new
     * @param Request $request
     * @param $id
     * @return mixed
     */
    private function showUpdateProfile($id)
    {
        $user = auth()->user();

        $age = Carbon::parse($user->dob)->age;

        $gender = $user->gender;

        $locale = app()->getLocale();
        list($country_code, $language_code) = get_codes_from_locale($locale);

        $userAddData = UserAdditionalData::where('uuid', '=', $user->uuid)->first();

        if (($gender == 'Female' || $gender == 'Femenina') && $age > 18) {
            $q_id = 1000;
        } elseif (($gender == 'Male' || $gender == 'Masculina') && $age > 18) {
            $q_id = 1001;
        } else {
            $q_id = 10;
        }

        $profile = $this->detailedProfileRepo->getSingleProfileWithAllData($id, $user, $country_code, $language_code, $q_id);

        $projectionArray['user_answers'] = [
            '$elemMatch' => ['profile_section_code' => "$profile->general_name"]
        ];

        $user_answers = [];
        foreach ($userAddData->user_answers as $key => $value) {

            if ($value['profile_section_code'] == $profile->general_name) {

                foreach ($profile->questions as $data) {

                    $dataOther = $data->id . '_OTHER';
                    $dataSelectOther = $data->id . '_SELECT_OTHER';

                    if ($data->id == $value['profile_question_code']) {

                        if (is_array($value['selected_answer'])) {
                            $answer = implode(',', $value['selected_answer']);
                        } else {
                            $answer = $value['selected_answer'];
                        }

                        if (($data->userAnswers) && (!$data->userAnswers->isEmpty())) {

                            $data->userAnswers->put('user_answer', $answer);
                        } else {
                            $data->userAnswers = collect([
                                'user_answer' => $answer,
                            ]);
                        }

                        break;
                    } elseif ($dataOther == $value['profile_question_code']) {

                        if (is_array($value['selected_answer'])) {
                            $answer = implode(',', $value['selected_answer']);
                        } else {
                            $answer = $value['selected_answer'];
                        }

                        if (($data->userAnswers) && (!$data->userAnswers->isEmpty())) {

                            $data->userAnswers->put('other', $answer);
                        } else {
                            $data->userAnswers = collect([
                                'other' => $answer,
                            ]);
                        }

                        break;
                    } elseif ($dataSelectOther == $value['profile_question_code']) {

                        if (is_array($value['selected_answer'])) {
                            $answer = implode(',', $value['selected_answer']);
                        } else {
                            $answer = $value['selected_answer'];
                        }

                        if (($data->userAnswers) && (!$data->userAnswers->isEmpty())) {
                            $data->userAnswers->put('selectother', $answer);
                        } else {
                            $data->userAnswers = collect([
                                'selectother' => $answer,
                            ]);
                        }

                        break;
                    }
                }
            }
        }

        $detailedFilledProfile = array_column($userAddData->user_achievement, 'detail_filled_profile');

        foreach ($detailedFilledProfile[0] as $val) {
            if ($val['code'] == $profile->general_name && !empty($val['updated_at'])) {
                $updated_date = $val['updated_at'];
                break;
            } else {
                $updated_date = "";
            }
        }
        $start_date = new DateTime(date('Y/m/d H:m:s'));
        $days_gap = $start_date->diff(new DateTime($updated_date));
        $hours_gap = (($days_gap->m) * 24 * 30) + (($days_gap->d) * 24) + ($days_gap->h);
        return [$profile, $hours_gap, $updated_date];
    }







    /**
     * This action for Tour Taking and saving the tour taken details
     * in user_additional collection for all the page.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeTourSelection(Request $request)
    {
        $tour_section = $request->tour_section;
        $user = auth()->user();
        $this->userRepository->updateTourTaken($user, $tour_section);
        return response()->json(['status' => 'success'], 200);
    }
    public function zipfailedattempts(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;
        $users = Auth::user($id);
        $users->delete();
        return redirect('login')->with(Auth::logout());
    }
    public function postDfiqData(Request $request)
    {


        if ($request->ajax()) {
            $DFIQJSONData = $request->get('datajsondata')['forensic'];
            $requestId = $DFIQJSONData['requestId'];
            $deviceId = $DFIQJSONData['deviceId'];
            //property//
            /*$deviceType=$DFIQJSONData['property']['deviceType'];
                $isMobile=$DFIQJSONData['property']['isMobile'];
                $os=$DFIQJSONData['property']['os'];
                $platform=$DFIQJSONData['property']['platform'];
                $browser=$DFIQJSONData['property']['browser'];
                $hardwareName=$DFIQJSONData['property']['hardwareName'];
                $hardwareModel=$DFIQJSONData['property']['hardwareModel'];
                $hardwareVendor=$DFIQJSONData['property']['hardwareVendor'];
                $ipAddress=$DFIQJSONData['property']['ipAddress'];
                $domain=$DFIQJSONData['property']['domain'];
                //END Here//
                //frequency//
                $isEventUnique=$DFIQJSONData['unique']['isEventUnique'];
                $eventDupeId=$DFIQJSONData['unique']['eventDupeId'];
                $eventDupeDate=$DFIQJSONData['unique']['eventDupeDate'];
                $eventDupeReason=$DFIQJSONData['unique']['eventDupeReason'];
                //marker
                 $score=$DFIQJSONData['marker']['score'];
                 $invalidCount=$DFIQJSONData['marker']['invalidCount'];
                 $invalidLowCount=$DFIQJSONData['marker']['invalidLowCount'];
                 $invalidMediumCount=$DFIQJSONData['marker']['invalidMediumCount'];
                 $invalidHighCount=$DFIQJSONData['marker']['invalidHighCount'];
                 $invalidCriticalCount=$DFIQJSONData['marker']['invalidCriticalCount'];
                 $isKnownBrowser=$DFIQJSONData['marker']['isKnownBrowser'];
                 $isObsoleteBrowser=$DFIQJSONData['marker']['isObsoleteBrowser'];
                 $isKnownOs=$DFIQJSONData['marker']['isKnownOs'];
                 $isObsoleteOs=$DFIQJSONData['marker']['isObsoleteOs'];
                 $isKnownDeviceType=$DFIQJSONData['marker']['isKnownDeviceType'];
                 $isKnownUserAgent=$DFIQJSONData['marker']['isKnownUserAgent'];
                 $isKnownDomain=$DFIQJSONData['marker']['isKnownDomain'];
                 $isBot=$DFIQJSONData['marker']['isBot'];
                 $isBlacklisted=$DFIQJSONData['marker']['isBlacklisted'];
                 $isWhitelisted=$DFIQJSONData['marker']['isWhitelisted'];
                 $isAnonymous=$DFIQJSONData['marker']['isAnonymous'];
                 $anonymousReason=$DFIQJSONData['marker']['anonymousReason'][0];
                 $isTampered=$DFIQJSONData['marker']['isTampered'];
                 $isResist=$DFIQJSONData['marker']['isResist'];
                 $isVelocity=$DFIQJSONData['marker']['isVelocity'];
                 $isOscillating=$DFIQJSONData['marker']['isOscillating'];
                 $isBehavioral=$DFIQJSONData['marker']['isBehavioral'];
                 $isLang=$DFIQJSONData['marker']['isLang'];
                 $isGeoLang=$DFIQJSONData['marker']['isGeoLang'];
                 $isGeoOsLang=$DFIQJSONData['marker']['isGeoOsLang'];
                 $isGeoPostal=$DFIQJSONData['marker']['isGeoPostal'];
                 $isGeoCountry=$DFIQJSONData['marker']['isGeoCountry'];
                 $isGeoTz=$DFIQJSONData['marker']['isGeoTz'];
                 //geo
                 $city=$DFIQJSONData['geo']['city'];
                 $stateProvince=$DFIQJSONData['geo']['stateProvince'];
                 $countryCode=$DFIQJSONData['geo']['countryCode'];*/
            //JSon Format//
            $geo_json = json_encode($DFIQJSONData['geo']);
            $marker_json = json_encode($DFIQJSONData['marker']);
            $unique_json = json_encode($DFIQJSONData['unique']);
            $property_json = json_encode($DFIQJSONData['property']);
            //End Here//

            $rId = $DFIQJSONData['rId'];
            $SjDfiqApiResponse = new SjDfiqApiResponse();
            $SjDfiqApiResponse->requestId = $requestId;
            $SjDfiqApiResponse->deviceId = $deviceId;
            $SjDfiqApiResponse->property = $property_json;
            $SjDfiqApiResponse->unique_ip = $unique_json;
            $SjDfiqApiResponse->marker = $marker_json;
            $SjDfiqApiResponse->geo = $geo_json;
            $SjDfiqApiResponse->rId = $rId;
            $SjDfiqApiResponse->email = $request->get('email');
            $SjDfiqApiResponse->ip_address = $request->get('ip_address');
            $SjDfiqApiResponse->panelistId = $request->get('panelistId');
            $SjDfiqApiResponse->save();
            if ($DFIQJSONData['marker']['isGeoPostal'] == false) {
                $userid = $request->get('user_id');
                if (!empty($userid)) {

                    // $user=User::where('id', $userid)

                    // ->update(['home_country' => 'OUT']);

                }
            } else {
                $userid = $request->get('user_id');
                if (!empty($userid)) {
                    // $user=User::where('id', $userid)
                    // ->update(['home_country' => 'OUT']);

                }
            }
        }
        return Response::json(array(
            'success' => true,
            'data'   => '1'
        ));
    }
    //End Here//
    /**
     * Added By RAS 12-09-23
     */
    public function getFilteredSurvey(Request $request)
    {
        $user = auth()->user();
        $getLang = explode('_', $user->locale);
        $rqst_data = $request->input('data');
        if ($rqst_data == '1') {
            $query = DB::table('user_projects')
                ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                ->where('projects.language_code', '=', strtoupper($getLang[0]))
                ->where('projects.country_code', '=', $getLang[1])
                ->where('user_projects.user_id', '=', $user->id)
                ->where('projects.survey_status_code', '=', 'LIVE')
                ->where('user_projects.status', '=', null)
                ->orderBy('projects.cpi', 'desc')
                ->select('user_projects.*', 'projects.loi', 'projects.survey_status_code', 'projects.survey_name')
                // ->limit(5)
                ->get();

            $results = $query;
        } else if ($rqst_data == '2') {
            $query = DB::table('user_projects')
                ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                ->where('projects.language_code', '=', strtoupper($getLang[0]))
                ->where('projects.country_code', '=', $getLang[1])
                ->where('user_projects.user_id', '=', $user->id)
                ->where('projects.survey_status_code', '=', 'LIVE')
                ->where('user_projects.status', '=', null)
                ->orderBy('projects.loi', 'asc')
                ->select('user_projects.*', 'projects.loi', 'projects.survey_status_code', 'projects.survey_name')
                // ->limit(5)
                ->get();

            $results = $query;
        } else if ($rqst_data == '3') {
            // need to be discussed
            $subquery = DB::table('user_projects')
                ->select(
                    'project_id',
                    DB::raw('SUM(CASE WHEN status IN (50,1,5) THEN 1 ELSE 0 END) / NULLIF(COUNT(CASE WHEN status IS NOT NULL THEN 1 END), 0) as ratio')
                )
                //    ->whereIn('project_id',$projectIds)
                ->groupBy('project_id');
            //    ->orderByDesc('ratio')->get();//toSql();

            $query = DB::table('user_projects')
                ->join('projects', 'projects.id', '=', 'user_projects.project_id')
                ->joinSub($subquery, 'projWithRatio', function ($join) {
                    $join->on('user_projects.project_id', '=', 'projWithRatio.project_id');
                })
                ->where('user_projects.user_id', '=', $user->id)
                ->where('projects.language_code', '=', strtoupper($getLang[0]))
                ->where('projects.country_code', '=', $getLang[1])
                ->where('projects.survey_status_code', '=', 'LIVE')
                ->where('user_projects.status', '=', null)
                ->select(
                    'user_projects.*',
                    'projects.loi',
                    'projects.survey_status_code',
                    'projects.survey_name',
                    'projWithRatio.ratio'
                )
                ->groupBy('user_projects.project_id')
                ->orderByDesc('projWithRatio.ratio')
                ->get();
            $results = $query;
        }

        return response()->json(['data' => $results]);
    }
    public function insertRewardPole(Request $request)
    {
        $validated = $request->validate([
            'weekday' => 'required|string',
            'weekdaytime' => 'required|string',
        ]);
        $user = auth()->user();
        $panelist_id = $user->panellist_id;

        $insert = DB::table('reward_page_pole')->insert([
            'panelist_id' => $panelist_id,
            'weekday' => $validated['weekday'],
            'weekday_time' => $validated['weekdaytime'],
        ]);

        return response()->json([
            'status' => $insert,
            'message' => $insert ? 'Data inserted successfully' : 'Insert failed'
        ]);
    }
}
