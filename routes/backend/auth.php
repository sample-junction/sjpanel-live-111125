<?php
use App\Http\Controllers\Backend\Auth\Affiliate\AffiliateController;
use App\Http\Controllers\Backend\Auth\RedeemPoints\UserRedeemPointsController;
use App\Http\Controllers\Backend\Auth\Role\RoleController;
use App\Http\Controllers\Backend\Auth\User\UserController;
use App\Http\Controllers\Backend\Auth\User\UserAccessController;
use App\Http\Controllers\Backend\Auth\User\UserSocialController;
use App\Http\Controllers\Backend\Auth\User\UserStatusController;
use App\Http\Controllers\Backend\Auth\User\UserSessionController;
use App\Http\Controllers\Backend\Auth\User\UserPasswordController;
use App\Http\Controllers\Backend\Auth\User\UserConfirmationController;
use App\Http\Controllers\Backend\Auth\Setting\SettingController;
use App\Http\Controllers\Backend\Auth\Support\SupportController;
use App\Http\Controllers\Backend\Auth\Reward\RewardController;
use App\Mail\Inpanel\Support\PanelistBirthdayMail;
use App\Http\Controllers\Backend\Auth\Invite\InviteCampaignController;
use App\Http\Controllers\Backend\Auth\Campaign\campaignmailController;
use App\Http\Controllers\Backend\Auth\Survey_campaign\surveyCampaignController;
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Backend\Auth\feasibility\FeasibilityController;
use App\Http\Controllers\Backend\Auth\question_answer\QuestionanswerController;
use App\Http\Controllers\Backend\Auth\Setting\CountriesCurrenciesController;
use App\Http\Controllers\Backend\Auth\Reward\CountryInfoController;
use App\Http\Controllers\Backend\Auth\Reward\PointSystemController;
use App\Http\Controllers\Backend\Auth\Reward\AwardsMailTemplateController; // added by himanshu 03-10-2025


/*
 * All route names are prefixed with 'admin.auth'.
 */
Route::group([
    'prefix'     => 'auth',
    'as'         => 'auth.',
    'namespace'  => 'Auth',
    'middleware' => ['permission:access user management'],
], function () {
    /*
     * User Management
     */
    Route::group(['namespace' => 'User'], function () {

        /*
         * User Status'
         */
        Route::get('user/deactivated', [UserStatusController::class, 'getDeactivated'])->name('user.deactivated');
        Route::get('user/deleted', [UserStatusController::class, 'getDeleted'])->name('user.deleted');

        /*
         * User CRUD
         */
        Route::get('user', [UserController::class, 'index'])->name('user.index');
        Route::get('user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('user', [UserController::class, 'store'])->name('user.store');
        Route::get('panelist-master', [UserController::class, 'userFraud'])->name('panelist');
        Route::get('monthly-award', [UserController::class, 'monthlyAward'])->name('monthlyAward');
        Route::post('user/fraud', [UserController::class, 'userFraud'])->name('user.fraud');
        Route::post('user/insertfraud', [UserController::class, 'InsertuserFraud'])->name('user.insertfraud');
        Route::post('user/updatenotification', [UserController::class, 'UpdateNotification'])->name('user.updatenotification');
        Route::post('user/exportUserProfile', [UserController::class, 'exportUserProfile'])->name('user.exportUserProfile');
        Route::post('user/importFraudUser', [UserController::class, 'importFraudUser'])->name('user.importFraudUser');
        Route::get('doi-remider-all', [UserController::class, 'doiRemainderAll'])->name('doi-all');
        Route::get('doi-remider/{panelist_id}', [UserController::class, 'doiRemainder'])->name('doi-reminder');
        Route::get('active-panelist-count', [UserController::class, 'listActivePanallistCounts'])->name('active-panelist-list');

		
        //End Here//
        /*
         * Specific User
         */
        Route::group(['prefix' => 'user/{user}'], function () {
            // User
            Route::get('/', [UserController::class, 'show'])->name('user.show');
            Route::get('edit', [UserController::class, 'edit'])->name('user.edit');
            Route::patch('/', [UserController::class, 'update'])->name('user.update');
            Route::delete('/', [UserController::class, 'destroy'])->name('user.destroy');

            // Account
            Route::get('account/confirm/resend', [UserConfirmationController::class, 'sendConfirmationEmail'])->name('user.account.confirm.resend');

            // Status
            Route::get('mark/{status}', [UserStatusController::class, 'mark'])->name('user.mark')->where(['status' => '[0,1]']);

            // Social
            Route::delete('social/{social}/unlink', [UserSocialController::class, 'unlink'])->name('user.social.unlink');

            // Confirmation
            Route::get('confirm', [UserConfirmationController::class, 'confirm'])->name('user.confirm');
            Route::get('unconfirm', [UserConfirmationController::class, 'unconfirm'])->name('user.unconfirm');

            // Password
            Route::get('password/change', [UserPasswordController::class, 'edit'])->name('user.change-password');
            Route::patch('password/change', [UserPasswordController::class, 'update'])->name('user.change-password.post');

            // Access
            Route::get('login-as', [UserAccessController::class, 'loginAs'])->name('user.login-as');

            // Session
            Route::get('clear-session', [UserSessionController::class, 'clearSession'])->name('user.clear-session');

            // Deleted
            Route::get('delete', [UserStatusController::class, 'delete'])->name('user.delete-permanently');
            Route::get('restore', [UserStatusController::class, 'restore'])->name('user.restore');

        });
    });

    /*
     * Role Management
     */

    Route::group(['namespace' => 'Role'], function () {
        Route::get('affiliate-list', [AffiliateController::class, 'affiliateList'])->name('affiliate.list');
        Route::get('affiliate/campaign', [\App\Http\Controllers\Backend\Auth\AffiliateCampaign\AffiliateCampaignController::class, 'index'])->name('affiliate.campaign');
        Route::get('affiliate/campaign/edit/{campaign_id}', [\App\Http\Controllers\Backend\Auth\AffiliateCampaign\AffiliateCampaignController::class, 'editCampaign'])->name('affiliate.campaign.edit');
        Route::post('affiliate/campaign/post/{campaign_id}', [\App\Http\Controllers\Backend\Auth\AffiliateCampaign\AffiliateCampaignController::class, 'postUpdateCampaign'])->name('affiliate.campaign.edit.post');
        Route::get('affiliate/campaign/data-table', [\App\Http\Controllers\Backend\Auth\AffiliateCampaign\AffiliateCampaignController::class, 'datatable'])->name('affiliate.campaign.datatable');
        Route::get('affiliate/campaign/create', [\App\Http\Controllers\Backend\Auth\AffiliateCampaign\AffiliateCampaignController::class, 'createCampaign'])->name('campaign.create');
        Route::post('affiliate/campaign/create', [\App\Http\Controllers\Backend\Auth\AffiliateCampaign\AffiliateCampaignController::class, 'postCreateCampaign'])->name('campaign.create.post');
        Route::get('affiliate/campaign-data', [\App\Http\Controllers\Backend\Auth\AffiliateCampaignData\AffiliateCampaignDataController::class, 'index'])->name('campaign.data');
        Route::get('affiliate/campaign_data/data-table', [\App\Http\Controllers\Backend\Auth\AffiliateCampaignData\AffiliateCampaignDataController::class, 'datatable'])->name('affiliate.campaign.data.datatable');
        Route::get('affiliate/campaign-data/data-table', [AffiliateController::class, 'dataTable'])->name('affiliate.list.datable');
        Route::get('affiliate-list/edit/{affiliate_id}', [AffiliateController::class, 'editAffiliateList'])->name('affiliate.list.edit');
        Route::get('affiliate-list/create', [AffiliateController::class, 'createAffiliate'])->name('affiliate.list.create');
        Route::post('affiliate-list/post', [AffiliateController::class, 'postCreateProject'])->name('affiliate.create.post');
        Route::post('affiliate-list/post/{affiliate_id}', [AffiliateController::class, 'postUpdateAffiliate'])->name('affiliate.edit.post');

        // Created by obhi
        Route::get('campaign-show-history',[campaignmailController::class,'showCampaignHistory'])->name('show-campaign-history');
        
        Route::get('campaign-show',[campaignmailController::class,'showCampaign'])->name('show-campaign');
        Route::get('campaign-send',[campaignmailController::class,'sendCampaign'])->name('campaign-send');
        Route::get('campaignGetById',[campaignmailController::class,'getCampaigndetail'])->name('campaignGetById');
        Route::get('campaign-Template',[campaignmailController::class,'campaignTemplate'])->name('campaign-Template');
        Route::post('new-campaign-template',[campaignmailController::class,'newCampaignTemplate'])->name('new-campaign-template');
        Route::get('template-detail',[campaignmailController::class,'templateDetail'])->name('template-detail');

        Route::get('gallery-page',[campaignmailController::class,'editGallery'])->name('gallery-page');

        Route::get('edit-template',[campaignmailController::class,'templateEdit'])->name('edit-template');
        Route::post('update-template',[campaignmailController::class,'templateUpdate'])->name('update-template');
        Route::get('del-template',[campaignmailController::class,'templateDel'])->name('del-template');
        Route::get('get-template',[campaignmailController::class,'getTemplate'])->name('get-template');
        Route::post('create-campaign',[campaignmailController::class,'createCampaign'])->name('create-campaign');
        Route::get('edit-campaign',[campaignmailController::class,'editCampaign'])->name('edit-campaign');
        Route::post('update-campaign',[campaignmailController::class,'updateCampaign'])->name('update-campaign');
        Route::get('del-campaign',[campaignmailController::class,'delCampaign'])->name('del-campaign');
        Route::get('show-clone',[campaignmailController::class,'showCloneCampaign'])->name('show-clone');
        Route::post('create-clone',[campaignmailController::class,'createCloneCampaign'])->name('create-clone');
        Route::get('activate-or-deactive-camp',[campaignmailController::class,'activeOrdeactive'])->name('activate-or-deactive-camp');

        Route::get('show-survey-invite',[surveyCampaignController::class,'showSurveyInvite'])->name('show-survey-invite');
        Route::get('panel-bonus',[surveyCampaignController::class,'panelBonusshow'])->name('panel-bonus');
        Route::get('show-survey-temp',[surveyCampaignController::class,'showSurveyTemp'])->name('show-survey-temp');
        Route::post('create-survey-temp',[surveyCampaignController::class,'createSurveyTemp'])->name('create-survey-temp');
        Route::get('edit-survey-temp',[surveyCampaignController::class,'editSurveyTemp'])->name('edit-survey-temp');
        Route::post('update-survey_temp',[surveyCampaignController::class,'updateSurveytemp'])->name('update-survey_temp');
        Route::get('del-survey-temp',[surveyCampaignController::class,'deleteSurveytemp'])->name('del-survey-temp');
        Route::get('show-suvery-temp-detail',[surveyCampaignController::class,'showSurveyTempDetail'])->name('show-suvery-temp-detail');
        Route::get('get-survey-temp-byid',[surveyCampaignController::class,'getSurveyTempbyid'])->name('get-survey-temp-byid');
        //Route Create By Parshant//
        Route::get('panelistUpload', [SettingController::class, 'panelistUpload'])->name('panelist_upload');
        //End Here//
        Route::post('survey-reminder-create',[surveyCampaignController::class,'surveyReminderCreate'])->name('survey-reminder-create');
        Route::get('show-edit-survey-reminder',[surveyCampaignController::class,'editSurveyReminder'])->name('show-edit-survey-reminder');
        Route::post('update-survey-reminder',[surveyCampaignController::class,'updateSurveyReminder'])->name('update-survey-reminder');
        Route::get('show-clone-survey-reminder',[surveyCampaignController::class,'showCloneSurveyreminder'])->name('show-clone-survey-reminder');
        Route::post('update-clone-survey-reminder',[surveyCampaignController::class,'updateCloneSurveyreminder'])->name('update-clone-survey-reminder');
        Route::get('del-survey-reminder',[surveyCampaignController::class,'delSurveyReminder'])->name('del-survey-reminder');
        Route::get('show-send-survey-reminder',[surveyCampaignController::class,'showSendSurveyReminder'])->name('show-send-survey-reminder');
        Route::get('survey-reminder-getById',[surveyCampaignController::class,'SurveyReminderGetById'])->name('survey-reminder-getById');
        Route::get('survey-details-ByCode',[surveyCampaignController::class,'surveyDetailsByCode'])->name('survey-details-ByCode');
        Route::post('send-Survey-Reminder-Mail',[surveyCampaignController::class,'sendSurveyReminderMail'])->name('send-Survey-Reminder-Mail');
        
        Route::get('active-deactive-survey',[surveyCampaignController::class,'activeOrdeactivesurvey'])->name('active-deactive-survey');

        Route::get('reconcilation-rejection',[surveyCampaignController::class,'ReconcilationRejection'])->name('reconcilation-rejection');
        Route::get('show-feasibility',[FeasibilityController::class,'index'])->name('show-feasibility');
        Route::get('Language',[FeasibilityController::class,'get_lang'])->name('Language');
        Route::get('display-criteria',[FeasibilityController::class,'criteria'])->name('display-criteria');
        Route::post('display-selected-criteria',[FeasibilityController::class,'selectedCriteria'])->name('display-selected-criteria');
        Route::post('check-feasibility',[FeasibilityController::class,'check_feasibility'])->name('check-feasibility');
        Route::get('show-unsubscribe',[surveyCampaignController::class,'showUnsubscribe'])->name('show-unsubscribe');
        Route::get('expense-record',[surveyCampaignController::class,'expenseRecord'])->name('expense-record');
    });





    Route::group(['namespace' => 'RedeemPoints'], function () {
        Route::get('redeem-history', [UserRedeemPointsController::class, 'redeemHistory'])->name('redeem_history'); //dushyant 7july22 for redeemhistory
        Route::get('redeem-request', [UserRedeemPointsController::class, 'redeemRequest'])->name('redeem_points');
        Route::post('redeem-request/upload', [UserRedeemPointsController::class, 'uploadRequest'])->name('redeem.upload');
        Route::post('redeem-request', [UserRedeemPointsController::class, 'redeemRequest'])->name('redeem_points');
        Route::post('redeem-request/upload', [UserRedeemPointsController::class, 'uploadRequest'])->name('redeem.upload');
        Route::get('redeem-request/approve/{user_uuid}/{redeem_id}', [UserRedeemPointsController::class, 'approveRequest'])->name('approve.redeem_points');
        Route::get('redeem-request/coupon-sent/{user_uuid}/{redeem_id}', [UserRedeemPointsController::class, 'couponSend'])->name('coupon_sent.redeem_points');
        Route::get('redeem-request/ribbon-notified/{user_uuid}/{redeem_id}', [UserRedeemPointsController::class, 'ribbonNotified'])->name('ribbon_notified.redeem_points');
        Route::get('redeem-request/coupon_redeem/{user_uuid}/{redeem_id}', [UserRedeemPointsController::class, 'couponRedeem'])->name('coupon_redeem.redeem_points');
         Route::get('redeem-request/coupon_lapsed/{user_uuid}/{redeem_id}', [UserRedeemPointsController::class, 'couponLapsed'])->name('coupon_lapsed');
        Route::get('redeem-request/approve/data-table', [UserRedeemPointsController::class, 'dataTable'])->name('redeem.request.datatable');
        Route::get('redeem-history/data-table', [UserRedeemPointsController::class, 'dataTableRedeemHistory'])->name('redeem.history.dataTableRedeemHistory');
        Route::post('redeem-request/approve-selected', [UserRedeemPointsController::class, 'approveAllSelected'])->name('approve.all_selected');
        Route::get('redeem-request/exportData', [UserRedeemPointsController::class, 'exportReedemRequest'])->name('redeem.export-data');
    });


    Route::group(['namespace' => 'User'], function () {
        Route::get('reports/response', [UserController::class, 'panelResponse'])->name('reports.response'); //dushyant 7july22 for redeemhistory
        Route::get('reports/active', [UserController::class, 'reportactive'])->name('reports.active');
        Route::post('reports/active', [UserController::class, 'reportactive'])->name('reports.active');
        Route::get('reports/incentive', [UserController::class, 'reportincentive'])->name('reports.incentive');
        Route::post('reports/incentive', [UserController::class, 'reportincentive'])->name('reports.incentive');
        Route::get('reports/rejection', [UserController::class, 'reportrejection'])->name('reports.rejection');
        Route::get('reports/survey-report', [UserController::class, 'surveyReport'])->name('reports.survey_report');
        Route::get('reports/conversion-rate', [UserController::class, 'conversionRate'])->name('reports.conversionRate');
        
        Route::get('survey', [UserController::class, 'reportsurvey'])->name('reports.survey');
        Route::get('all-survey', [UserController::class, 'reportallsurvey'])->name('reports.allsurvey');
        Route::get('survey-report',  [UserController::class, 'surveyReport'])->name('reports.survey_report');
        Route::get('survey/survey-details/{user_uuid}', [UserController::class, 'reportDetails'])->name('reports.survey_details');
        Route::get('survey-participation', [UserController::class, 'surveyParticipation'])->name('reports.survey_participation');      
        Route::get('survey-participation/export', [UserController::class, 'exportSurveyParticipation'])->name('reports.survey_participation.export');        
        /* *added by Anil */
        Route::get('survey/panelist_live_survey_details/{panelist_id}', [UserController::class, 'panelist_survey_detail'])->name('reports.panelist_live_survey_details');
        Route::get('reports/panelist_survey_history', [UserController::class, 'panelist_survey_history'])->name('reports.panelist_survey_history');
	    Route::post('sendPullInvite', [UserController::class, 'sendPullInvite'])->name('sendPullInvite');
	    Route::post('sendReminderInvite', [UserController::class, 'sendReminderInvite'])->name('sendReminderInvite');
        /* *added by Anil End*/
    });


    Route::group(['namespace' => 'Role'], function () {
        Route::get('role', [RoleController::class, 'index'])->name('role.index');
        Route::get('role/create', [RoleController::class, 'create'])->name('role.create');
        Route::post('role', [RoleController::class, 'store'])->name('role.store');

        Route::group(['prefix' => 'role/{role}'], function () {
            Route::get('edit', [RoleController::class, 'edit'])->name('role.edit');
            Route::patch('/', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/', [RoleController::class, 'destroy'])->name('role.destroy');
        });
    });
    Route::get('unique-ip-check', [UserController::class, 'uniqueIPCheck'])->name('setting.unique_ip_check');
    Route::post('unique-ip-check', [UserController::class, 'postUniqueIPCheck'])->name('setting.unique_ip_check.post');
    Route::get('blacklisted-ip', [UserController::class, 'blackListedIps'])->name('setting.blacklisted_ip');
    Route::get('add-ips', [UserController::class, 'addIps'])->name('setting.add.unique_ip_check');
    Route::post('add-ips', [UserController::class, 'postIps'])->name('setting.post.unique_ip_check');   
    Route::get('nominee-count', [UserController::class, 'nomineeCount'])->name('setting.nominee_count');

    Route::group(['namespace' => 'Setting'], function () {
        Route::get('setting/active_fraud_setting', [SettingController::class, 'activeFraudSetting'])->name('setting.active_fraud_setting'); 
        Route::post('setting/post/active_fraud_setting', [SettingController::class, 'activeFraudSetting'])->name('setting.post.active_fraud_setting'); 
        Route::get('setting/pointSystemSetting', [SettingController::class, 'pointSystemSetting'])->name('setting.point_system_setting'); 
        Route::post('setting/post/pointSystemSetting', [SettingController::class, 'pointSystemSetting'])->name('setting.post.point_system_setting'); 
        Route::get('setting/invitePullDuration', [SettingController::class, 'pull_invite_duration'])->name('setting.pull_invite_duration'); 
        Route::post('setting/invitePullDuration', [SettingController::class, 'pull_invite_duration_save'])->name('setting.pull_invite_duration_save'); 
        Route::post('setting/invitePullDuration/del', [SettingController::class, 'pull_invite_duration_delete'])->name('setting.pull_invite_duration_delete'); 
                
        Route::get('setting/surveyLuckyDraw', [SettingController::class, 'surveyLuckyDraw'])->name('setting.survey_lucky_draw'); 
        Route::post('setting/post/surveyLuckyDraw', [SettingController::class, 'surveyLuckyDraw'])->name('setting.post.survey_lucky_draw');
        /* routes added for master currency data : priyanka(08-aug-2024)*/
            Route::get('setting/countriesPoints', [CountriesCurrenciesController::class, 'index'])->name('setting.countries_points'); 
            Route::get('setting/countriesPoints/create', [CountriesCurrenciesController::class, 'create'])->name('setting.countries_create'); 
            Route::post('setting/countriesPoints/store', [CountriesCurrenciesController::class, 'store'])->name('setting.countries_store'); 
            Route::get('setting/countriesPoints/show/{id}', [CountriesCurrenciesController::class, 'show'])->name('setting.countries_show');
            Route::get('setting/countriesPoints/{id}/edit', [CountriesCurrenciesController::class, 'edit'])->name('setting.countries_edit');
            Route::put('setting/countriesPoints/update/{id}', [CountriesCurrenciesController::class, 'update'])->name('setting.countries_update');
            Route::delete('setting/countriesPoints/destroy/{id}', [CountriesCurrenciesController::class, 'destroy'])->name('setting.countries_destroy');
        /* routes added for master currency data : priyanka(08-aug-2024)*/
        
    });

    Route::group(['namespace' => 'Reward'], function () {
        Route::get('reward/rewards_automation', [RewardController::class, 'rewardsAutomation'])->name('reward.rewards_automation'); 
        Route::post('reward/process_rewards_automation', [RewardController::class, 'processRewardsAutomation'])->name('reward.process_rewards_automation'); 		
        Route::post('reward/save', [RewardController::class, 'saveReward'])->name('reward.save'); 		
        Route::post('reward/calculate_amount', [RewardController::class, 'calculatePointsAmount'])->name('reward.calculate_amount'); 	

        Route::get('reward/credit_joining_points', [PointSystemController::class, 'creditJoiningPoints'])->name('reward.credit_panallist_points'); 		
        Route::post('reward/credit_joining_points/post', [PointSystemController::class, 'postCreditJoiningPoints'])->name('reward.post_credit_panallist_points'); 		

        Route::get('reward/country-info',[CountryInfoController::class,'index'])->name('reward.country_info.list');
        Route::get('reward/country-info/create',[CountryInfoController::class,'createCountryInfo'])->name('reward.country_info.create');
        Route::post('reward/country-info/postCreate',[CountryInfoController::class,'postCreate'])->name('reward.country_info.postCreate');
        Route::get('reward/country-info/edit/{id}',[CountryInfoController::class,'editCountryInfo'])->name('reward.country_info.edit');
        Route::post('reward/country-info/delete/{id}', [CountryInfoController::class, 'deleteCountryInfo'])->name('reward.country_info.delete');
        Route::get('reward/country-info/country-temp-preview/{country_id}/{temp_id}',[CountryInfoController::class,'countryTempPreview'])->name('reward.country_info.preview');
        Route::post('reward/country-info/send-participants-mail', [CountryInfoController::class, 'send_participants_mail'])->name('reward.country_info.send_participants_mail');

        Route::get('reward/banner', [CountryInfoController::class, 'rewardBanner'])->name('reward.banner');
        Route::post('reward/banner', [CountryInfoController::class, 'rewardBannerPost'])->name('reward.banner.post');

        Route::get('reward/country-blog-post/{id}', [CountryInfoController::class, 'createBlog'])->name('reward.blod.create');
        
        Route::get('reward/reward-history', [RewardController::class, 'rewardHistory'])->name('reward.history');
        Route::get('reward/reward-history/delete/{id}', [RewardController::class, 'deleteRewardHistory'])->name('reward.history.delete');
        Route::get('reward/reward-history/edit/{id}', [RewardController::class, 'editRewardHistory'])->name('reward.history.edit');
        Route::post('reward/reward-history/postEdit/{id}', [RewardController::class, 'postEditRewardHistory'])->name('reward.history.edit.post');
        Route::post('reward/reward-history/post_city_state/{id}', [RewardController::class, 'postCityStateRewardHistory'])->name('reward.history.city_state.post');


        Route::get('reward/point-system',[PointSystemController::class,'index'])->name('reward.point_system.list');
        Route::post('reward/point-system/add',[PointSystemController::class,'add'])->name('reward.point_system.add');
        Route::get('reward/point-system/delete/{id}', [PointSystemController::class, 'delete'])->name('reward.point_system.delete');
        // Route::post('reward/getCountryAwardPoints', [PointSystemController::class, 'getCountryAwardPoints'])->name('reward.getCountryAwardPoints');
        Route::get('reward/point-system/credit/{id}', [PointSystemController::class, 'creditPanellistPoints'])->name('reward.point_system.credit');

        // Route::get('reward/country-info/create',[CountryInfoController::class,'createCountryInfo'])->name('reward.country_info.create');
        // Route::post('reward/country-info/postCreate',[CountryInfoController::class,'postCreate'])->name('reward.country_info.postCreate');
        // Route::get('reward/country-info/edit/{id}',[CountryInfoController::class,'editCountryInfo'])->name('reward.country_info.edit');

        // Route::get('reward/nominations',[RewardController::class,'listNominations'])->name('reward.nominations.list');

        Route::get('reward/template',[AwardsMailTemplateController::class,'index'])->name('reward.template.list');
        Route::get('reward/template/add',[AwardsMailTemplateController::class,'add'])->name('reward.template.add');
        Route::post('reward/template/post-add',[AwardsMailTemplateController::class,'postAdd'])->name('reward.template.add.post');
        Route::get('reward/template/edit/{id}',[AwardsMailTemplateController::class,'edit'])->name('reward.template.edit');
        Route::post('reward/template/edit/{id}/post',[AwardsMailTemplateController::class,'postEdit'])->name('reward.template.edit.post');
        Route::get('reward/template/delete/{id}',[AwardsMailTemplateController::class,'delete'])->name('reward.template.delete');
        Route::post('reward/template/test-mode',[AwardsMailTemplateController::class,'testMode'])->name('reward.template.test_mode.post');

        Route::get('reward/template-history',[AwardsMailTemplateController::class,'templateHistoryList'])->name('reward.template_history.list');
        Route::get('reward/template-history/dtable',[AwardsMailTemplateController::class,'tempHistoryDTable'])->name('reward.template_history.dtable');
        Route::get('reward/template-history-preview/{id}',[AwardsMailTemplateController::class,'historyPreviewHtml'])->name('reward.template_history.preview');
        // Route::get('reward/send-awards-mail',[AwardsMailTemplateController::class,'manualRewardEmailForm'])->name('reward.send-mail.view');
        // Route::post('reward/send-awards-mail-post',[AwardsMailTemplateController::class,'postManualRewardEmailForm'])->name('reward.send-mail.post');
    });

    Route::group(['prefix' => 'awards-list'], function () {
        Route::get('/', [RewardController::class, 'awardsList'])->name('awards.list');
        Route::get('create', [RewardController::class, 'createAward'])->name('awards.list.create');
        Route::post('post', [RewardController::class, 'postCreateAward'])->name('awards.create.post');
        Route::get('edit/{award_id}', [RewardController::class, 'editAward'])->name('awards.list.edit');
        Route::post('edit/post/{award_id}', [RewardController::class, 'postEditAward'])->name('awards.edit.post');
        Route::post('delete/{award_id}', [RewardController::class, 'deleteAward'])->name('awards.list.delete');
    });


    Route::group(['namespace' => 'Support'], function () {
        Route::get('support/history/{role?}', [SupportController::class, 'supportHistory'])->name('support.history'); // this code add by pushpendra
        //Route::get('support/history', [SupportController::class, 'supportHistory'])->name('support.history'); this code comment by pushpendra
        Route::get('support/chat/{id}', [SupportController::class, 'supportChat'])->name('support.chatshow');
        Route::post('support/chat/{id}', [SupportController::class, 'supportChat'])->name('support.chatpost');
        Route::post('support/changeStatus', [SupportController::class, 'changeSupportStatus'])->name('support.changeStatus');
        Route::get('support/birthdaysent', [SupportController::class, 'panelistBirthdayMail'])->name('support.birthdaysent');
       Route::post('support/birthdaymailsent', [SupportController::class, 'panelistBirthdayMailsent'])->name('support.birthdaymailsent');
       Route::post('support/templateGallary', [SupportController::class, 'templateGallary'])->name('support.templateGallary');

       Route::post('support/templateGallarySingle', [SupportController::class, 'templateGallarySingle'])->name('support.templateGallarySingle');
       Route::post('support/updateTemplateGallery', [SupportController::class,'updateTemplateGallery'])->name('support.updateTemplateGallery');
     
       Route::post('support/campaign-mail', [SupportController::class, 'campaignMail'])->name('support.campaign-mail');
       Route::post('support/survey-mail', [SupportController::class, 'surveyMail'])->name('support.survey-mail');

       
    });

   //Added by RAS 17-01-2024 for SJPL198
    Route::get('invite',[InviteCampaignController::class, 'index']);
    Route::post('invite-validation/upload', [InviteCampaignController::class, 'uploadRequest'])->name('invite.upload');
    Route::post('invite/export-faulty', [InviteCampaignController::class, 'exportData'])->name('invite.export-faulty');
    Route::post('invite/export-validated', [InviteCampaignController::class, 'exportData'])->name('invite.export-validated');
    Route::post('invite/bulk-mail', [InviteCampaignController::class, 'sendBulkMail'])->name('invite.send-bulk-mails');
    Route::post('invite/export-bulk-success', [InviteCampaignController::class, 'exportData'])->name('invite.export-bulk-success');
    Route::post('invite/export-bulk-fail', [InviteCampaignController::class, 'exportData'])->name('invite.export-bulk-fail');
    Route::get('invite/downloadsampleCSV', [InviteCampaignController::class, 'downloadsampleCSV'])->name('invite.downloadsampleCSV');


    /* Routes for question & Answer : Priyanka( 02-july-2024 ) */
        Route::group(['namespace' => 'Question'], function () {
            Route::get('question', [QuestionAnswerController::class, 'index'])->name('question');
            Route::get('question/create', [QuestionAnswerController::class, 'create'])->name('question.create');
            Route::post('question/store', [QuestionAnswerController::class, 'store'])->name('question.store');
            Route::get('question/show/{id}', [QuestionAnswerController::class, 'show'])->name('question.show');
            Route::get('question/{id}/edit', [QuestionAnswerController::class, 'edit'])->name('question.edit');
            Route::put('question/update/{id}', [QuestionAnswerController::class, 'update'])->name('question.update');
            Route::delete('question/destroy/{id}', [QuestionAnswerController::class, 'destroy'])->name('question.destroy');
        });        
    /* Routes for question & Answer : Priyanka( 02-july-2024 ) */

	/* parshant sharma [24-06-2024] SJPL-279*/	 	
    Route::get('send-invitation', [InviteCampaignController::class, 'sendInvitation'])->name('invite.sendInvitation');
    Route::get('invitation', [InviteCampaignController::class, 'invitation'])->name('invite.invitation');
	Route::post('invite-validation/fresh', [InviteCampaignController::class, 'inviteFreshUpload'])->name('invite.fresh');
	Route::get('fresh-invites/{id}', [InviteCampaignController::class, 'allFreshInvites'])->name('invite.viewFresh');	
	Route::post('invite-validation/reminder', [InviteCampaignController::class, 'inviteReminder'])->name('invite.reminder');
	Route::get('view-reminder/{batch}', [InviteCampaignController::class, 'viewReminder'])->name('invite.viewReminder');
	
});

