<?php

namespace App\Http\Controllers\Backend\Auth\feasibility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Inpanel\General\GeneralRepository;
use App\Repositories\Backend\Auth\UserRepository;
use App\Models\Profiler\UserAdditionalData;
use App\Models\Profiler\ProfilerQuestions;
use App\Models\Profiler\ProfileSection;
use App\Repositories\Inpanel\Profiler\DetailedProfileRepository;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
// use MongoDB\BSON\ObjectId;

class FeasibilityController extends Controller
{
       /**
     * @param $userRepository
     * @param $generalRepository
     */
    protected $generalRepository,$profileSectionRepo,$detailedProfileRepo,$userRepository;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     * @param GeneralRepository $generalRepository
     */
    public function __construct(
    GeneralRepository $generalRepository, 
    ProfileSectionRepository $profileSectionRepo,
    DetailedProfileRepository $detailedProfileRepo, UserRepository $userRepository)
    {
        $this->generalRepository = $generalRepository;
        $this->profileSectionRepo = $profileSectionRepo;
        $this->detailedProfileRepo = $detailedProfileRepo;
        $this->userRepository = $userRepository;
	
    }



    public function index(){
        $countries = $this->generalRepository->getActiveCountries();       
        return view('backend.auth.feasibility.index')
               ->with('countries',$countries);
    }


    public function get_lang(Request $request){

        $country_code = $request->country_code;
        $countries = $this->generalRepository->getActiveCountries();
        $count = $countries->where('country_code','=',$country_code);    
    
        foreach($count as $country){ 
            if($country->translation[0]['con-lang']){
                $languages[]= $country->translation[0]['con-lang'];
                if(isset($country->translation[1]['con-lang'])){
                    $languages[]= $country->translation[1]['con-lang'];
                }
            }  
        } 

        return $languages;
    }


    public function criteria(Request $request){
        $language = $request->lang;
        list($country_code, $language_code) = explode('-', $language);
        $selected_criteria = $request->selected_criteria;
        $jsonString = html_entity_decode($selected_criteria);
        $array = json_decode($jsonString, true);
        $profile_sections = $this->profileSectionRepo->getPublicProfileSections($country_code, $language_code);
        $questions = $this->getAvailableProfilesSection($country_code, $language_code);
        if(!empty($selected_criteria)){
            return view('backend.auth.feasibility.selected_criteria_details')
                   ->with('questions',$questions)
                   ->with('profile_sections', $profile_sections)->with('selected_criteria',$array);
        }else{
            return view('backend.auth.feasibility.criteria_details')
                   ->with('questions',$questions)
                   ->with('profile_sections', $profile_sections);
        }        
    }

    public function selectedCriteria(Request $request){
        try {
            $language = $request->lang;
            list($country_code, $language_code) = explode('-', $language);
            $selected_criteria = $request->selected_criteria;
            $jsonString = html_entity_decode($selected_criteria);
            $array = json_decode($jsonString, true);
            $profile_sections = $this->profileSectionRepo->getPublicProfileSections($country_code, $language_code);
            $questions = $this->getAvailableProfilesSection($country_code, $language_code);
            return view('backend.auth.feasibility.selected_criteria_details')
                       ->with('questions',$questions)
                       ->with('profile_sections', $profile_sections)->with('selected_criteria',$array);
        } catch (\Exception $e) {
               // Log the exception
               \Log::error('Exception occurred: '.$e->getMessage());

               // Return an error response or redirect with error message
               return response()->json(['error' => 'Something went wrong. Please try again.'], 500);
        }
    }



    public function check_feasibility(Request $request){
        $input_datas = $request->all();
        $criteria = $input_datas['selected_criteria'];
        $u_id = array();
        if(!empty($criteria)){
            $searchCriteria = json_decode($criteria, true);
            $dataObject = json_decode($criteria);
            $query = UserAdditionalData::query();

            foreach ($searchCriteria as $criteria) {
                $query->where(function ($q) use ($criteria) {
                    $q->where('user_answers.profile_section_code', $criteria['profile_section_code'])
                      ->where('user_answers.profile_question_code', $criteria['profile_question_code'])
                      ->whereIn('user_answers.selected_answer', $criteria['selected_answer']);
                });
            }

            $results = $query->get();
            foreach ($results as $key => $value) {
                $u_id[]= $value->u_id;
            }
            $userIds = array_map('strval', $u_id);
            $user_ids = json_encode($userIds);
            $user_ids = str_replace('\"', '"', $user_ids);
            //echo $user_ids;exit;
        }
       /* $devices = array_map('strval', $input_datas['device']);
        $user_devices = json_encode($devices);
        $user_devices = str_replace('\"', '"', $user_devices);*/
        //$devices = implode(',', $input_datas['device']);
        $device =  $input_datas['device'];
        $devices = array();
        foreach ($device as $key => $value) {
            $devices[]= (int) $value;
        }
        $local = explode('-', $input_datas['lang_code']);
        $localValue = strtolower($local[1]).'_'.$local[0];
        $dataArray = ['u_id'=>$u_id,'device'=> $devices,'local'=>$localValue,'country_code'=>$input_datas['country_code']];
        $panelist = $this->userRepository->getFeasibilePanelist($dataArray);
        return view('backend.auth.feasibility.response_feasibility')->with('search', $input_datas)->with('panelist', $panelist);
      }

      
    public function getAvailableProfilesSection($country_code, $language_code)
    {
              
            $profile_sections = $this->profileSectionRepo->getPublicProfileSections($country_code, $language_code);
            $q_id = 10;

            $cacheKey = 'profile_survey_' . $q_id;

            // Check if the data is already cached
            if (Cache::has($cacheKey)) {
                // Retrieve the data from the cache
                $profile_survey = Cache::get($cacheKey);
            } else {
                // Data is not cached, fetch it
                $profile_survey = [];
                $count = 0;
                $dependent_survey_ques = [];
                foreach ($profile_sections as $key => $pro_sec) {
                    $ques = $this->getAllProfileQuestions($pro_sec->_id,$q_id,$country_code, $language_code);
                    foreach ($ques->questions as $pro_ques) {
                        if ($pro_ques->dependency) {
                            array_push($dependent_survey_ques, $pro_ques);
                        }
                        $profile_survey[$count] = $ques;
                        $count++;
                    }
                }
                
                // Cache the data
                Cache::put($cacheKey, $profile_survey);
            }

    return $profile_survey;
}

public function getAllProfileQuestions($profile_id,$q_id,$country_code, $language_code)
    {
        // $country_code = config('locale.default_country');
        // $language_code = config('locale.default_language');
        
        if($q_id==1000){
            $data=[1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }
        elseif($q_id==1001){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }else{
            $data=[10,1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }
        $sectionProjection = ProfileSection::getProjectionArray($country_code, $language_code);
        $profile = ProfileSection::where('_id', '=', $profile_id)->project($sectionProjection)->first();
        $questionsProjection = ProfilerQuestions::getProjectionArray($country_code, $language_code);
        $profleQuestions = ProfilerQuestions::where('country_code', '=', $country_code)
            ->whereNotIn('q_id', $data)
            ->project($questionsProjection)
            ->orderBy('order')
            ->get();
        $profile->questions = $profleQuestions;
       
        return $profile;
    }
 

}
