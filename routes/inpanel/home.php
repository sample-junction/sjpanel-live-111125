<?php

/*
 * These Internal Routes require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */

use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\UserUnsubscribe\UnsubscribeController;
use App\Http\Controllers\Inpanel\Profiler\ProfilerController;
use App\Http\Controllers\Inpanel\Invite\InviteController;
use App\Http\Controllers\Inpanel\BasicDetailController;
use App\Http\Controllers\Inpanel\Project\ProjectController;
use App\Http\Controllers\Inpanel\Survey\SurveyController;
use App\Http\Controllers\Inpanel\User\ProfileController;
use App\Http\Controllers\Inpanel\SearchController;


/************************Route For Apace API***********************************************************/

Route::get('apace-api/ccr', [ProjectController::class, 'getCCR'])->name('project.ccr');

/*************************These Routes DO Not NEED LOGIN*****************************/
Route::get('invite/my-refer/{m}/{ref}/{code}', [InviteController::class, 'showMyRefer'])->name('myrefer.show');
// Route::get('invite/my-refer/{code}', [InviteController::class, 'showMyRefer'])->name('myrefer.show');
/*************************These Routes DO Not NEED LOGIN*****************************/

Route::get('consent-revoke/{type}', [\App\Http\Controllers\Inpanel\User\ProfileController::class, 'consentRevoke'])->name('consent.revoke');


Route::get('user/unsubscribe', [UnsubscribeController::class, 'unsubscribeMail'])
    ->name('mail.unsubscribe');
    //->middleware('signed');
Route::post('user/unsubscribe/post/{email}',[UnsubscribeController::class, 'unsubscribeEmailPost'])->name('unsubscribe.post');

 Route::group(['middleware' => ['prevent-back-history']], function () {
Route::get('basic-detail', [BasicDetailController::class, 'index'])->name('basic.show');
Route::post('basic-detail-update', [BasicDetailController::class, 'update'])->name('basic.partial.update');
/**Added by RAS for SJPL97  */
Route::get('basic-detail-pro', [ProfilerController::class, 'basicProSurveys'])->name('basic.pro');
Route::post('basic-detail-pro', [ProfilerController::class, 'basicSurveyUpdate'])->name('basic.pro.update');
});
/**Added by PARSHANT SHARMA on 24/04/2024 */
            Route::group([
                'namespace' => 'Profiler',
                'as' => 'profiler.',
                'middleware' => ['auth','checkActive','permission:read profiler|update profiler']
            ], function () { //print('A');die();
                Route::get('detailed-profile', [ProfilerController::class, 'index'])->name('show');
                /**Added by RAS on 07/12/2023 for new integration */
                Route::post('detailed-profile/update-profile/{id}', [ProfilerController::class, 'saveDetailProfile_new'])->name('profile.save_fetch.show');
                Route::post('detailed-profile/update/{id}', [ProfilerController::class, 'updateDetailProfile'])->name('profile.update');
            /**End code */
            });

Route::get('get-basicEmail', [BasicDetailController::class, 'checkEmail'])->name('basic.email');
Route::get('get-emailExist', [BasicDetailController::class, 'emailExist'])->name('emailExist');
Route::post('basic-detail', [BasicDetailController::class, 'update'])->name('basic.update');
Route::get('basic-detail/dfiqDatas', [BasicDetailController::class, 'postDfiqData'])->name('basic.dfiqData.post');
Route::get('basic-detail/countryupdate', [BasicDetailController::class, 'countryUpdate'])->name('basic.countryupdate.post');
Route::get('language',[BasicDetailController::class, 'getCountryLanguage'])->name('language');
Route::get('dashboard/zipfailedattempts', 'DashboardController@zipfailedattempts')->name('dashboard.zipfailedattempts.post');
Route::group(['middleware' => ['auth', 'password_expires','checkActive']], function () {
    
    Route::group(['middleware' => ['has_basic_detail']], function () {

        Route::get('dashboard', 'DashboardController@index')->name('dashboard')->middleware('2fa_confirm');
        Route::post('get-filtered-survey', 'DashboardController@getFilteredSurvey')->name('get.filtered.survey');
        Route::get('dfiqData', 'DashboardController@postDfiqData')->name('dashboard.dfiqData.post');
        Route::post('insertRewardPole', 'DashboardController@insertRewardPole')->name('dashboard.insertRewardPole');
        
        /*Added for survey drop down options on hot surveys
        *   Dashboard and Survey pages
        * Added by RAS 12.09.23
        */
        // Route::post('get-filtered-survey', 'DashboardController@getFilteredSurvey')->name('get.filtered.survey');
        //End code
        Route::post('search', [SearchController::class, 'search'])->name('search');
        
        Route::get('update-tour/{tour_section}', 'DashboardController@changeTourSelection')->name('change.tour.selection');
        Route::group(['namespace' => 'User', 'as' => 'user.'], function () {


            Route::get('profile', 'ProfileController@index')->name('profile.show')->middleware('2fa_confirm');
            Route::post('profile', 'ProfileController@update')->name('profile.update')->middleware('2fa_confirm');
            
            Route::get('profile/preference/{name}', 'ProfileController@showPreference')->name('profile.preference.show');

            Route::post('profile/preference/{name}', 'ProfileController@updatePreference')->name('profile.preference.update');
            //Route::get('profile/unsubscribe/unsubscribe-completely', 'ProfileController@executeUnsubscribeComplete')->name('profile.preference.completeUnsubscribe')->middleware('2fa_confirm');
            Route::post('profile/unsubscribe/unsubscribe-completely', 'ProfileController@executeUnsubscribeComplete')->name('profile.preference.completeUnsubscribe')->middleware('2fa_confirm');
            Route::get('profile/preference/{provider}', 'ProfileController@socialLogin')->name('profile.preference.social')->middleware('2fa_confirm');
            Route::get('profile/preference/{provider}/callback', 'ProfileController@socialLogin')->name('profile.preference.social')->middleware('2fa_confirm');
            Route::get('profile/two-fact-auth', [ProfileController::class, 'twoFactSetting'])->name('profile.two_fact_auth.setting')->middleware('2fa_confirm');
            Route::get('profile/two-fact-auth/disable', [ProfileController::class, 'disableTwoFactSetting'])->name('profile.two_fact_auth.disable');
            Route::get('profile/two-fact-auth/sendOtp', [ProfileController::class, 'sendOtp'])->name('profile.two_fact_auth.sendOtp');
            Route::post('profile/two-fact-auth/verify-otp', [ProfileController::class, 'verifyOTPGenerated'])->name('profile.two_fact_auth.verify-otp')->middleware('opt_verify');

            Route::get('support', [ProfileController::class, 'panellistSupport'])->name('support');
            Route::post('post/support', [ProfileController::class, 'panellistSupport'])->name('post.support');
            Route::get('support_history', [ProfileController::class, 'supportHistory'])->name('support_history');
            Route::get('support/ticket/{id}', [ProfileController::class, 'supportChat'])->name('support.chatshow');
            Route::post('support/chat/{id}', [ProfileController::class, 'supportChat'])->name('support.chatpost');
            Route::post('support/changeStatus', [ProfileController::class, 'changeSupportStatus'])->name('support.changeStatus');
            Route::post('deactivateUser', [ProfileController::class, 'deactivateUser'])->name('profile.deactivateUser');

        });
        Route::group([

            'namespace' => 'Redeem',
            'as' => 'redeem.',
            'middleware' => ['permission:read redeem points']
        ], function () {
            Route::get('redeem', 'RedeemController@index')->name('show');
            Route::post('redeem', 'RedeemController@sendRedeemRequest')->name('post.redeem.request');
            Route::get('redeem/history', 'RedeemController@getRedeemHistory')->name('redeem.history');
            Route::get('redeem/dataTableRedeemHistory', 'RedeemController@dataTableRedeemHistory')->name('redeem.dataTableRedeemHistory');
            Route::get('redeem/gift-card', 'RedeemController@getGiftCard')->name('gift.card');
            Route::get('redeem/index', 'RedeemController@indexRedirect')->name('index.show');
        });

        Route::group([
            'namespace' => 'Reward',
            'as' => 'reward.',
            'middleware' => ['permission:read reward points']
        ], function () {
            Route::get('my-points', 'RewardController@index')->name('show');
            Route::get('tour-taken', 'RewardController@tourTakenUpdate')->name('change.tour.selection');
        });


        Route::group([
            'namespace' => 'Invite',
            'as' => 'invite.',
            'middleware' => ['permission:read invites']
        ], function () {
            Route::get('invite', 'InviteController@index')->name('show');
            Route::post('invite', 'InviteController@executeEmailInvite')->name('email.execute');
            Route::get('invite/my-referrals', 'InviteController@showMyReferrals')->name('myreferrals.show');
            Route::get('tour-taken/{section}', 'InviteController@tourTakenUpdate')->name('change.tour.selection');
        });

        Route::group([
            'namespace' => 'Survey',
            'as' => 'survey.',
            'middleware' => ['permission:read surveys']
        ], function () {
            //Add code by vikash
            Route::group(['middleware' => ['has_blacklist']], function () {

                Route::get('survey', [SurveyController::class, 'index'])->name('index');
                Route::post('survey', [SurveyController::class, 'index'])->name('index');
                Route::get('survey/history', [SurveyController::class, 'history'])->name('history');
                Route::get('survey/start/{survey_id}', [SurveyController::class, 'startSurvey'])->name('execute.show');
                Route::get('survey/return/', [SurveyController::class, 'endSurvey'])->name('end.survey');
            });
        });
		
    });
});

Route::fallback(function(){
	return response()->json([
	'message' => 'Page not found'],404);
});