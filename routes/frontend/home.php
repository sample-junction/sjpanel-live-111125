<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\EndPageController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\ProfileController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Backend\Auth\Campaign\campaignmailController;
use App\Http\Controllers\Frontend\RewardsController;


/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('mailgun', [HomeController::class, 'multimail'])->name('multimail');
Route::get('blog',[BlogController::class, 'getPosts'])->name('blog');
Route::get('blog/{slug}',[BlogController::class, 'findPostBySlug'])->name('blog.post' );
//start New added by ramesh ji - 11november22

Route::get('survey-end', [EndPageController::class, 'surveyend'])->name('survey.end');
Route::get('survey-action', [EndPageController::class, 'transactioncompletion'])->name('survey.transactioncompletion');

//end New added by ramesh ji - 11november22

Route::get('encrypt-data', [HomeController::class, 'encryptData'])->name('encrypt.data');
Route::get('testsendemail', [HomeController::class, 'testingsendemail'])->name('testsendemail');
Route::get('approve-template', [campaignMailController::class, 'approveTemplate'])->name('approve-template');

//Route::get('rewards',[RewardsController::class, 'rewards'])->name('rewards');
//Route::get('rewards/US',[RewardsController::class, 'rewardsUS'])->name('rewardsUS');
//Route::get('rewards/UK',[RewardsController::class, 'rewardsUK'])->name('rewardsUK');
//Route::get('rewards/CA',[RewardsController::class, 'rewardsCA'])->name('rewardsCA');
//Route::get('rewards/IN',[RewardsController::class, 'rewardsIN'])->name('rewardsIN');
Route::get('rewards/{country}',[RewardsController::class, 'rewardsByCountry'])->name('rewards.byCountry');
Route::get('/upload/{slug}', [RewardsController::class, 'showUploadForm'])->name('video.upload.form');
Route::post('/upload', [RewardsController::class, 'upload'])->name('video.upload');
/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        /*
         * User Dashboard Specific
         */
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        /*
         * User Account Specific
         */
        Route::get('account', [AccountController::class, 'index'])->name('account');

        /*
         * User Profile Specific
         */
        Route::patch('profile/update', [DashboardController::class, 'update'])->name('profile.update');
    });
});
Route::get('web-stories',[HomeController::class, 'frontendPage']);
Route::get('web-stories/{storyTitle}',[HomeController::class, 'showStory'])->name('story.show');
