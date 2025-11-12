<?php

namespace App\Models\Auth\Traits;


use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Models\Auth\User;
use App\Models\Profiler\ProfileSection;
use App\Models\Profiler\UserAdditionalData;
use App\Models\StaticAchievement;
use App\Models\UserPoint;

trait AchievementsTrait
{

    /**
     * Give points in signup user
     * Change by Vikash Yadav(28-Nov-2022)
     */
    public function giveSignupPoints()
    {
        $joiningAchievement = StaticAchievement::where('code','=','account_created')->first();
        $points = $joiningAchievement->points;
        $type = "static_achievement";
        $type_code = $joiningAchievement->code;
        $type_id = $joiningAchievement->id;
        $this->createUserJoinAchievement($points,$type,$type_id,$type_code);
    }

    private function createUserJoinAchievement($points,$type,$type_id,$type_code)
    {
        if($points){

            $get_add_user_data = UserAdditionalData::where('uuid', '=', $this->getUuid() )->first();
            $join_data[$type][] = [
                "code"    => $type_code,
                "points"  => $points,
                "status"  => "completed",
            ];
            $user_achivement_data['user_achievement'] = $join_data;
            if(empty($get_add_user_data)){
                $newdata = [
                    'uuid' => $this->getUuid(),
                    'u_id' => $this->getId(),
                    'user_answers' => [],
                ];
                $create_add_data = UserAdditionalData::create($newdata);
            }

            $get_add_user_data = UserAdditionalData::where('uuid','=',$this->getUuid())->first();
            if(empty($get_add_user_data->user_achievement)){
                $get_add_user_data->push('user_achievement',$join_data);
                activity("user_achievements")
                    ->causedBy($this)
                    ->withProperties(['points'=>$points])
                    ->log('inpanel.activity_log.account_joining_points');
                return true;
            }
             $fetch_static_achievement = array_column($get_add_user_data->user_achievement,'static_achievement');
             
             $check_basic_detail = isset($fetch_static_achievement[0]) ? in_array($type_code,array_column($fetch_static_achievement[0],'code')) : false;
            if($check_basic_detail==false){
                 $points_data["code"] = $type_code;
                 $points_data["points"] = $points;
                 $points_data["status"] = "completed";
                 $data = [];
                foreach($get_add_user_data['user_achievement'] as $key=>$value){
                    if(array_key_exists("static_achievement",$value)){
                        foreach ($value as $profile_data){
                            $value['static_achievement'][] = $points_data;
                        }
                    }
                    $data['user_achievement'][] = $value;
                }
                 UserAdditionalData::where('uuid','=',$this->getUuid())
                     ->update($data);
                    activity("user_achievements")
                        ->causedBy($this)
                        ->withProperties(['points'=>$points])
                        ->log('inpanel.activity_log.account_confirmation_points');
                    return true;
                }else{
                    return false;
                }
           
        }
    }

    public function giveConfirmationPoints()
    {
        $joiningAchievement = StaticAchievement::where('code','=','user_joined')->first();
        $points = $joiningAchievement->points;
        $type = "static_achievement";
        $type_code = $joiningAchievement->code;
        $type_id = $joiningAchievement->id;
        $this->createUserAchievement($points,$type,$type_id,$type_code);
    }

    public function giveCampaignIncentivePoints(){
        $joiningAchievement = StaticAchievement::where('code','=','campaign_user_joined')->first();
        $points = $joiningAchievement->points;
        $type = "static_achievement";
        $type_code = $joiningAchievement->code;
        $type_id = $joiningAchievement->id;
        $this->createCampaignIncentiveAchievement($points,$type,$type_id,$type_code);
    }

    private function createCampaignIncentiveAchievement($points,$type,$type_id,$type_code){
        if($points){
            $get_add_user_data = UserAdditionalData::where( 'uuid', '=', $this->getUuid() )->first();
            $confirm_data[$type][] = [
                "code"  => $type_code,
                "points"  => $points,
                "status"  => "completed",
            ];
            $user_achivement_data['user_achievement'] = $confirm_data;
            if(empty($get_add_user_data)){
                $newdata = [
                    'uuid' => $this->getUuid(),
                    'u_id' => $this->getId(),
                    'user_answers' => [],
                ];
                $create_add_data = UserAdditionalData::create($newdata);
            }

            $get_add_user_data = UserAdditionalData::where('uuid','=',$this->getUuid())->first();
            if(empty($get_add_user_data->user_achievement)){
                $get_add_user_data->push('user_achievement',$confirm_data);
                activity("user_achievements")
                    ->causedBy($this)
                    ->withProperties(['points'=>$points])
                    ->log('inpanel.activity_log.campaign_incentive_points');
                return true;
            }
            $fetch_static_achievement = array_column($get_add_user_data->user_achievement,'static_achievement');
            $check_basic_detail = isset($fetch_static_achievement[0]) ? in_array($type_code,array_column($fetch_static_achievement[0],'code')) : false;
            if($check_basic_detail==false){
                 $points_data["code"] = $type_code;
                 $points_data["points"] = $points;
                 $points_data["status"] = "completed";
                 $data = [];
                foreach($get_add_user_data['user_achievement'] as $key=>$value){
                    if(array_key_exists("static_achievement",$value)){
                        foreach ($value as $profile_data){
                            $value['static_achievement'][] = $points_data;
                        }
                    }
                    $data['user_achievement'][] = $value;
                }
                 UserAdditionalData::where('uuid','=',$this->getUuid())
                     ->update($data);
                    activity("user_achievements")
                        ->causedBy($this)
                        ->withProperties(['points'=>$points])
                        ->log('inpanel.activity_log.campaign_incentive_points');
                    return true;
                }else{
                    return false;
                }
        }
    }
    
    private function createUserAchievement($points,$type,$type_id,$type_code)
    {
        if($points){
            // $update_user_points_data = [
            //     'user_id' => $this->getId(),
            //     'approved_points' => $points,
            // ];
            // $update_user_points = UserPoint::updateOrCreate($update_user_points_data);
            $get_add_user_data = UserAdditionalData::where( 'uuid', '=', $this->getUuid() )->first();
            $confirm_data[$type][] = [
                "code"  => $type_code,
                "points"  => $points,
                "status"  => "completed",
            ];
            $user_achivement_data['user_achievement'] = $confirm_data;
            if(empty($get_add_user_data)){
                $newdata = [
                    'uuid' => $this->getUuid(),
                    'u_id' => $this->getId(),
                    'user_answers' => [],
                ];
                $create_add_data = UserAdditionalData::create($newdata);
            }

            $get_add_user_data = UserAdditionalData::where('uuid','=',$this->getUuid())->first();
            if(empty($get_add_user_data->user_achievement)){
                $get_add_user_data->push('user_achievement',$confirm_data);
                activity("user_achievements")
                    ->causedBy($this)
                    ->withProperties(['points'=>$points])
                    ->log('inpanel.activity_log.account_confirmation_points');
                return true;
            }
             $fetch_static_achievement = array_column($get_add_user_data->user_achievement,'static_achievement');
             
             $check_basic_detail = isset($fetch_static_achievement[0]) ? in_array($type_code,array_column($fetch_static_achievement[0],'code')) : false;
            if($check_basic_detail==false){
                 $points_data["code"] = $type_code;
                 $points_data["points"] = $points;
                 $points_data["status"] = "completed";
                 $data = [];
                foreach($get_add_user_data['user_achievement'] as $key=>$value){
                    if(array_key_exists("static_achievement",$value)){
                        foreach ($value as $profile_data){
                            $value['static_achievement'][] = $points_data;
                        }
                    }
                    $data['user_achievement'][] = $value;
                }
                 UserAdditionalData::where('uuid','=',$this->getUuid())
                     ->update($data);
                    activity("user_achievements")
                        ->causedBy($this)
                        ->withProperties(['points'=>$points])
                        ->log('inpanel.activity_log.account_confirmation_points');
                    return true;
                }else{
                    return false;
                }
            //    UserAdditionalData::where('uuid','=',$this->getUuid())->push('user_achievement',$confirm_data);
            //    activity("user_achievements")
            //    ->causedBy($this)
            //    ->withProperties(['points'=>$points])
            //    ->log('inpanel.activity_log.account_confirmation_points');
            //     return true;
            // } else{
            //     $get_add_user_data->user_achievement = $confirm_data;
            //     $get_add_user_data->save();
            //     activity("user_achievements")
            //         ->causedBy($this)
            //         ->withProperties(['points'=>$points])
            //         ->log('inpanel.activity_log.account_confirmation_points');
            //     return true;
            // }
        }
    }

    public function give_basic_details_filled()
    {
        $get_user_confirm_points = StaticAchievement::where('code','=','basic_details_filled')->first();
        $points = $get_user_confirm_points->points;
        $type = "static_achievement";
        $type_code = $get_user_confirm_points->code;
        $type_id = $get_user_confirm_points->id;
        $this->createBasicAchievementPoints($points,$type,$type_id,$type_code);
    }
    private function createBasicAchievementPoints($points,$type,$type_id,$type_code)
    {
        if($points){
            $get_add_user_data = UserAdditionalData::where('uuid','=',$this->getUuid())->first();
            $basic_data[$type][] = [
                "code"  => $type_code,
                "points"  => $points,
                "status"  => "completed",
            ];
            $user_achivement_data['user_achievement'] = $basic_data;
            if(empty($get_add_user_data)){
                $newdata = [
                    'uuid' => $this->getUuid(),
                    'u_id' => $this->getId(),
                    'user_answers' => [],
                ];
                $create_add_data = UserAdditionalData::create($newdata);
            }
            $get_add_user_data = UserAdditionalData::where('uuid','=',$this->getUuid())->first();
            if(empty($get_add_user_data->user_achievement)){
                $get_add_user_data->push('user_achievement',$basic_data);
                activity("user_achievements")
                    ->causedBy($this)
                    ->withProperties(['points'=>$points])
                    ->log('inpanel.activity_log.basic_profile_points');
                return true;
            }
             $fetch_static_achievement = array_column($get_add_user_data->user_achievement,'static_achievement');
             
             $check_basic_detail = isset($fetch_static_achievement[0]) ? in_array($type_code,array_column($fetch_static_achievement[0],'code')) : false;
             if($check_basic_detail==false){
                 $points_data["code"] = $type_code;
                 $points_data["points"] = $points;
                 $points_data["status"] = "completed";
                 $data = [];
                 foreach($get_add_user_data['user_achievement'] as $key=>$value){
                     if(array_key_exists("static_achievement",$value)){
                         foreach ($value as $profile_data){
                             $value['static_achievement'][] = $points_data;
                         }
                     }
                     $data['user_achievement'][] = $value;
                 }
                 UserAdditionalData::where('uuid','=',$this->getUuid())
                     ->update($data);
                 activity("user_achievements")
                     ->causedBy($this)
                     ->withProperties(['points'=>$points])
                     ->log('inpanel.activity_log.basic_profile_points');
                 return true;
             } else{
                 return false;
             }
            /*$update_add_user_data = UserAdditionalData::where('uuid','=',$user->uuid)                         ->updateOrCreate($user_achivement_data);*/
        }
    }

    public function updateUserConsent($user)
    {
        $get_add_user_data = UserAdditionalData::where( 'uuid', '=', $this->getUuid() )->first();
        $consent_data[] = [
            "consent_type"  => "registration",
            "consent_text"  => "Agree On every terms and condition",
            "consent_revoked"  => false,
            "consent_created_at"  => date('Y/m/d H:i:s'),
            "consent_revoked_at"  => "",
        ];
        $user_achivement_data['user_achievement'] = $consent_data;
        if(empty($get_add_user_data)){
            $newdata = [
                'uuid' => $this->getUuid(),
                'u_id' => $this->getId(),
                'user_answers' => [],
                'user_achievement' => [],
            ];
            $create_add_data = UserAdditionalData::create($newdata);
            $create_add_data->user_consents = $consent_data;
            $create_add_data->save();
            return true;
        } else{
            return false;
        }
    }
}
