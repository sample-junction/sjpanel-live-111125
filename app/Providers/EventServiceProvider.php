<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'App\Events\Backend\Auth\User\BulkUserRedeemStatusChange' => [
            'App\Listeners\Inpanel\BulkChangeRedeemRequest',
        ],
        'App\Events\Frontend\Auth\UserUpdated' => [
            'App\Listeners\Frontend\MarkUserBasicDetailsFilled',
            'App\Listeners\Frontend\UpdateBasicDetailInUserAdd',
            'App\Listeners\Frontend\UpdateUserHiddenQuestionInUserAdd',
            'App\Listeners\Frontend\UserMatchProject'
        ],
        /*Need to recheck and if not in use has to be removed*/

        'App\Events\Inpanel\Auth\UserUpdated' => [
            'App\Listeners\Inpanel\UpdateUserAchievements',
            'App\Listeners\Inpanel\UserPointSync',
        ],


        'App\Events\Frontend\Auth\UserDetailedProfileComplete' => [
            'App\Listeners\Frontend\UserMatchProject'
        ],


        /*Need to recheck and if not in use has to be removed*/
        'App\Events\Inpanel\Auth\UserConfirmed' => [
            'App\Listeners\Inpanel\UserPointSync',
            'App\Listeners\Inpanel\ReferralManage',
        ],

        /*User Achievement Tracker*/
        'App\Events\Inpanel\Auth\UserAchievementUpdate' => [
            'App\Listeners\Inpanel\Auth\UserAchievementUpdateListener',
        ],

        /*User Referral Achievement Tracker*/
        'App\Events\Inpanel\Auth\UserReferralAchievementUpdate' => [
            'App\Listeners\Inpanel\Auth\UserReferralAchievementUpdateListener',
            'App\Listeners\Inpanel\Auth\UserReferredAchievementUpdateListener',
        ],


        /*User Redeem Request Event*/
        'App\Events\Inpanel\Auth\UserRedeemRequest'=>[
            //'App\Listeners\Inpanel\Auth\RedeemMailAdmin',
            'App\Listeners\Inpanel\Auth\RedeemMailUser',
        ],

        /*Need to recheck and if not in use has to be removed*/
        'App\Events\Inpanel\Project\DraftPublished' => [
            'App\Listeners\Inpanel\Project\MoveDraftToLive',
        ],
        'App\Events\Inpanel\Project\ProjectReadyToDispatch' => [
            'App\Listeners\Inpanel\Project\DispatchToUsers',
        ],
        'App\Events\Inpanel\Auth\UserBasicDetailsFilled' => [
            'App\Listeners\Inpanel\Auth\FillUserHiddenProfile',
        ],
        /*************************************************************************/

        /*Affiliate Conversion Hit that is Fired on Campaign c_type basis*/
        'App\Events\Frontend\Auth\AffiliateConversion' => [
            'App\Listeners\Frontend\Auth\SendConversionHit',
        ],

        /*After Status Changed is fired after project's status is changed from pending to Live*/
        'App\Events\Inpanel\Project\AfterStatusChanged' => [
            'App\Listeners\Inpanel\Project\Status\After\PendingListener',
            'App\Listeners\Inpanel\Project\Status\After\LiveListener',
            'App\Listeners\Inpanel\Project\Status\After\PauseListener',
            'App\Listeners\Inpanel\Project\Status\After\CancelledListener',
            'App\Listeners\Inpanel\Project\Status\After\ClosedListener',
        ],

        /*UserAssignProject is fired after assigning project to the user*/
        'App\Events\Inpanel\Project\UserAssignProject' => [
            'App\Listeners\Api\Project\Status\UserAssignProjectMailListener'
        ],

        'App\Events\Inpanel\Project\ProfileComplete' => [
            'App\Listeners\Inpanel\AffiliateCampaign\ProfileCompletedListener'
        ],

        'App\Events\Inpanel\Project\ProfileUpdate' => [
            'App\Listeners\Inpanel\MarkDetailProfileFilledListener',
            'App\Listeners\Frontend\UserMatchProject'
        ],

        'App\Events\Inpanel\Project\ProfileSurveyAttempted' => [
            'App\Listeners\Inpanel\AffiliateCampaign\ProfileCompletedSurveyAttempetedListener'
        ],
        'App\Events\Inpanel\Project\ProfileSurveyComplete' => [
            'App\Listeners\Inpanel\AffiliateCampaign\ProfileCompletedSurveyCompletedListener'
        ],
       /* 'App\Events\Inpanel\Project\StartSurvey' => [
            'App\Listeners\Api\Project\UserStartSurvey',
        ],*/


       /******************* Project Quota Update *************************************************/
        'App\Events\Inpanel\Project\ProjectQuotaUpdate' => [
            'App\Listeners\Inpanel\UpdateUserProjectListener',
        ],

    ];

    /**
     * Class event subscribers.
     *
     * @var array
     */
    protected $subscribe = [
        /*
         * Frontend Subscribers
         */

        /*
         * Auth Subscribers
         */
        \App\Listeners\Frontend\Auth\UserEventListener::class,

        /*
         * Backend Subscribers
         */

        /*
         * Auth Subscribers
         */
        \App\Listeners\Backend\Auth\User\UserEventListener::class,
        \App\Listeners\Backend\Auth\Role\RoleEventListener::class,
       /* \App\Listeners\Inpanel\ReferralManage::class,*/
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
