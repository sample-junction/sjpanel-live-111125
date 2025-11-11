<?php

use \App\Http\Controllers\Frontend\CMS\PageController;
use App\Http\Controllers\Backend\Auth\Campaign\campaignmailController;


Route::group(['namespace' => 'CMS', 'as' => 'cms.'], function () {
    Route::prefix('pages')->group(function () {
        Route::get('faq', 'PageController@showFaq')->name('faq');
        Route::get('privacy', 'PageController@showPrivacyPolicy')->name('privacy');
        Route::get('ccpa-privacy', 'PageController@showCCPAPrivacyPolicy')->name('ccpa-privacy');
        Route::get('cookies', 'PageController@showCookiePolicy')->name('cookie');
        Route::get('rewards', 'PageController@showExternalRewards')->name('rewards');
        Route::get('terms&condition', 'PageController@showTermsAndCondition')->name('term_condition');
        Route::get('contact', 'PageController@showHelpSupport')->name('help_support');
        Route::get('rewards-policy', 'PageController@showRewardsPolicy')->name('rewards_policy');
	    Route::get('safeguard', 'PageController@showSafeGuard')->name('safeguard');
        Route::get('referral-policy', 'PageController@showReferralPolicy')->name('referral_policy');

        Route::get('approve-template', [campaignMailController::class, 'approveTemplate'])->name('approve-template');



        //This Route is added to test Functions
        Route::get('test123', [PageController::class, 'showTestPage'])->name('testPage');

    });
});
