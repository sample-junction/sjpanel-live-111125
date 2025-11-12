<?php

use App\Http\Controllers\Frontend\Auth\LoginController;
use App\Http\Controllers\Frontend\Auth\RegisterController;
use App\Http\Controllers\Frontend\Auth\SocialLoginController;
use App\Http\Controllers\Frontend\Auth\ResetPasswordController;
use App\Http\Controllers\Frontend\Auth\ConfirmAccountController;
use App\Http\Controllers\Frontend\Auth\ForgotPasswordController;
use App\Http\Controllers\Frontend\Auth\UpdatePasswordController;
use App\Http\Controllers\Frontend\Auth\PasswordExpiredController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Backend\Auth\Campaign\campaignmailController;
use Illuminate\Http\Request;
/*
 * Frontend Access Controllers
 * All route names are prefixed with 'frontend.auth'.
 */
Route::group(['namespace' => 'Auth', 'as' => 'auth.'], function () {

    Route::post('contact-us/send-email', [ContactController::class, 'sendContactUsEmail'])->name('send.email');
    Route::get('resend_confirmation_email', [RegisterController::class, 'resendConfirmationMail'])->name('resend_confirmation_email');

    /*
    * These routes require the user to be logged in
    */
    Route::group(['middleware' => 'auth'], function () {
        Route::get('logout', [LoginController::class, 'logout'])->name('logout');

        //For when admin is logged in as user from backend
        Route::get('logout-as', [LoginController::class, 'logoutAs'])->name('logout-as');
        Route::get('2FA-register/{user}', [RegisterController::class, 'complete2FARegister'])->name('2fa.register');

        // These routes can not be hit if the password is expired
        Route::group(['middleware' => 'password_expires'], function () {
            // Change Password Routes
            Route::patch('password/update', [UpdatePasswordController::class, 'update'])->name('password.update');
        });

        // Password expired routes
        Route::get('password/expired', [PasswordExpiredController::class, 'expired'])->name('password.expired');
        Route::patch('password/expired', [PasswordExpiredController::class, 'update'])->name('password.expired.update');
    });

        Route::get('2fa',[LoginController::class, 'otpConfirmationForm'])->name('2fa.otp.confirmation');
        Route::get('mode',[LoginController::class, 'getMode'])->name('2fa.otp.mode');
        Route::get('otp-resend',[LoginController::class, 'resendOtp'])->name('2fa.otp.resend');
        Route::post('2fa', [LoginController::class, 'postOtpConfirmation'])->name('2fa')->middleware('2fa');
        Route::post('2fa-email', [LoginController::class, 'postEmailOtpConfirmation'])->name('2fa.email.auth');
        
        // Confirm Delete Account Routes
        Route::get('account/confirm/delete/{token}', [ConfirmAccountController::class, 'confirmdelete'])->name('account.confirm.delete');

        // Personal info Confirm Delete Account Routes
        Route::get('account/confirm/personalinfo/delete/{token}', [ConfirmAccountController::class, 'userinfoconfirmdelete'])->name('account.confirm.personalinfo.delete');

        Route::post('account/deactivate', [ConfirmAccountController::class, 'userDeactivate'])->name('account.deactivate');
        Route::post('account/userDeactivateReason', [ConfirmAccountController::class, 'userDeactivateReason'])->name('account.userDeactivateReason');
        Route::get('unsub', function (\Illuminate\Http\Request $request) {
            return view('frontend.auth.unsubscribed', ['flags' => 'en-US','countryCode'=>"US"]);
        })->name('unsub');
    /*
     * These routes require no user to be logged in
     */
    Route::group(['middleware' => 'guest'], function () {

        // Authentication Routes
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [LoginController::class, 'login'])->name('login.post');
        Route::get('auth/facebook', [RegisterController::class, 'redirectToFacebook']);
        Route::get('auth/facebook/callback', [RegisterController::class, 'handleFacebookCallback']);
		
        // Socialite Routes
        Route::get('login/{provider}', [SocialLoginController::class, 'login'])->name('social.login');
        Route::get('login/{provider}/callback', [SocialLoginController::class, 'login']);
        // Registration Routes
        //Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        // Route::post('register', [RegisterController::class, 'register'])->name('register.post');
         //Route Created By Ramesh for Affiliate Registration//
         Route::get('affiliate_register' , [RegisterController::class, 'affiliate_register'])->name('affiliate.register');
         //End Here
         Route::get('register' , [RegisterController::class, 'index'])->name('register');
         Route::post('register' , [RegisterController::class , 'submit'])->name('register.post');
         Route::post('personal-details' , [RegisterController::class , 'proceed'])->name('personal-details.post');
         Route::get('thank-you' , [RegisterController::class , 'thanks'])->name('thank-you');
         Route::get('get-language',[RegisterController::class, 'getCountryLanguage'])->name('language');
         Route::get('get-userEmail',[RegisterController::class, 'getUsersEmail'])->name('validateEmail');
         
         Route::get('promo/consent', [RegisterController::class, 'showPromoConsentPage'])->name('promo.consent.show');
         Route::get('promo/landing', [RegisterController::class, 'showPromoRegistrationForm'])->name('promo.register');
         Route::post('promo/landing', [RegisterController::class, 'postPromoRegister'])->name('promo.register.post');

        // Confirm Account Routes
        Route::get('account/confirm/{token}', [ConfirmAccountController::class, 'confirm'])->name('account.confirm');
        Route::get('account/confirm/resend/{uuid}', [ConfirmAccountController::class, 'sendConfirmationEmail'])->name('account.confirm.resend');
        Route::get('account/welcome/{id}', [ConfirmAccountController::class, 'welcome_dashboard'])->name('account.welcome');
        
        
        // Password Reset Routes
        Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.email');
        Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email.post');
        
        Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
        Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.reset');
        
        
        /*************************Temp route has to be deleted************************************************************/
        
        Route::get('confirm_email', [RegisterController::class, 'showConfirmEmail'])->name('email.confirm');
        Route::get('dfiqDatas', [RegisterController::class, 'postDfiqData'])->name('register.dfiqData.post');
        Route::get('landingpage',[ContactController::class, 'landingPage'])->name('landingpage');
    });
    Route::get('send-email', [campaignmailController::class, 'sendTestEmail'])->name('send-email');

    // Route::get('approve-template', [campaignMailController::class, 'approveTemplate'])->name('approve-template');
    
    Route::get('moblieConfirmationView', [LoginController::class, 'moblieConfirmationView'])->name('moblieConfirmationView');

    Route::get('popup', function () {
        return view('frontend.auth.popup');
    })->name('popup');    // Route::get('approve-template', [campaignMailController::class, 'approveTemplate'])->name('approve-template');

    Route::get('resend_confirmation_email', [RegisterController::class, 'resendConfirmationMail'])->name('resend_confirmation_email');
    Route::get('download/app',[ContactController::class, 'landingPage'])->name('landingpage');
    Route::post('landingcontact', [ContactController::class, 'landingcontact'])->name('landingcontact');
    Route::get('/check-domain', function (Request $request) {
        $domain = $request->get('domain');
        if (!$domain) {
            return response()->json(['exists' => false]);
        }
        if (checkdnsrr($domain, 'MX')) {
            return response()->json(['exists' => true]);
        }
        if (checkdnsrr($domain, 'A')) {
            return response()->json(['exists' => true]);
        }
        return response()->json(['exists' => false]);
    });
    Route::get('app-email-template', [RegisterController::class, 'appEmailTemplate'])->name('appEmailTemplate');
    Route::get('sendToPlatform/{platform}', [RegisterController::class, 'sendToPlatform'])->name('sendToPlatform');

    Route::get('app-email-template', [RegisterController::class, 'appEmailTemplate'])->name('appEmailTemplate');
    Route::get('sendToPlatform/{platform}', [RegisterController::class, 'sendToPlatform'])->name('sendToPlatform');
 
});

