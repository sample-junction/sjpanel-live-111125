<?php

namespace App\Listeners\Frontend\Auth;

use App\Events\Frontend\Auth\AffiliateConversion;
use App\Events\Frontend\Auth\UserConfirmed;
use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Models\Affiliate\AffiliateCampaign;
use App\Models\Affiliate\AffiliateCampaignData;
use App\Models\Affiliate\AffiliateList;
use Carbon\Carbon;

/**
 * Class UserEventListener.
 */
class UserEventListener
{
    /**
     * Action after the User Log in and than saving this action to the activity logs.
     * @param $event
     */
    public function onLoggedIn($event)
    {
        $ip_address = request()->getClientIp();

        // Update the logging in users time & IP
        $event->user->fill([
            'last_login_at' => Carbon::now()->toDateTimeString(),
            'last_login_ip' => $ip_address,
        ]);

        // Update the timezone via IP address
        $geoip = geoip($ip_address);

        if ($event->user->timezone !== $geoip['timezone']) {
            // Update the users timezone
            $event->user->fill([
                'timezone' => $geoip['timezone'],
            ]);
        }

        $event->user->save();

        \Log::info('User Logged In: '.$event->user->full_name);
        activity("user_status")
            ->causedBy($event->user)
            ->log('inpanel.activity_log.log_in');
    }

    /**
     * Action executes as user logged out and action to save to activity log
     * @param $event
     */
    public function onLoggedOut($event)
    {
        \Log::info('User Logged Out: '.$event->user->full_name);
        activity("user_status")
            ->causedBy($event->user)
            ->log('inpanel.activity_log.log_out');
    }

    /**
     * Action executes as user register account and if the user is from Promo Registration thamn redirecting him to client redirecting link.
     * @param $event
     */
    public function onRegistered($event)
    {
        \Log::info('User Registered: '.$event->user->full_name);
        $user = $event->user;
        $userInput = $event->userInputData;

        if($userInput && array_key_exists('consent',$userInput)){
            $user->updateUserConsent($user);
        }

        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
            ->with('affiliate', 'campaign')
            ->first();

        if($aff_camp_data && $aff_camp_data->campaign->c_type=="soi"){
            event(new AffiliateConversion($aff_camp_data));
            return true;
        }

        //this code update by vikash(28-Nov-2022)
        if ( config('app.points.achievement.user_signup') ) {
            $user->giveSignupPoints();
            event(new UserAchievementUpdate($user));
        }

    }

    /**
     * @param $event
     */
    public function onProviderRegistered($event)
    {
        \Log::info('User Provider Registered: '.$event->user->full_name);
    }

    /**
     * Action after confirming the ACCOUNT by the user and if the user is for Promo Registration so redirceting direct him to AffiliateConversion Event or if not than providing him the User Achievement Points .
     * @param $event
     */
    public function onConfirmed($event)
    {
        \Log::info('User Confirmed: '.$event->user->full_name."id".$event->user->id);
        $user = $event->user;
        $aff_camp_data = AffiliateCampaignData::where('user_id','=',$user->id)
            ->with('affiliate', 'campaign')
            ->first();
            \Log::info('aff_camp_data: '.json_encode($aff_camp_data));
        if($aff_camp_data && $aff_camp_data->campaign->c_type=="doi"){
             \Log::info('doi: '.$event->user->full_name);
             $user->giveConfirmationPoints();
            event(new AffiliateConversion($aff_camp_data));
            return true;
        }

        if ( config('app.points.achievement.user_confirm') ) {
            $user->giveConfirmationPoints();
            event(new UserAchievementUpdate($user));
        }
        \Log::info('Checking campaign session: '.session('campaign'));
        if(session()->has('campaign')){
            $user->giveCampaignIncentivePoints();
            event(new UserAchievementUpdate($user));
        }
    }
    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Frontend\Auth\UserLoggedIn::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onLoggedIn'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserLoggedOut::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onLoggedOut'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserRegistered::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onRegistered'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserProviderRegistered::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onProviderRegistered'
        );

        $events->listen(
            \App\Events\Frontend\Auth\UserConfirmed::class,
            'App\Listeners\Frontend\Auth\UserEventListener@onConfirmed'
        );
    }
}
