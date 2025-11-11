<?php

namespace App\Listeners\Inpanel\AffiliateCampaign;

use App\Events\Frontend\Auth\AffiliateConversion;
use App\Models\Affiliate\AffiliateCampaignData;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileCompletedListener
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
        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
            ->with('affiliate', 'campaign')
            ->first();
        if($aff_camp_data && $aff_camp_data->campaign->c_type=="profile_cmp"){
            event(new AffiliateConversion($aff_camp_data));
            return true;
        }
    }
}
