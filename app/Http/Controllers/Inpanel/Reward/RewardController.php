<?php

namespace App\Http\Controllers\Inpanel\Reward;

use App\Events\Inpanel\Auth\UserTour;
use App\Models\Profiler\UserAdditionalData;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;
use Spatie\Activitylog\Models\Activity;
use DB;
use Illuminate\Support\Facades\Crypt;

/**
 * This class is used for displaying all the rewards points received by the User..
 *
 * Class RewardController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Inpanel\Reward\RewardController
 */

class RewardController extends Controller
{
    /**
     *@param $userAdd, $userRepository
     */
    public $userAdd, $userRepository;

    /**
     * RewardController constructor.
     * @param UserAdditionalDataRepository $userAdd
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserAdditionalDataRepository $userAdd,
        UserRepository $userRepository
    )
    {
        $this->userAdd = $userAdd;
        $this->userRepository = $userRepository;

    }

    /**
     * This action is used to redirect the User to the Rewards View Page
     * where he can check all the points he had received till now
     * whether points has been completed, pending or cancelled.
     *
     * @return resource reward/index.php
     */

    public function index()
    {
        $user = Auth::user();

        //dd($user);
         $user_id=$user->id;
       
        $userPoints = $this->userRepository->getUserPoints($user);

        //echo"<pre>";print_r($userPoints); die;
        $user_activity = Activity::inLog('user_achievements')->causedBy($user)->orderBy('created_at','desc')->get();

        if(empty($userPoints)){
            $userPoints = false;
        }
        $get_user_add_data = UserAdditionalData::where('uuid','=',$user->uuid)->first();
        $tour_detail = isset($get_user_add_data->user_tour_taken) ? $get_user_add_data->user_tour_taken: 0;
        $tour_taken=0;
        if($tour_detail){
            foreach ($tour_detail as $key => $value){
                if($value['section']=='rewards' && $value['taken']==true){
                    $tour_taken=1;
                }
            }
        }
       /* $userAchievements = $user->userAchievements()->with(['achievable'])->get();*/
       /* $userAchievements = $this->Us*/
       $ReferalUser=DB::table('referral_links')
                     ->leftjoin('referral_relationships','referral_relationships.referral_link_id','=','referral_links.id')
                     ->leftjoin('users','users.id','=','referral_relationships.user_id')

                    ->select('referral_relationships.user_id','users.email','users.first_name')
                    ->where('referral_links.user_id','=',$user_id)
                    //->groupBy('products.id')
                    ->get();
        $userData=array();
        
        foreach($ReferalUser as $referUser){
             if(!empty($referUser->first_name)){
                 $after=\Crypt::decrypt($referUser->first_name);
                 $email=\Crypt::decrypt($referUser->email);
                $userData[$user_id][]=$after." (".$email.") ";
             }else{
                $userData[$user_id][]='';
             }
        }

      
        return View('inpanel.reward.index')
            ->with('userPoints', $userPoints)
            ->with('userActivities',$user_activity)
            ->with('userrefer',$userData)
             ->with('user_id',$user_id)
            ->with('tour_taken',$tour_taken);

            //->with('userAchievements', $userAchievements);
    }
}
