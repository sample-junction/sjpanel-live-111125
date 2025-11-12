<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 11-03-2019
 * Time: 06:19 PM
 */

namespace App\Repositories\Inpanel\Profiler;


use App\Models\Profiler\ProfilerQuestions;
use App\Models\Profiler\ProfileSection;
use App\Models\Profiler\UserAdditionalData;
use MongoDB\BSON\ObjectId;



class DetailedProfileRepository
{

    /**
     * @var $userAddRepo
     * @var UserAdditionalDataRepository
     */
    public $userAddRepo;
    public function __construct(UserAdditionalDataRepository $userAddRepo)
    {
        $this->userAddRepo = $userAddRepo;
    }


    public function getSingleProfileWithAllData($profile_id, $user, $country_code = null, $language_code = null,$q_id=null)
    {
          
         $data=[];
         if($q_id==1009){
            $data=[1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,162];
        }
        if($q_id==162){
            $data=[1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009];
        }
        if($q_id==103){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009,108];
        }
        if($q_id==108){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009,103];
        }
         
        if(empty($country_code))
            $country_code = config('locale.default_country');

        if(empty($language_code))
            $language_code = config('locale.default_language');
        $sectionProjection = ProfileSection::getProjectionArray($country_code, $language_code);
        $profile = ProfileSection::where('_id', '=', $profile_id)->project($sectionProjection)->first();
        $questionsProjection = ProfilerQuestions::getProjectionArray($country_code, $language_code);
        $profleQuestions = ProfilerQuestions::where('profile_section_id', '=', new ObjectId($profile_id))
            ->where('country_code', '=', $country_code)
            ->whereNotIn('q_id', $data)
            ->project($questionsProjection)
            ->get();

        
        $profile->questions = $profleQuestions;

        return $profile;
    }

    /**Added by RAS on 06/12/23 - for sjpl70 */
    public function getSingleProfileWithAllData_newIntegration($profile_id, $user,$q_id, $country_code = null, $language_code = null)
    {
        if(empty($country_code))
            $country_code = config('locale.default_country');

        if(empty($language_code))
            $language_code = config('locale.default_language');
        
        if($q_id==1000){
            $data=[1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }elseif($q_id==1114){
            $data = [529];
        }elseif($q_id==529){
            $data = [1114];
        }
        elseif($q_id==1001){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }elseif($q_id==1009){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,162,468];
        }elseif($q_id==162){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009,1028];
        }elseif($q_id==103){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009,108];
        }elseif($q_id==108){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009,103];
        }else{
            $data=[10,1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009,103,104,108];
        }

        $sectionProjection = ProfileSection::getProjectionArray($country_code, $language_code);
        $profile = ProfileSection::where('_id', '=', $profile_id)->project($sectionProjection)->first();
        $questionsProjection = ProfilerQuestions::getProjectionArray($country_code, $language_code);
        $profleQuestions = ProfilerQuestions::where('profile_section_id', '=', new ObjectId($profile_id))
            ->where('country_code', '=', $country_code)
            ->whereNotIn('q_id', $data)
            ->project($questionsProjection)
            ->orderBy('order')
            ->get();
        $profile->questions = $profleQuestions;
       
        return $profile;
    }
    /**End code */
    public function getProfileWithAllData($country_code = null, $language_code = null)
    {
        if(empty($country_code))
            $country_code = config('locale.default_country');

        if(empty($language_code))
            $language_code = config('locale.default_language');

        $sectionProjection = ProfileSection::getProjectionArray($country_code, $language_code);
        $profile = ProfileSection::project($sectionProjection)->first();
        $questionsProjection = ProfilerQuestions::getProjectionArray($country_code, $language_code);
        $profleQuestions = ProfilerQuestions::where('country_code', '=', $country_code)
            ->project($questionsProjection)
            ->get();
        $profile->questions = $profleQuestions;

        return $profile;
    }

    public function getProfileByObjectId($profile_id, $country_code = null, $language_code = null){
        if(empty($country_code))
            $country_code = config('locale.default_country');
        if(empty($language_code))
            $language_code = config('locale.default_language');

        $sectionProjection = ProfileSection::getProjectionArray($country_code, $language_code);
        $profile = ProfileSection::where('_id', '=', $profile_id)->project($sectionProjection)->first();
        return $profile;
    }

    /*public function getUserProfileNextQuestionId( $user, $profile)
    {
        $profileQuestion = $this->getNextSingleQuestion( $user, $profile );
        return $profileQuestion;
    }*/

    public function getNextSingleQuestion($user, $profile, $country_code = null, $language_code = null, $q_id = null,$last_question_id = false)
    {
       
        if(empty($country_code))
            $country_code = config('locale.default_country');

        if(empty($language_code))
            $language_code = config('locale.default_language');
        $userAnswers = $this->userAddRepo->getUserAnswersSpecificProfile($user, $profile->general_name);
        
        $matchingQuestions = [];
        if( !empty($userAnswers) && !empty($userAnswers->user_answers) ){
            foreach ($userAnswers->user_answers as $answer) {
                $matchingQuestions[] = $answer->profile_question_code;
            }
        }
        
        $questionsProjection = ProfilerQuestions::getProjectionArray($country_code, $language_code);
        
        if($q_id==1000){
            $data=[1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }
        elseif($q_id==1001){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }
        elseif($q_id==1009){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,162];
        }elseif($q_id==162){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009];
        }
        else{
            $data=[10,1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762,1009];
        }
        
        if(empty($q_id)){
        $profileQuestion = ProfilerQuestions::where('profile_section_id', '=', new ObjectId($profile->_id))
            ->where('country_code', '=', $country_code)
            ->orderBy('order')
            ->whereNotIn('general_name', $matchingQuestions)
            ->where(function($q) use ($last_question_id) {
                if($last_question_id){
                    $q->whereIn('_id', $last_question_id, 'AND', true);
                }
            })
            ->project($questionsProjection)
            ->first();
        }else{
            $profileQuestion = ProfilerQuestions::where('profile_section_id', '=', new ObjectId($profile->_id))
            ->where('country_code', '=', $country_code)
            //->where('q_id', '!=', 10)
            ->whereNotIn('q_id', $data)
            ->orderBy('order')
            ->whereNotIn('general_name', $matchingQuestions)
            ->where(function($q) use ($last_question_id) {
                if($last_question_id){
                    $q->whereIn('_id', $last_question_id, 'AND', true);
                }
            })
            ->project($questionsProjection)
            ->first();
        }
        
        if(empty($profileQuestion)){
            return false;
        }
        $profile_deps = $profileQuestion['dependency'];
        // echo '<pre>';
        // print_r(($profileQuestion));die();
        
        if( empty($profile_deps) ){
            return $profileQuestion;
        }
        $profile_deps = json_decode($profile_deps, true);
        if ( !$profile_deps ){
            return $profileQuestion;
        }
        $count_flag = false;
        foreach($profile_deps as $dep){
            $questionCode = $dep['question_code'];
            $profileCode = $dep['profile_section_name'];
            $precode = $dep['precode'];
            $check_dep = $this->userAddRepo->checkUserAnswer($user, $questionCode, $profileCode, $precode );
            $count_flag = $check_dep;
            if($count_flag){
                break;
            }
        }
        if($count_flag===false){
            return $profileQuestion;
        }
        /*$userAnswers = UserAnswer::where('user_id', '=', $user_id)
            ->where(function($q) use ($profile_deps) {
                foreach($profile_deps as $option){
                    $q->orWhere(function($query) use ($option) {
                        $query->where('profile_question_id', '=',$option['id'])
                            ->where('user_answer', '=',$option['val']);
                    });
                }
            })
            ->count();

        if($userAnswers == 0){
            return $profileQuestion;
        }*/
        $last_question_id[] = new ObjectId($profileQuestion->_id);
        return $this->getNextSingleQuestion($user, $profile, $country_code, $language_code, $q_id, $last_question_id);
    }

    public function saveSingleProfileUserAnswer($user, $profile, $inputs, $question_names, $country_code = null, $language_code = null)
    {
        if(empty($country_code))
            $country_code = config('locale.default_country');

        if(empty($language_code))
            $language_code = config('locale.default_language');

        $questionsProjection = ProfilerQuestions::getProjectionArray($country_code, $language_code);
        $question = ProfilerQuestions::where('profile_section_id', '=', new ObjectId($profile->_id))
            ->whereIn('general_name', $question_names)
            ->where('country_code', '=', $country_code)
            ->project($questionsProjection)
            ->first();
        
        if(empty($question))
            return false;

        foreach($inputs as $name => $answer){
            
            if( !is_array($answer) ){
                $answer = explode(',', $answer);
            }
			
			 //$other = end(explode("_", $name));
			 //$other = 'OTHER';
			/* if($other == 'OTHER'){
			  $question->general_name = $name;
			 }else{
			  $question->general_name = $question->general_name;
			 }
			 */
			 
			$question->general_name = $name;
            $this->userAddRepo->createOrUpdateAnswer($user, $profile->general_name, $question->general_name, $answer);
        }
    }

    public function getLastQuestion($user, $profile, $current_question_id, $country_code = null, $language_code = null,$q_id = null)
    {
        $activeQuestion = ProfilerQuestions::where('general_name', '=', $current_question_id)
            ->where('profile_section_id', '=', new ObjectId($profile->_id))
            ->where('country_code', '=', $country_code)
            ->first();

        $questionsProjection = ProfilerQuestions::getProjectionArray($country_code, $language_code);
        if($q_id==1000){
            $data=[1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }
        elseif($q_id==1001){
            $data=[10,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }else{
            $data=[10,1001,766,755,751,718,64,65,76,77,79,903,824,702,700,696,694,687,641,635,616,617,762];
        }
        if(empty($q_id)){
        $profileQuestion = ProfilerQuestions::where('profile_section_id', '=', new ObjectId($profile->_id))
            ->where('country_code', '=', $country_code)
            ->where('order', '<', $activeQuestion->order)
            ->project($questionsProjection)
            ->orderBy('order', 'desc')
            ->first();
        }else{
            $profileQuestion = ProfilerQuestions::where('profile_section_id', '=', new ObjectId($profile->_id))
            ->where('country_code', '=', $country_code)
            //->where('q_id', '!=', 10)
            ->whereNotIn('q_id', $data)
            ->where('order', '<', $activeQuestion->order)
            ->project($questionsProjection)
            ->orderBy('order', 'desc')
            ->first(); 
        }
        /*Todo Sort by order*/
        if(empty($profileQuestion)){
            return false;
        }
        $profile_deps = $profileQuestion->dependency;
        if( empty($profile_deps) ){
            return $profileQuestion;
        }
        $profile_deps = json_decode($profile_deps, true);
        if( !$profile_deps ){
            return $profileQuestion;
        }
        $count_flag = false;
        foreach($profile_deps as $dep){
            $questionCode = $dep['question_code'];
            $profileCode = $dep['profile_section_name'];
            $precode = $dep['precode'];
            $check_dep = $this->userAddRepo->checkUserAnswer($user, $questionCode, $profileCode, $precode );
            $count_flag = $check_dep;
            if($count_flag){
                break;
            }
        }
        if($count_flag===false){
            return $profileQuestion;
        }
        /*$userAnswers = UserAnswer::where('user_id', '=', $user_id)
            ->where(function($q) use ($profile_deps) {
                foreach($profile_deps as $option){
                    $q->orWhere(function($query) use ($option) {
                        $query->where('profile_question_id', '=',$option['id'])
                            ->where('user_answer', '=',$option['val']);
                    });
                }
            })
            ->count();

        if( $userAnswers == 0){
            return $profileQuestion;
        }*/
       
        $skipId = $profileQuestion->id;
        return $this->getLastQuestion($user, $profile, $skipId, $country_code, $language_code ,$q_id);
    }

    public function getPendingQuestionsCount($user, $profile,$language_code,$nextQuestion)
    {
        $profileSection = new ProfileSectionRepository();
        $profile_code = $profile->general_name;
        $country = strtoupper($user->country_code);
        $get_total_questions = $profileSection->getTotalQuestions($profile_code,$country);

        $total_questions = count($get_total_questions );
        /*Todo used different function for UserAnswer*/
        $get_user_answered = $this->userAddRepo->getUserAnswersSpecificProfile($user,$profile_code);
        /* dd($get_user_answered);*/
        $selected_answer = [];
        /* dd($get_user_answered);*/
        if( !empty($get_user_answered) && !empty($get_user_answered->user_answers) ){
            $answered = $get_user_answered ->user_answers;
            foreach($answered as $answer){
                $selected_answer[] = $answer['selected_answer'];
            }
            $completed= count($selected_answer);
        } else{
            $completed = 0;
        }

        return array( 'total'=>$total_questions, 'answered' => $completed);
    }


}
