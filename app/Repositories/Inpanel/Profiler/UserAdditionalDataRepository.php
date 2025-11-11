<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 12-03-2019
 * Time: 02:16 PM
 */

namespace App\Repositories\Inpanel\Profiler;


use App\Models\Profiler\UserAdditionalData;

/**
 * This class is used to handle all the functionality which is used to save the detailed profile answer to the user_add_data
 * with giving achievements.
 *
 * Class UserAdditionalDataRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository
 */
class UserAdditionalDataRepository
{

    /*******************Need to recheck the method if it is in use or not***************************************/
    public function getUserAnswers($user, $profile_code)
    {
        //$answerProjection = UserAdditionalData::getAnswersProjectionArray( $profile_code );
        $userProfileAnswers = UserAdditionalData::where('uuid', '=', $user->uuid)
            ->whereRaw( [ 'user_answers' => ['$elemMatch' => ['profile_section_code' => "$profile_code"]] ] )
            //->where('user_answers.profile_section_code', '=', $profile_code)
            //->project($answerProjection)
            ->first();
        return $userProfileAnswers;
    }


    /**
     * This action is used for Retrieve User's Specific Answer for particular Profile Section.
     *
     * @param $user
     * @param $profile_code
     * @return mixed
     */
    public function getUserAnswersSpecificProfile($user, $profile_code)
    {
        $data = UserAdditionalData::raw(function($collection) use ($user, $profile_code) {
            return $collection->aggregate([
                [
                    '$match' => [
                        'uuid' => $user->uuid
                    ]
                ],
                [
                    '$addFields' => [
                        'user_answers' => [
                            '$filter' => ['input' => '$user_answers', 'as' => 'user_answer', 'cond' => [ '$eq' => ['$$user_answer.profile_section_code', $profile_code] ]]
                        ]
                    ]
                ]
            ]);
        })->first();
        return $data;
    }

    /**
     * This action is used for creating the answer column for the first time
     * or to update it later after as he provide the detailed profile answers.
     *
     * @param $user
     * @param $profile_code
     * @param $question_code
     * @param $answer
     * @return bool
     */
    public function createOrUpdateAnswer($user, $profile_code, $question_code, $answer)
    {
        $answerProjection = UserAdditionalData::getAnswersProjectionArray( $profile_code, $question_code );
        $userProfileAnswers = UserAdditionalData::where('uuid', '=', $user->uuid)
            ->project($answerProjection)
            ->first();

        $answersArray = [
            'profile_section_code' => $profile_code,
            'profile_question_code' => $question_code,
            'selected_answer' => $answer
        ];
        if (empty($userProfileAnswers)) {
            $newdata = [
              'uuid' => $user->uuid,
              'u_id' => $user->id,
              'user_answers' => [$answersArray],
            ];
            UserAdditionalData::create($newdata);
            return true;
        }

        if( empty($userProfileAnswers->user_answers) ){
            $userProfileAnswers->push('user_answers', [$answersArray]);
            $userProfileAnswers->save();
            return true;
        }

        $completeData = UserAdditionalData::where('uuid', '=', $user->uuid)->first();

        $userAnswers = [];
        foreach ($completeData->user_answers as $answerData) {
            if( $answerData['profile_section_code'] == $profile_code && $answerData['profile_question_code'] == $question_code ){
                $answerData['selected_answer'] = $answer;
            }
            $userAnswers[] = $answerData;
        }
        $completeData->user_answers = $userAnswers;
        $completeData->save();
        return true;
    }

    /**
     * This action is used for deleting the User Answer during show the previous questions.
     *
     * @param $user
     * @param $question_code
     * @param $profile_code
     */
    public function deleteUserAnswer($user, $question_code, $profile_code)
    {
        $question_code_other = $question_code."_OTHER";
		$question_code_select_other = $question_code."_SELECT_OTHER";
		
		$get_all_answers = UserAdditionalData::where('uuid', '=', $user->uuid)->get();
        if(!empty($get_all_answers)) {
            $data = [];
            foreach ($get_all_answers as $answer) {
                foreach ($answer['user_answers'] as $key => $value) {
                    
					if ($value['profile_section_code'] == $profile_code && ( ($value['profile_question_code'] == $question_code) || ($value['profile_question_code'] == $question_code_other) || ($value['profile_question_code'] == $question_code_select_other) )) {
                        continue;
                    }
					
                    $data['user_answers'][] = $value;
                }
            }
        }
        $userAnswers = UserAdditionalData::where('uuid', '=', $user->uuid)
                        ->update($data);
                       
    }

    /**
     * This action is used when the User completes the detailed profile
     * the filled profile and its points is saved in this actions.
     *
     * @param $user
     * @param $data
     */
    public function updateUserFilledProfile($user, $data)
    {
        $userAddData = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $userAddData->push('user_filled_profiles', $data, true);
        $userAddData->save();

    }

    /*******************Need to recheck the method if it is in use or not***************************************/
    public function sumOfAllPoints($user)
    {
        $total = 0;
        $userAddData = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        foreach($userAddData->user_achievement as $index=>$value){
            foreach($value as $code=>$points){
                foreach ($points as $point=>$val)
                $total=$total+$val;
            }
        }
    }

    /**
     * This action is used for getting all the filled profile with their points.
     *
     * @param $user
     * @return mixed
     */
    public function getFilledProfiles($user)
    {
        $userFilledProfiles = UserAdditionalData::where('uuid', '=', $user->uuid)
            ->select('user_filled_profiles')
            ->first();
        return $userFilledProfiles;
    }

    /**
     * This action is used for getting all the filled profile count.
     *
     * @param $user
     * @return int
     */
    public function getFilledProfilesCount($user)
    {
        $userFilledProfiles = UserAdditionalData::where('uuid', '=', $user->uuid)
            ->select('user_filled_profiles')
            ->first();

        return (!empty($userFilledProfiles) && !empty($userFilledProfiles->user_filled_profiles))
            ? count($userFilledProfiles->user_filled_profiles)
            : 0;
    }

    /**
     * This action for checking user answer by the dependency of the questions.
     *
     * @param $user
     * @param $questionCode
     * @param $profileCode
     * @param $precode
     * @return bool
     */
    public function checkUserAnswer($user, $questionCode, $profileCode, $precode)
    {
        $projectionData = UserAdditionalData::$answersProjectionArray;
        $projectionData['user_answers'] = [
            '$elemMatch' => [
                'profile_question_code' => "$questionCode",
                'profile_section_code' => "$profileCode",
            ]
        ];
        $userAnswers = UserAdditionalData::where('uuid', '=', $user->uuid)
            ->whereRaw( ['user_answers' => ['$elemMatch' => [
                'profile_question_code' => "$questionCode",
                'profile_section_code' => "$profileCode",
            ]]])
            ->project($projectionData)
            ->first();
        if(!empty($userAnswers) && !empty($userAnswers->user_answers) ){
            $user_answer = $userAnswers->user_answers[0];
            if($user_answer['selected_answer']){
                $matched_answer = array_intersect($user_answer['selected_answer'],$precode);
                $count = count($matched_answer);
                if($count>0){
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * This Action for giving detailed profile points to the user and updating it in user achievements columns
     * and also updating user points columns in User Additional Data.
     *
     * @param $user
     * @param $profile
     * @return bool
     */
    public function giveDetailedProfilePoint($user,$profile)
    {
       $profile_code = $profile->general_name;
        $profile_points = $profile->points;
        $updated_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        if(empty($updated_user_add_data)){
            $newdata = [
                'uuid' => $user->uuid,
                'u_id' => $user->id,
                'user_answers' => [],
            ];
            $user_achivement_data['user_achievement'] = [];
            $create_add_data = UserAdditionalData::create($newdata);
            UserAdditionalData::where('uuid','=',$create_add_data->uuid)->push($user_achivement_data);
            return true;
        }
        if(!$updated_user_add_data->user_filled_profiles) {
            $user_filled_data['user_filled_profiles'][] = [
                $profile->general_name => [
                  'code' => $profile->general_name,
                  'points' => $profile->points,
                ],
            ];
            UserAdditionalData::where('uuid','=',$user->uuid)->push($user_filled_data);
            $this->logProfileAchievementActivity($user,$profile);
        }
        /*Todo implement check for user_achievement*/
            $fetch_user_achievement = $updated_user_add_data->user_achievement;
            $user_achievement = [];
            $points_data = [];
            if($fetch_user_achievement){
                if(empty(array_column($fetch_user_achievement,"detail_filled_profile"))) {
                            $points_data["code"] = $profile_code;
                            $points_data["points"] = $profile_points;
                            $points_data["status"] = "completed";
                            $points_data["updated_at"] = date('Y/m/d H:m:s');
                            $user_achievement['detail_filled_profile'][] = $points_data;
                        $updated_user_add_data->push("user_achievement", $user_achievement);
                    $this->logProfileAchievementActivity($user,$points_data);
                        return true;
                }
                $achievements = array_column($fetch_user_achievement,"detail_filled_profile");
                 //dd(array_column($achievements[0], 'code'));
                $user_achieve_present_code =in_array($profile_code,array_column($achievements[0], 'code'));
                //dd($user_achieve_present_code);
                if($user_achieve_present_code==false){
                    $points_data["code"] = $profile_code;
                    $points_data["points"] = $profile_points;
                    $points_data["status"] = "completed";
                    $points_data["updated_at"] = date('Y/m/d H:m:s');
                    $data = [];
                    foreach($updated_user_add_data['user_achievement'] as $key=>$value){
                        if(array_key_exists("detail_filled_profile",$value)){
                            foreach ($value as $profile_data){
                                $value['detail_filled_profile'][] = $points_data;
                            }
                        }
                        $data['user_achievement'][] = $value;
                    }
                    UserAdditionalData::where('uuid', '=', $user->uuid)
                        ->update($data);
                    $this->logProfileAchievementActivity($user,$points_data);
                    return true;
                }
            }else{
                return true;
            }

    }

    /**
     * This action is used for Adding activity log as the User Completes any profile.
     *
     * @param $user
     * @param $profile
     */
    private function logProfileAchievementActivity($user,$profile)
    {
            activity("user_achievements")
            ->causedBy($user)
            ->withProperties(["points"=> $profile['points']])
            ->log('inpanel.activity_log.profile.'.$profile['code'].'.achieved');
    }
}
