<?php

/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 09-03-2019
 * Time: 05:34 PM
 */


namespace App\Http\Controllers\Inpanel\Profiler;

use App\Events\Frontend\Auth\UserDetailedProfileComplete;
use App\Events\Frontend\Auth\UserUpdated;
use App\Events\Inpanel\Project\ProfileComplete;
use App\Events\Inpanel\Project\ProfileUpdate;
use App\Models\Country;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Profiler\ProfileSection;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Project\UserProject;
use App\Repositories\Inpanel\Profiler\DetailedProfileRepository;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;
use DateTime;
use function foo\func;
use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
use App\Models\Setting\Setting;

class ProfilerController
{

    /**
     * @var $profileSectionRepo, $detailedProfileRepo, $userAddRepo
     * @var ProfileSectionRepository
     */
    public $profileSectionRepo, $detailedProfileRepo, $userAddRepo, $userRepository,$notificationRepo, $countriesCurrenciesRepository;

    /**
     * ProfilerController constructor.
     * @param ProfileSectionRepository $profileSectionRepo
     * @param DetailedProfileRepository $detailedProfileRepo
     * @param UserAdditionalDataRepository $userAddRepo
     */

    public function __construct(
        ProfileSectionRepository $profileSectionRepo,
        DetailedProfileRepository $detailedProfileRepo,
        UserRepository $userRepository,
        UserNotificationRepository $notificationRepo,
        UserAdditionalDataRepository $userAddRepo,
		CountriesCurrenciesRepository $countriesCurrenciesRepository
    )
    {
        $this->profileSectionRepo = $profileSectionRepo;
        $this->detailedProfileRepo = $detailedProfileRepo;
        $this->userAddRepo = $userAddRepo;
        $this->notificationRepo = $notificationRepo;
        $this->userRepository = $userRepository;
		$this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
		
    }

    /**
     * Action for showing the User Detailed Profile Page View.
     * @return mixed
     */
    public function index(Request $request)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $locale = app()->getLocale();
        list($country_code, $language_code) = get_codes_from_locale($locale);
        $profile_sections = $profile_sections = $this->profileSectionRepo->getPublicProfileSections($country_code, $language_code);
        $allPointsCount = $profile_sections->sum('points');
        $user = auth()->user();
        //Code Added By Ramesh Kamboj 26-04-2024
        if(! is_null($user) && !$user->filled_basic_details) {
            
            return redirect()->route('inpanel.basic.show');
        }
        //End Here//
        $filledProfilesCount = 0;
        $filledProfilesCodes = [];
        $filledProfilesPoints = [];
        $user_filled_profiles = $this->userAddRepo->getFilledProfiles($user);

        $completedProfiles = [];
        if (!empty($user_filled_profiles) && !empty($user_filled_profiles->user_filled_profiles) ) {
            foreach ($user_filled_profiles->user_filled_profiles as $profiles) {
                $current = reset($profiles);
                $filledProfilesCodes[] = $current['code'];
                $filledProfilesCount += $current['points'];
                $filledProfilesPoints[$current['code']] = $current['points'];
            }
            if ( !empty($filledProfilesCodes) ) {
                // $profile_sections = $this->profileSectionRepo->getPublicProfileSectionsExcept($filledProfilesCodes, $country_code, $language_code);
                $completedProfiles = $this->profileSectionRepo->getPublicProfilesByCode($filledProfilesCodes, $country_code, $language_code);
            }
        }
        
        $get_user_add_data = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        $tour_detail = isset($get_user_add_data->user_tour_taken) ? $get_user_add_data->user_tour_taken: 0;
        $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='detailed-profile' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
        
        /**
         * Common code for all controllers
         * need to be moved to common file later
         * RAS
         */
        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);

        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $user_points = $this->userRepository->getUserPoints($user);
        $userPoints = $user_points->user_points['completed'];
        $fetch_user_achievement1 = $get_user_add_data->user_achievement;
        $active_user_count=count($fetch_user_achievement1);
        
        $fetch_user_achievement = $get_user_add_data->user_filled_profiles;
        if(!empty($fetch_user_achievement)){
            $count_User=count(@$fetch_user_achievement);
        }else{
            $count_User=0;
        }
        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $notifications = $this->notificationRepo->getNotification($user->uuid); 
        /**
         * End of common code - also added in return
         */

        /**Code added by RAS for new ui Ibtegrtion */
    
        $age= Carbon::parse($user->dob)->age;
        $gender = $user->gender;

        if($country_code=='US'){

            if(($gender=='Female' || $gender=='Femenina') && $age>18){

                $q_id=1000;

            } elseif(($gender=='Male' || $gender=='Masculina') && $age>18){

                $q_id=1001;

            } else{

                $q_id=10;

            }  

        }else if($country_code=='UK'){
 
            if(($gender=='Female' || $gender=='Femenina') && $age>18){
                $q_id=103;
            } elseif(($gender=='Male' || $gender=='Masculina') && $age>18){
                $q_id=108;
            } else{
                $q_id=10;
            }  
 
        }else if($country_code=='AU'){

 
            if(($gender=='Female' || $gender=='Femenina') && $age>18){
              $q_id=529;
          } elseif(($gender=='Male' || $gender=='Masculina') && $age>18){
              $q_id=1114;
          } else{
              $q_id=10;
          }  
 
      }else{

            if(($gender=='Female' || $gender=='Femelle' || $gender=='Femme' || $gender=="महिला") && $age>18){
                $q_id=162;
            } elseif(($gender=='Male' || $gender=='Homme' || $gender=="पुरुष") && $age>18){
                $q_id=1009;
            } else{
                $q_id=10;
            }

        }


        $profile_survey = [];
        $count = 0;
        $filled_pro_survey = [];
        $filled_hours_gap = [];
        $filled_up_date = [];
        $dependent_survey_ques = [];

        foreach ($profile_sections as $pro_sec){
            $ques = $this->detailedProfileRepo->getSingleProfileWithAllData_newIntegration($pro_sec->_id, $user, $q_id, $country_code, $language_code);
            foreach($ques->questions as $pro_ques){
                if($pro_ques->dependency){
                    array_push($dependent_survey_ques,$pro_ques);
                }
            }
                
            $profile_survey[$count] = $ques;
            $count++;
        }

        foreach($profile_survey as $pro_sur){
            if(in_array($pro_sur->general_name,$filledProfilesCodes)){
                [$filled_survey , $hours_gap , $updated_date ] = $this->showUpdateProfile($pro_sur->_id);
                array_push($filled_pro_survey,$filled_survey);
                array_push($filled_hours_gap,$hours_gap);
                array_push($filled_up_date,$updated_date);
            }
                        
        }
        
        $tke_survey_id = [];
        if($request->has('id')){
            array_push($tke_survey_id,$request->id);
        }
    
        /* Parshant Sharma [21-08-2024] Starts */
        
        $locale = app()->getLocale();
        
        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);		
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
        
        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {
            
            $cntry = explode('_',$countryPoint->country_language);
            
            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang'=>$cntry[1],
            );
        } 	
	    /* Parshant Sharma [21-08-2024] Ends */
        return view('inpanel.profiler.detail_profile_new')
            ->with('profile_sections', $profile_sections )
            ->with('allPointsCount', $allPointsCount )
            ->with('filledProfilesCount', $filledProfilesCount )
            ->with('filledProfilesPoints', $filledProfilesPoints )
            ->with('completedProfiles', $completedProfiles )
            ->with('completedSurveys',$user_completed_surveys)
            ->with('user_point' , $userPoints)
            ->with('userExpireSurveys',$user_expire_surveys)
            ->with('active_user_count' , $active_user_count)
            ->with('user_count' , $count_User)
            ->with('user_notifications' , $notifications)
            ->with('profile_surveys',$profile_survey)
            ->with('dependent_survey_ques',$dependent_survey_ques)
            ->with('filled_hours_gap',$filled_hours_gap)
            ->with('filled_up_date',$filled_up_date)
            ->with('filled_pro_survey',$filled_pro_survey)
            ->with('allUserSurveys',$user_assign_projects)
            ->with('tour_taken', $tour_taken)
            ->with('tke_survey_id',$tke_survey_id)
			->with('countryPoints',$countryPoints)
            ->with('currentCountry',$currentCountry)
            ->with('currencies',$currencies);
    }

    /**Added code for SJPL 97 */
    public function basicProSurveys(Request $request){
        
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $locale = app()->getLocale();
        list($country_code, $language_code) = get_codes_from_locale($locale);
        $profile_sections = $profile_sections = $this->profileSectionRepo->getPublicProfileSections($country_code, $language_code);

        $user = auth()->user();
        $age= Carbon::parse($user->dob)->age;
         $gender = $user->gender;
       
        $userAddData = UserAdditionalData::where('uuid','=',$user->uuid)->first();
       
        
        if($country_code=='US'){

              if(($gender=='Female' || $gender=='Femenina') && $age>18){

                $q_id=1000;

            } elseif(($gender=='Male' || $gender=='Masculina' ) && $age>18){

                $q_id=1001;

            } else{

                $q_id=10;

            }  

        }else if($country_code=='UK'){
 
              if(($gender=='Female' || $gender=='Femenina') && $age>18){
                $q_id=103;
            } elseif(($gender=='Male' || $gender=='Masculina') && $age>18){
                $q_id=108;
            } else{
                $q_id=10;
            }  
 
        }else{

            if(($gender=='Female' || $gender=='Femelle' || $gender=='Femme' || $gender=="महिला") && $age>18){
                $q_id=162;
            } elseif(($gender=='Male' || $gender=='Homme' || $gender=='पुरुष') && $age>18){
                  $q_id=1009;
            } else{
                $q_id=10;
            }

        }
        
        $profile_survey = [];
        $count = 0;
        $dependent_survey_ques = [];
        foreach ($profile_sections as $key => $pro_sec){
            if($key == 0 || $key == 3){
                $ques = $this->detailedProfileRepo->getSingleProfileWithAllData_newIntegration($pro_sec->_id, $user, $q_id, $country_code, $language_code);
                foreach($ques->questions as $pro_ques){
                    if($pro_ques->dependency){
                        array_push($dependent_survey_ques,$pro_ques);
                    }
                }
                    
                $profile_survey[$count] = $ques;
                $count++;
            }
            
        }

        $user_assign_projects = [];
        $active_user_count = 0;
        $user_completed_surveys = [];
        $count_User = 0;
        $user_expire_surveys = [];

        if($request->has('basic_sur_fill')){
            $display_index = 3;
        }else{
            $display_index = 0;
        }
		
		/* Parshant Sharma [21-08-2024] Starts */
		
		$locale = app()->getLocale();
		
		$countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);		
		$countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;
		
		// Initialize an empty array
		$currencies = array();

		if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {
			
			$cntry = explode('_',$countryPoint->country_language);
			
			$currencies = array(
				'currency_logo'  => $countryPoint->currency_symbols,
				'currency_denom_singular' => $countryPoint->currency_denom_singular,
				'currency_denom_plural' => $countryPoint->currency_denom_plural
			);
		} 		
		/* Parshant Sharma [21-08-2024] Ends */		
        
       return view('inpanel.basic_detail.pro_survey')
                ->with('profile_sections', $profile_sections )
                ->with('allUserSurveys',$user_assign_projects)
                ->with('active_user_count' , $active_user_count)
                ->with('completedSurveys',$user_completed_surveys)
                ->with('user_count' , $count_User)
                ->with('userExpireSurveys',$user_expire_surveys)
                ->with('dependent_survey_ques',$dependent_survey_ques)
                ->with('profile_surveys',$profile_survey)
                ->with('display_index',$display_index)
				->with('countryPoints',$countryPoints)
                ->with('currentCountry',$currentCountry)
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
         
         $age= Carbon::parse($user->dob)->age;
       
        
		  $gender = $user->gender;
       
        $locale = app()->getLocale();
        list($country_code, $language_code) = get_codes_from_locale($locale);

        $userAddData = UserAdditionalData::where('uuid','=',$user->uuid)->first();
 
        if($country_code=='US'){

              if(($gender=='Female' || $gender=='Femenina') && $age>18){

                $q_id=1000;

            } elseif(($gender=='Male' || $gender=='Masculina') && $age>18){

                $q_id=1001;

            } else{

                $q_id=10;

            }  

        }else if($country_code=='UK'){
 
              if(($gender=='Female' || $gender=='Femenina') && $age>18){
                $q_id=103;
            } elseif(($gender=='Male' || $gender=='Masculina') && $age>18){
                $q_id=108;
            } else{
                $q_id=10;
            }  
 
        }else{

            if(($gender=='Female' || $gender=='Femelle' || $gender=='Femme' || $gender=="महिला") && $age>18){

                $q_id=162;

            } elseif(($gender=='Male' || $gender=='Homme' || $gender=="पुरुष") && $age>18){
                $q_id=1009;

            } else{

                $q_id=10;

            }

        }
      
        $profile = $this->detailedProfileRepo->getSingleProfileWithAllData($id, $user, $country_code, $language_code,$q_id);
        
        $projectionArray['user_answers'] = [
            '$elemMatch' => ['profile_section_code' => "$profile->general_name"]
        ];
		
        $user_answers = [];
        foreach ($userAddData->user_answers as $key => $value) {
		
            if($value['profile_section_code']==$profile->general_name){
                
				foreach ($profile->questions as $data) {
				
                     $dataOther = $data->id . '_OTHER';
					 $dataSelectOther = $data->id . '_SELECT_OTHER';	
					 				 
					if($data->id==$value['profile_question_code']){
					 
                        if(is_array($value['selected_answer'])){
                            $answer = implode(',',$value['selected_answer']);
                        }else{
                            $answer = $value['selected_answer'];
                        }
						
						if(($data->userAnswers) && (!$data->userAnswers->isEmpty())){
							
							$data->userAnswers->put('user_answer', $answer);
							
						}else{
						     $data->userAnswers = collect([
								'user_answer' => $answer,
							]);						    
						
						}	
						
                        break;
						
                    }elseif($dataOther==$value['profile_question_code']){
					
					   if(is_array($value['selected_answer'])){
                            $answer = implode(',',$value['selected_answer']);
                        }else{
                            $answer = $value['selected_answer'];
                        }
						
						if(($data->userAnswers) && (!$data->userAnswers->isEmpty())){
							 
							 $data->userAnswers->put('other', $answer);
							 
						}else{
						     $data->userAnswers = collect([
								'other' => $answer,
							]);						    
						
						}
                         
                        break;
					}elseif($dataSelectOther==$value['profile_question_code']){
					    
					   if(is_array($value['selected_answer'])){
                            $answer = implode(',',$value['selected_answer']);
                        }else{
                            $answer = $value['selected_answer'];
                        }
						
						if(($data->userAnswers) && (!$data->userAnswers->isEmpty())){
								$data->userAnswers->put('selectother', $answer);
								
						}else{
						     $data->userAnswers = collect([
								'selectother' => $answer,
							]);						    
						
						}
                         
                        break;
					}
					
                }
            }
        }
		
        $detailedFilledProfile = array_column($userAddData->user_achievement,'detail_filled_profile');
        
        foreach ($detailedFilledProfile[0] as $val) {
            if($val['code'] == $profile->general_name && !empty($val['updated_at'])){
                $updated_date = $val['updated_at'];
                break;
            }else{
                $updated_date = "";
            }
        }
        $start_date = new DateTime(date('Y/m/d H:m:s'));
        $days_gap = $start_date->diff(new DateTime($updated_date));
		$hours_gap = (($days_gap->m)*24*30) + (($days_gap->d)*24) + ($days_gap->h);

        return [$profile, $hours_gap, $updated_date];
            
    }

    
/**Added by RAS 08/12/23 */
    public function saveDetailProfile_new(Request $request, $id){
         
        $basicDetailFlag = false;
        $redirectFlag = false;
        $form_data = $request->all();
        if(array_key_exists('basic_detail_sur',$form_data)){
            unset($form_data['basic_detail_sur']);
            if($form_data['index'] == 0){
                $basicDetailFlag = true;
            }else{
                $redirectFlag = true;
            }
            unset($form_data['index']);
        }
        
        unset($form_data['_token']);
        $locale = app()->getLocale();
        list($country_code, $language_code) = get_codes_from_locale($locale);
        $user = auth()->user();

        $user_filled_profiles = $this->userAddRepo->getFilledProfiles($user);

		$profile = $this->detailedProfileRepo->getSingleProfileWithAllData($id, $user, $country_code, $language_code);
        // echo '<pre>';
        // print_r($profile);die();
        $user_inputs = $form_data;
        foreach($user_inputs as $key => $value){
            $inputs = [$key => $value];
            $question_names = array_keys($inputs);
            $this->detailedProfileRepo->saveSingleProfileUserAnswer($user, $profile, $inputs, $question_names, $country_code, $language_code);
        }
        
        $user->syncUserFilledProfiles($user, $profile, true);
        activity()
            ->causedBy($user)
            ->log('inpanel.activity_log.profile.'.$profile->general_name.'.updated');
        $user = auth()->user();
        $filledProfilesCodes = [];
        $user_filled_profiles = $this->userAddRepo->getFilledProfiles($user);
        $completedProfiles = [];
        if (!empty($user_filled_profiles) && !empty($user_filled_profiles->user_filled_profiles) ) {
            foreach ($user_filled_profiles->user_filled_profiles as $profiles) {
                $current = reset($profiles);
                $filledProfilesCodes[] = $current['code'];
            }
            if ( !empty($filledProfilesCodes) ) {
                $profile_sections = $this->profileSectionRepo->getPublicProfileSectionsExcept($filledProfilesCodes, $country_code, $language_code);
                $next_profile = $profile_sections->first();
                $completedProfiles = $this->profileSectionRepo->getPublicProfilesByCode($filledProfilesCodes, $country_code, $language_code);
            }
        }
        if (!empty($next_profile)) {
            event(new ProfileUpdate($next_profile,$user));
        }else{
            event(new ProfileUpdate(null,$user));
        }
        if($basicDetailFlag){
            return redirect()->route('inpanel.basic.pro',['basic_sur_fill' => true]);
        }
        if($redirectFlag){
            $update = $this->userRepository->update($user->id, ['filled_basic_details' => 1]);
            
            return redirect()->route('inpanel.dashboard')->withFlashSuccess(__('strings.frontend.user.profile_updated'));
        }
        // Code added By Anil
        $points=$profile->points;
        return \Redirect::back()->with([
            'flash_success' => [
                __('inpanel.profiler.update_success'),
                __('inpanel.profiler.update_success2', ['points' => $points])
            ]
        ]);        
    }
/**End code - RAS */
   
    // public function updateDetailProfile(Request $request, $id)
    // {
    //     $user = auth()->user();
    //     $locale = app()->getLocale();
    //     list($country_code, $language_code) = get_codes_from_locale($locale);
    //     $profile_id = $request->id;

    //     $profileData = $this->detailedProfileRepo->getProfileByObjectId($profile_id, $country_code, $language_code);
    //     $updatedAnswers = $request->except(['_token','update_date','hours_gap', 'profileName']);
		
	// 	// new code for profile name
	// 	$profileName = $request->input('profileName',false);
        
	// 	$update_date = $request->input('update_date',false);
    //     $hours_gap = $request->input('hours_gap',false);
		
    //     // if( $update_date && $hours_gap < config('app.update_time_threshold.hours') ){
    //     //     return \Redirect::back()
    //     //         ->withErrors([__("inpanel.questions.threshold_message",['hours_left' => config('app.update_time_threshold.hours')-$hours_gap])]);
    //     // }
		
    //     $userAddData = UserAdditionalData::where('uuid','=',$user->uuid)->first();
    //     $userAnswers = $userAddData->user_answers;
    //     $user_updated_answers = [];
		
    //     foreach ($userAnswers as $answer){
    //         //dd($answer);
			
	// 		$dataOther = $answer['profile_question_code'] . '_OTHER';
	// 		$dataSelectOther = $answer['profile_question_code'] . '_SELECT_OTHER';
			
	// 		if($answer['profile_section_code'] == $profileName){					
	// 		}else{				
	// 				$user_updated_answers[] = $answer;
	// 			}
    //     }
		
	// 	foreach ($updatedAnswers as $key => $value){
           
	// 				$ans['profile_section_code'] = $profileName;
	// 				$ans['profile_question_code'] = $key;
	// 				$ans['selected_answer'] = $value;
	// 				$user_updated_answers[] = $ans;
	// 	}
		
    //     $userAddData->user_answers = $user_updated_answers;
    //     $userAchievements = $userAddData->user_achievement;
    //     $finalUserAchievements = [];
    //     foreach ($userAchievements as $data) {
    //         $updated_user_achievements = [];
    //         if(array_key_first($data)=="detail_filled_profile"){
    //            foreach ($data as $val){
    //                $array = array_search($profileData->general_name, array_column($val,'code'));
    //                $val[$array] = array_replace($val[$array],['updated_at'=>date('Y/m/d H:m:s')]);
    //                $updated_user_achievements['detail_filled_profile'] = $val;
    //                break;
    //            }
    //         }else{
    //             $updated_user_achievements = $data;
    //         }
    //         $finalUserAchievements[] = $updated_user_achievements;
    //     }
    //     $userAddData->user_achievement = $finalUserAchievements;
    //     $userAddData->save();
    //     event(new ProfileUpdate($profileData,$user));
		
    //     return \Redirect::back()->withFlashSuccess(__('inpanel.profiler.update_success'));
    // }

    public function updateDetailProfile(Request $request, $id)
    {
        $user = auth()->user();
        $locale = app()->getLocale();
        list($country_code, $language_code) = get_codes_from_locale($locale);
        $profile_id = $request->id;

        $profileData = $this->detailedProfileRepo->getProfileByObjectId($profile_id, $country_code, $language_code);
        
        // Filter out null or empty values from updatedAnswers
        $updatedAnswers = array_filter($request->except(['_token','update_date','hours_gap', 'profileName']), function($value) {
            return $value !== null && $value !== '' && !(is_array($value) && empty(array_filter($value)));
        });
        
        $profileName = $request->input('profileName',false);
        $update_date = $request->input('update_date',false);
        $hours_gap = $request->input('hours_gap',false);
        $profileUpdateTime = Setting::where('key', 'PROFILE_UPDATE_TIME')->pluck('value')->first() ?? 24;
        
        if( $update_date && $hours_gap < $profileUpdateTime ){
           return \Redirect::back()
                ->withErrors([__("inpanel.questions.threshold_message",['hours_left' => $profileUpdateTime-$hours_gap])]);
        }
        $userAddData = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        $userAnswers = $userAddData->user_answers;
        $user_updated_answers = [];
        
        foreach ($userAnswers as $answer) {
            $dataOther = $answer['profile_question_code'] . '_OTHER';
            $dataSelectOther = $answer['profile_question_code'] . '_SELECT_OTHER';
            
            if($answer['profile_section_code'] == $profileName) {
                // Skip answers from this profile section as we'll update them
            } else {                
                $user_updated_answers[] = $answer;
            }
        }
        
        foreach ($updatedAnswers as $key => $value) {
            // Only add if value is not null or empty
            if ($value !== null && $value !== '' && !(is_array($value) && empty(array_filter($value)))) {
                $ans['profile_section_code'] = $profileName;
                $ans['profile_question_code'] = $key;
                $ans['selected_answer'] = $value;
                $user_updated_answers[] = $ans;
            }
        }
        
        $userAddData->user_answers = $user_updated_answers;
        $userAchievements = $userAddData->user_achievement;
        $finalUserAchievements = [];
        
        foreach ($userAchievements as $data) {
            $updated_user_achievements = [];
            if(array_key_first($data)=="detail_filled_profile") {
                foreach ($data as $val) {
                    $array = array_search($profileData->general_name, array_column($val,'code'));
                    $val[$array] = array_replace($val[$array],['updated_at'=>date('Y/m/d H:m:s')]);
                    $updated_user_achievements['detail_filled_profile'] = $val;
                    break;
                }
            } else {
                $updated_user_achievements = $data;
            }
            $finalUserAchievements[] = $updated_user_achievements;
        }
        
        $userAddData->user_achievement = $finalUserAchievements;
        $userAddData->save();
        event(new ProfileUpdate($profileData,$user));
        
        return \Redirect::back()->withFlashSuccess(__('inpanel.profiler.update_success'));
    }
    public function allCountryTranslations()
    {
        $jsonData = json_decode(file_get_contents(__DIR__ . '/country.json'), true);
        $country_trans= [];
        foreach($jsonData as $country){
            $country_data = [];
            if($country['is_filterable'] == 1){
                $country_data['country_code'] = $country['country_code'];
                $country_data['country_name'] = $country['name'];
                 $country_data['capital'] = $country['capital'];
                $country_data['currency_code'] = $country['currency_code'];
                $country_data['iso_3166_2'] = $country['iso_3166_2'];
                $country_data['iso_3166_3'] = $country['iso_3166_3'];
                $country_data['currency_symbol'] = $country['currency_symbol'];
                $country_data['currency_decimals'] = $country['currency_decimals'];
                $country_data['calling_code'] = $country['calling_code'];
                $country_data['flag'] = $country['flag'];
                $country_data['translation'] = $this->getCountryTranslation($country);
                $country_trans[] = $country_data;
            }
        }
        $json = json_encode($country_trans);
        file_put_contents(__DIR__ . DIRECTORY_SEPARATOR. "country_trans.json", $json);
        dd("done");
    }

    private function getCountryTranslation($country)
    {
        $lang = explode(',',$country['language']);
        $trans = [];
        if($lang){
            foreach($lang as $language){
                $trans[] = [
                    'con-lang' => $country['country_code']."-".$language,
                    'name' => $country['name'],
                    'citizenship' => $country['citizenship'],
                    'capital' => $country['capital'],
                ];
            }
            return $trans;
        }
    }
	
	
	/**
     * Action for get text field when click on other option.
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getOtherField(Request $request, $id)
    {
		$requestData = $request->input('generalName', false);
		
		return view("inpanel.profiler.includes.partials.other")
                ->with('generalName', $requestData );

    }
	
	/**
     * Action for get text field when click on select with other option.
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function getWithOtherField(Request $request, $id)
    {
		$requestData = $request->input('generalName', false);
		
		return view("inpanel.profiler.includes.partials.selectother")
                ->with('generalName', $requestData );

    }
}
