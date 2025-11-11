<?php

namespace App\Listeners\Inpanel\AffiliateCampaign;

use App\Events\Frontend\Auth\AffiliateConversion;
use App\Models\Affiliate\AffiliateCampaignData;
use App\Models\Project\UserProject;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileCompletedSurveyCompletedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;
        $user_projects = UserProject::where('user_id','=',$user->id)
            ->where('status','=',1)
            ->get();
        if($user->detailed_profile_filled==1 && count($user_projects)==1){
            $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
                ->with('affiliate', 'campaign')
                ->first();
            if($aff_camp_data && $aff_camp_data->campaign->c_type=="pfc_sc"){
                event(new AffiliateConversion($aff_camp_data));
                return true;
            }
        }
    }
}
