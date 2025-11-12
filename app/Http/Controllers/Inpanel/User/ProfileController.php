<?php

namespace App\Http\Controllers\Inpanel\User;

use App\Events\Inpanel\Auth\UserLoggedIn;
use App\Mail\Inpanel\UserProject\SurveyTestInvite;
use App\Events\Inpanel\Auth\UserProfilePicPoint;
use App\Events\Inpanel\Auth\UserTour;
use App\Models\Project\UserProject;
use App\Exceptions\GeneralException;
use App\Http\Requests\Inpanel\User\Profile\UpdatePreferenceRequest;
use App\Models\Auth\User;
use App\Models\Profiler\UserAdditionalData;
use App\Repositories\Frontend\Auth\UserNotificationRepository;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Models\Auth\UserEmailOtp;
use Carbon\Carbon;
use App\Models\Project\Project;
use DateTime;
use Auth;
use Exception;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Helpers\Inpanel\Auth\Socialite as SocialiteHelper;
use Illuminate\Support\Facades\Mail;
use App\Mail\Inpanel\Support\PanelistSupport;
use App\Mail\Backend\Support\PanelSupport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Support\PanellistSupport;
use App\Models\Setting\Setting;
use App\Models\Support\SupportChat;
use App\Http\Controllers\Inpanel\User\ContactRequest;
use App\Http\Requests\Inpanel\Invite\EmailInviteRequest;
use App\Mail\Inpanel\User\TwoDisableMail;
use Illuminate\Support\Facades\Crypt;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
use App\Models\Auth\UserUnsubscribe;
use App\Models\UserPlatformAction;
use App\Models\StoredImage;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
/**
 * This class is used for handling Update Preferences.
 *
 * Class ProfileController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Inpanel\User\ProfileController
 */

class ProfileController extends Controller
{

    /**
     * @param $userRepository
     * @param UserRepository
     */
    protected $userRepository, $profileSectionRepo, $notificationRepo, $countriesCurrenciesRepository;
    public $socialiteHelper;

    /**
     * ProfileController constructor.
     *
     * @param UserRepository $userRepository
     * @param SocialiteHelper $socialiteHelper
     */
    public function __construct(UserRepository $userRepository, SocialiteHelper $socialiteHelper, ProfileSectionRepository $profileSectionRepo, UserNotificationRepository $notificationRepo, CountriesCurrenciesRepository $countriesCurrenciesRepository)
    {
        $this->userRepository = $userRepository;
        $this->socialiteHelper = $socialiteHelper;
        $this->profileSectionRepo = $profileSectionRepo;
        $this->notificationRepo = $notificationRepo;
        $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
    }

    /*Has to Remove this action after checking the use of this action.*/

    public function index()
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;

        return view('inpanel.user.profile.index')
            ->with('currentCountry', $currentCountry)
            ->with('user', auth()->user());
    }

    /**
     * This action is used show the Preference Details that has to be updated by
     * redirecting to the view of Profile Preferences Page.
     *
     * @param $name
     * @return resource profile/preferences.blade.php
     */

    public function showPreference($name)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $user = auth()->user();
        $get_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $user_points = $get_user_add_data;
        $userPoints = $get_user_add_data->user_points['completed'];
        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);
        $user_active_surveys = $this->userRepository->getUserActiveSurveys($user);

        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        // $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $user_activity1 = Activity::causedBy($user)->where('description', 'inpanel.activity_log.log_in')->take(1)->orderBy('created_at', 'desc')->get();
        // echo "<pre>";
        // print_r($user_activity1);exit();
        $fetch_user_achievement = $get_user_add_data->user_filled_profiles;
        if (!empty($fetch_user_achievement)) {
            $count_User = count(@$fetch_user_achievement);
        } else {
            $count_User = 0;
        }
        $detailed_profile_survey = $this->profileSectionRepo->getDetailedProfileSurvey();
        $fetch_user_achievement1 = $get_user_add_data->user_achievement;
        $active_user_count = count($fetch_user_achievement1);

        $notifications = $this->notificationRepo->getNotification($user->uuid);
        /* Parshant Sharma [21-08-2024] Starts */

        $locale = app()->getLocale();

        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

            $cntry = explode('_', $countryPoint->country_language);
            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang' => $cntry[1],
            );
        }

        $geodata = geoip(request()->ip());

        $ipcountryCode = $geodata->getAttribute('iso_code');
        if ($ipcountryCode == 'GB') {
            $ipcountryCode = 'UK';
        }

        /* Parshant Sharma [21-08-2024] Ends */

        // return view('inpanel.user.profile.preference')
        return view('inpanel.user.profile.preference')
            ->with('user', $user)
            ->with('user_add_data', $get_user_add_data)
            ->with('userPoints', $user_points)
            ->with('allUserSurveys', $user_assign_projects)
            ->with('completedSurveys', $user_completed_surveys)
            ->with('userActiveSurveys', $user_active_surveys)
            ->with('attemptedSurvey', $user_attempted_surveys)
            ->with('userExpireSurveys', $user_expire_surveys)
            ->with('user_notifications', $notifications)
            ->with('detailed_profile_survey', $detailed_profile_survey)
            ->with('user_point', $userPoints)
            ->with('active_user_count', $active_user_count)
            ->with('user_count', $count_User)
            ->with('countryPoints', $countryPoints)
            ->with('currencies', $currencies)
            ->with('currentCountry', $currentCountry)
            ->with("country_code", $ipcountryCode);
    }

    /**
     * This action used to create Function with different updated Preference Name.
     *
     * @param UpdatePreferenceRequest $request
     * @return mixed
     */
    public function updatePreference(UpdatePreferenceRequest $request)
    {
        $functionName = Str::camel('execute ' . $request->input('section'));
        // echo '<pre>';
         //print_r($functionName);die();
        if (!method_exists($this, $functionName)) {
            abort(403, 'Unauthorized action.');
        }
        //print_r($functionName);exit;
        return $this->$functionName($request);
    }

    /**
     * This action use to update Basic Profile data that contain first_name, last_name, gender,
     * DOB and also add Profile Photo. As soon user will do the update it will also be updated
     * in user additional data and also for the first time uploading the profile photo user will
     * get achievements points.
     *
     * @param $request
     * @return mixed
     */
    public function executeBasicProfile($request)
    {
        $user = auth()->user();
        $image_name = null;

        if ($request->hasFile('images')) {
            $url = rtrim(config('settings.centralize_server_image'), '/') . "/api/v1/images";

            $uploadedFile = $request->file('images');
            $imagePath = $uploadedFile->getPathname();
            $mimeType = $uploadedFile->getMimeType();
            $originalName = $uploadedFile->getClientOriginalName();

            $postFields = [
                'image'        => new \CURLFile($imagePath, $mimeType, $originalName),
                'image_type'   => 'pictures',
                'id'           => $user->id,
                'key'          => 'profile_picture',
                'source'       => 'web',
                'reference_id' => $user->id,
            ];

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => $postFields,
                CURLOPT_HTTPHEADER => [
                    'Accept: application/json;version=2.0',
                ]
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                $error = curl_error($curl);
                curl_close($curl);
                \Log::error("Profile image upload failed: " . $error);
                return redirect()->back()->withErrors(['error' => 'Image upload failed.']);
            }

            curl_close($curl);

            $responseArray = json_decode($response, true);

            if (!empty($responseArray['success']) && $responseArray['success'] === true) {

                $reference_id = $user->id;
                $mainPath = $responseArray['image_data'];
                $thumbnailPathForDb = $responseArray['image_data'];

                StoredImage::updateOrCreate(
                    [
                        'entity_id' => $user->id,
                        'storage_key'   => 'profile_picture',
                        'reference_id' => $reference_id
                    ],
                    [
                        'image_profile' => 'pictures',
                        'source' => 'web',
                        'disk' => 'public_direct',
                        'original_filename' => $uploadedFile->getClientOriginalName(),
                        'main_image_path' => $mainPath,
                        'thumbnail_image_path' => $thumbnailPathForDb,
                        'deleted_at' => null,
                    ]
                );

                $image_name = $thumbnailPath ?? $mainPath;

                $this->userRepository->giveProfilePicUploadPoints($user);
            } else {
                return redirect()->back()->withErrors(['error' => $responseArray['message'] ?? 'Image processing failed.']);
            }
        } else {
            $image_name = $user->thumbnail_image_path;
        }

        $user_id = $request->user()->id;
        //$profileInputs = $request->only('first_name', 'middle_name', 'last_name','gender','dob', 'email', 'avatar_type', 'avatar_location', 'timezone' , 'two_fact_auth','fb','twitter','linkdin');
        $profileInputs = $request->only('first_name', 'last_name', 'fb', 'twitter', 'linkdin');
        $profileInputs['image_url'] = $image_name;

        /* Parshant Sharma [13-09-2024] Starts */

        $userLocale = auth()->user()->locale;
        $userLang = explode('_', $userLocale);

        $updatedLocale = trim(strtolower($request->language)) . '_' . $userLang[1];

        session()->put('locale', $updatedLocale);

        $profileInputs['locale'] = $updatedLocale;

        /* Parshant Sharma [13-09-2024] Ends */


        //$profileInputs['dob'] = DateTime::createFromFormat('m-d-Y', $profileInputs['dob'])->format('Y-m-d');
        //if(!empty($request->get('device_preference'))){
        //    $profileInputs['device_preference'] = implode(',',$request->input('device_preference'));
        //}else{
        //    $profileInputs['device_preference'] = '1,2,3,4';
        //}
        //Code Added By Ramesh Kamboj For Social Profile Link Points//
        $user_uuid = $request->user()->uuid;

        $updated_user_add_data = UserAdditionalData::where('uuid', '=', $user_uuid)->first();
        $fetch_user_achievement = $updated_user_add_data->user_achievement;
        $user_achievement_facebook = [];
        $user_achievement_twitter = [];
        $user_achievement_linkedin = [];
        $points_data_facebook = [];
        $points_data_twitter = [];
        if ($fetch_user_achievement) {
            if (empty(array_column($fetch_user_achievement, "social_filled_facebook_profile"))) {
                if (!empty($request->get('fb'))) {
                    $points_data_facebook["code"] = 'Facebook';
                    $points_data_facebook["points"] = '100';
                    $points_data_facebook["status"] = "completed";
                    $points_data_facebook["updated_at"] = date('Y/m/d H:m:s');
                    $user_achievement_facebook['social_filled_facebook_profile'][] = $points_data_facebook;
                    $updated_user_add_data->push("user_achievement", $user_achievement_facebook);
                    $this->logProfileAchievementActivity($user, $points_data_facebook);
                }
            }
            if (empty(array_column($fetch_user_achievement, "social_filled_twitter_profile"))) {
                if (!empty($request->get('twitter'))) {
                    $points_data_twitter["code"] = 'Twitter';
                    $points_data_twitter["points"] = '100';
                    $points_data_twitter["status"] = "completed";
                    $points_data_twitter["updated_at"] = date('Y/m/d H:m:s');
                    $user_achievement_twitter['social_filled_twitter_profile'][] = $points_data_twitter;
                    $updated_user_add_data->push("user_achievement", $user_achievement_twitter);
                    $this->logProfileAchievementActivity($user, $points_data_twitter);
                }
            }
            if (empty(array_column($fetch_user_achievement, "social_filled_linkdin_profile"))) {
                if (!empty($request->get('linkdin'))) {
                    $points_data_linkedin = [
                        "code"       => 'LinkedIn',
                        "points"     => '100',
                        "status"     => "completed",
                        "updated_at" => date('Y/m/d H:i:s'),
                    ];
                    $user_achievement_linkedin['social_filled_linkdin_profile'][] = $points_data_linkedin;
                    $updated_user_add_data->push("user_achievement", $user_achievement_linkedin);
                    $this->logProfileAchievementActivity($user, $points_data_linkedin);
                }
            }

            //$updated_user_add_data->push("user_achievement", $user_achievement);
            // $this->logProfileAchievementActivity($user,$points_data);
            //return true;
        }

        //End HERE//

        $output = $this->userRepository->update($user_id, $profileInputs);

        /*$user = auth()->user();

        if($user->two_fact_auth==0 && array_key_exists('two_fact_auth',$profileInputs) && $profileInputs['two_fact_auth']==1){
            $google2fa = app('pragmarx.google2fa');
            $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();
            $request->session()->flash('registration_data', $registration_data);
            $QR_Image = $google2fa->getQRCodeInline(
                config('app.name'),
                $user->email,
                $registration_data['google2fa_secret']
            );
            return view('frontend.auth.google2fa.index', ['user' => $user,'QR_Image' => $QR_Image, 'secret' => $registration_data['google2fa_secret']]);
        }*/
        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && !empty($output['email_changed'])) {
            auth()->logout();

            return redirect()->back()->withFlashSuccess(__('strings.frontend.user.email_changed_notice'));
        }
        return redirect()->back()->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }

    /**
     * This action use to update Password without asking the old password.
     *
     * @param $request
     * @return mixed
     * @throws GeneralException if the user new password and confirm password is not matched.
     */
    public function executePassword($request)
    {
        $user = $request->user();
        $inputs = $request->only('password');
        if (Hash::check($inputs['password'], $user->password)) {
            $id = 'security';
            return redirect()->back()->withErrors(__('inpanel.user.profile.preferences.preferences_menu.password_same_error'));
        } else {
            $inputs['password'] = Hash::make(trim($inputs['password']));
            $inputs['old_password'] = $user->password;

            $output = $this->userRepository->updatePasswordWithoutOld($inputs, true);
            // return redirect()->back()->withFlashSuccess();
            Auth::logout();
            return redirect('login')->with('password_updated', __('strings.frontend.user.password_updated_message'));
        }
    }

    /**
     * This action use to get User Details in CSV Format and the details will include basic profile data
     * questions and their answers for all the detailed profile.
     *
     * @param $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function executeMyData($request)
    {
        /*
         * To DO
         * Convert this method into a Background Job
         * After finishing the job Send Data through mail
         * Only if Email is confirmed
         * */

        $date = date("m-d-Y");

        $file_name = 'SJ Panel User Report ' . $date;

        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename={$file_name}.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );


        $userAllData = $this->userRepository->getUseCompleteData();

        // print_r($basicData);echo '<pre>';
        //print_r($userAllData);die;

        $basicData = $userAllData['Basic Profile'];
        $detailedProfileData = $userAllData['Detailed Profile'];
        $basicColumns = array_keys($basicData);

        $detailedProfileColumns = array_keys($detailedProfileData);

        $basicColumns = array_merge($basicColumns, $detailedProfileColumns);

        $basicData = array_merge($basicData, $detailedProfileData);




        $callback = function () use ($basicData, $basicColumns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $basicColumns);

            fputcsv($file, $basicData);

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }


    /**
     * added below funtion by dushyant on 30-6-2022
     * This action Use to Soft Delete the Personal Info of User.
     *
     * @param $request
     * @param $token
     * @return mixed
     */
    public function executeDeletePersoninfo($request)
    {
        // echo '<pre>';
        // print_r($request->input('delete_reason'));die;
        // $user_uuid= $request->user()->uuid;
        // $user = UserAdditionalData::where('uuid','=',$user_uuid)->first();
        // if(isset($user->uuid) ){
        // $user->delete();
        $users = auth()->user();
        $userdata = $users->toArray();

        //  $user = User::where('confirmation_code', $token)->first();
        // print_r($userdata);die;
        $address = config('mail.from.privacy_address');
        $name = config('mail.from.name');
        $delete_reason = $request->input('delete_reason') === 'Others' ? $request->input('additional_reason') : $request->input('delete_reason');
        //Update Delete Reason
        User::where('id', $userdata['id'])->update(['delete_reason' => $delete_reason]);

        Mail::send('frontend.mail.userinfo_confirmation_delete_mail', $userdata, function ($message) use ($userdata, $address, $name) {
            $message->to($userdata['email'], $userdata['first_name'])-> //subject(__('exceptions.frontend.auth.confirmation.userinfodeleteconfirm')->with('logoUrl',$logoUrl));
                subject(__('exceptions.frontend.auth.confirmation.userinfodeleteconfirm'));

            $message->from($address, $name);
        });
        // }
        //    return redirect()->route('inpanel.dashboard')->with([
        //     'flash_success' => __('inpanel.user.profile.preferences.preferences_menu.deactivate_account_success'),
        //     'confirmation_code' => $token,
        // ]);
        return redirect()->route('frontend.index')->withFlashSuccess(__('inpanel.user.profile.preferences.preferences_menu.deactivate_account_success'));

        //$this->userRepository->deleteUser();


    }

    /**
     * This action Use to send confirmation mail to Deactivate the Account of User.
     * dushyant dogra 16 july 2022
     * @param $request
     * @return mixed
     */
    public function executeDeleteAccount($request)
    {

        // echo '<pre>';
        // print_r($request->input('deactive_reason'));die;
        $users = auth()->user();

        $user = $users->toArray();

        //echo '<pre>';
        //print_r($user);die();
        $userdata = $user;
        $address = config('mail.from.donotreply_address');
        $name = config('mail.from.name');
        $deactivate_reason = $request->input('deactive_reason') === 'Others' ? $request->input('additional_reason') : $request->input('deactive_reason');
        //update deactivate reason

        // commented by Himanshu on 19-Aug-2025 
        //because we want to deactivate the account when the user clicks the "Deactivate Account" button from the mail

        // User::where('id',$userdata['id'])->update(['deactivate_reason'=>$deactivate_reason,'active'=>0]);
        // end here 19-aug-2025

        Mail::send('frontend.mail.confirmation_delete_mail', $user, function ($message) use ($user, $userdata, $address, $name) {
            $message->to($userdata['email'], $userdata['first_name'])->subject(__('exceptions.frontend.auth.confirmation.deleteconfirm'));

            $message->from($address, $name);
        });
        return redirect()->route('frontend.index')->withFlashSuccess(__('inpanel.user.profile.preferences.preferences_menu.delete_account_success'));
    }
    /**
     * This action Use to Soft Delete the Account of User.
     *
     * @param $request
     * @return mixed
     */
    /* public function executeDelete($request)
    {
        $user_uuid= $request->user()->uuid;
        $user = UserAdditionalData::where('uuid','=',$user_uuid)->first();
        $user->delete();
        $this->userRepository->deleteUser();

        return redirect()->route('frontend.index')->withFlashSuccess(__('Account Deleted'));
    }*/

    /**
     * Action use to Unsubscribe the mail id.
     *
     * @return mixed
     */
    public function executeUnsubscribeComplete(Request $request)
    {

        $user_email = $request->user()->email;
        $insertdata = [
            'email' => $user_email,
            'reason' => "unsubscribe",
            'otherReason' => ""
        ];

        $moveEmailToUnsubscribe = $this->userRepository->emailUnsubscribe($insertdata);
        $check_user_details = $this->userRepository->getUserDetailsByEmail($user_email);
        if ($check_user_details) {
            $update_user_table = $this->userRepository->updateUserTableData($check_user_details->id);
        }

        return response()->json([
            'status' => true,
            'message' => __('You have been unsubscribed successfully!')
        ]);
        //return redirect()->back()->withFlashSuccess('Successfully Unsubscribed');
    }

    public function executeEmailSchedule($request)
    {
        $user = auth()->user();
        $user_id = $request->user()->id;
        //print_r($request->input());exit;
        $profileInputs['email_ratio'] = $request->input('email_ratio');
        //$profileInputs['unsubscribed'] = 1;
        $output = $this->userRepository->update($user_id, $profileInputs);
        // E-mail address was updated, user has to reconfirm
        if (is_array($output) && !empty($output['email_changed'])) {
            auth()->logout();

            return redirect()->back()->withFlashSuccess(__('strings.frontend.user.email_changed_notice'));
        }
        return redirect()->back()->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }


    public function consentRevoke(Request $request)
    {
        $user = auth()->user();
        $consent_type = $request->type;
        $userAddData = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $user_consents = isset($userAddData->user_consents) ? $get_user_add_data->user_consents : [];
        //$userConsent = $userAddData->user_consents;

        foreach ($userConsent as $index => $data) {
            if ($data['consent_type'] == $consent_type) {
                $data['consent_revoked'] = true;
                $data['consent_revoked_at'] = date('Y/m/d H:i:s');
                $userConsent[$index] = $data;
                break;
            }
        }
        $userAddData->user_consent_revoke = $userConsent;
        $userAddData->save();
        return Redirect::back()
            ->withFlashSuccess('Consent Revoked');
    }
    /*  public function socialLogin(Request $request, $provider)
      {
          $user = null;
          if (! in_array($provider, $this->socialiteHelper->getAcceptedProviders())) {
              return redirect()->route(home_route())->withFlashDanger(__('auth.socialite.unacceptable', ['provider' => $provider]));
          }
          if (! $request->all()) {
              return $this->getAuthorizationFirst($provider);
          }
          try {
              $user = $this->userRepository->findOrCreateProvider($this->getProviderUser($provider), $provider);
              dd($user);
          } catch (GeneralException $e) {
              return redirect()->route(home_route())->withFlashDanger($e->getMessage());
          }
      }
      protected function getAuthorizationFirst($provider)
      {
          $socialite = Socialite::driver($provider);
          $scopes = empty(config("services.{$provider}.scopes")) ? false : config("services.{$provider}.scopes");
          $with = empty(config("services.{$provider}.with")) ? false : config("services.{$provider}.with");
          $fields = empty(config("services.{$provider}.fields")) ? false : config("services.{$provider}.fields");
          if ($scopes) {
              $socialite->scopes($scopes);
          }

          if ($with) {
              $socialite->with($with);
          }

          if ($fields) {
              $socialite->fields($fields);
          }
          $redirect_url = route('inpanel.user.profile.preference.social','facebook');
          $socialite->redirectUrl($redirect_url);
          return $socialite->redirect();
      }

      protected function getProviderUser($provider)
      {
          return Socialite::driver($provider)->user();
      }*/

    public function verifyOTPGenerated(Request $request)
    {
        // dd("heelo"); die;
        $user = auth()->user();
        $request->merge(session('registration_data'));
        // Call the default laravel authentication
        $user->google2fa_secret = $request->google2fa_secret;
        $user->save();
        return response()->json(['status' => true]);
    }

    private function registerTwoFactorAuth($user, $data)
    {
        return redirect()->route('inpanel.dashboard')
            ->withFlashSuccess(__('inpanel.user.profile.preferences.two_fact.success_messages'));
    }

    //   public function executeImageUpdate(Request $request){
    //       // echo '<pre>';
    //       // print_r(File::exists(public_path('img').'/'.auth()->user()->image_url));die();
    //       $image_name = null;
    // $user = auth()->user();
    // if ($request->hasFile('imgUpload')) {
    // 	$image = $request->file('imgUpload');
    // 		$image_name = time() . '.' . $image->getClientOriginalExtension();
    // 		$destinationPath = public_path('img');
    // 	//	$destinationPath = 'private/SJPanel_Images/'.$image_name;
    // 	//	Storage::disk('do_spaces')->put($destinationPath,file_get_contents($image));
    // 		$image->move($destinationPath, $image_name);
    //               if(auth()->user()->image_url){
    //                   if(File::exists($destinationPath.'/'.auth()->user()->image_url)){
    //                       File::delete($destinationPath.'/'.auth()->user()->image_url);
    //                   }
    //               }
    // 		$this->userRepository->giveProfilePicUploadPoints($user);
    // 	} 
    //           $user_id = $request->user()->id;
    //           $profileInputs['image_url'] = $image_name;
    //           $output = $this->userRepository->update($user_id, $profileInputs);
    //           return redirect()->back()->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    //       // return response()->json(['success' => true,'message'=>'Success']);
    //   }

    //   public function executeImageDelete(Request $request){
    //       if(auth()->user()->image_url){
    //           if(File::exists(public_path('img').'/'.auth()->user()->image_url)){
    //               File::delete(public_path('img').'/'.auth()->user()->image_url);
    //           }
    //       }
    //       $user_id = $request->user()->id;
    //       $profileInputs['image_url'] = null;
    //       $output = $this->userRepository->update($user_id, $profileInputs);
    //       return redirect()->back()->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    //   }

    public function executeImageUpdate(Request $request)
    {
        $request->validate([
            'imgUpload' => 'required|image|max:10240', // 10 MB in KB
        ]);

        $image_name = null;
        $user = auth()->user();

        $centralize_server_image = config('settings.centralize_server_image');
        $url = $centralize_server_image . "api/v1/images";

        $uploadedFile = $request->file('imgUpload');
        $imagePath = $uploadedFile->getPathname();
        $mimeType = $uploadedFile->getMimeType();
        $originalName = $uploadedFile->getClientOriginalName();
        $postFields = [
            'image' => new \CURLFile($imagePath, $mimeType, $originalName),
            'image_type' => 'pictures',
            'id' => $user->id,
            'key' => 'profile_picture',
            'source' => 'web',
            'reference_id' => $user->id,
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => [
                'Accept: application/json;version=2.0',
                // Don't set Content-Type — let cURL handle it
            ]
        ]);

        $response = curl_exec($curl);
       // dd($response);
        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => $error], 500);
        }
        curl_close($curl);

        $responseArray = json_decode($response, true);
        // dd($responseArray);

        if (!empty($responseArray['success']) && $responseArray['success'] === true) {

            $mainPath = $responseArray['image_data'] ?? null;
            $thumbnailPathForDb = $responseArray['image_data'] ?? null;
            $reference_id = $user->id;
            StoredImage::updateOrCreate(
                [
                    'entity_id' => $user->id,
                    'storage_key'   => 'profile_picture',
                    'reference_id' => $reference_id
                ],
                [
                    'image_profile' => 'pictures',
                    'source' => 'web',
                    'disk' => 'public_direct',
                    'original_filename' => $uploadedFile->getClientOriginalName(),
                    'main_image_path' => $mainPath,
                    'thumbnail_image_path' => $thumbnailPathForDb,
                    'deleted_at' => null,
                ]
            );

            $image_name = $thumbnailPath ?? $mainPath;

            $this->userRepository->giveProfilePicUploadPoints($user);
        } else {
            return redirect()->back()->withErrors(['error' => $responseArray['message'] ?? 'Image processing failed.']);
        }

        $this->userRepository->giveProfilePicUploadPoints($user);
        $user_id = $request->user()->id;
        $profileInputs['image_url'] = $image_name;
        $output = $this->userRepository->update($user_id, $profileInputs);
        return redirect()->back()->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }
    public function executeImageDelete(Request $request)
    {
        $user = auth()->user();
        $key = $request->keyDelete;
        $entityId = $user->id;

        $centralize_server_image = config('settings.centralize_server_image');
        $url = $centralize_server_image . "api/v1/images/{$key}/{$entityId}/force";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "DELETE", // ← important fix
            CURLOPT_HTTPHEADER => [
                'Accept: application/json;version=2.0',
            ]
        ]);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error = curl_error($curl);
            curl_close($curl);
            return response()->json(['error' => $error], 500);
        }
        curl_close($curl);

        if ($user->image_url) {
            $filePath = public_path('img') . '/' . $user->image_url;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
        }
        // $user_id = $request->user()->id;
        // $profileInputs['image_url'] = null;
        // $output = $this->userRepository->update($user_id, $profileInputs);
        return redirect()->back()->withFlashSuccess(__('strings.frontend.user.profile_updated'));
    }
    public function twoFactSetting(Request $request)
    {
        // dd($request->all());
        // echo '<pre>';
        // print_r($request->all());die();
        $user = auth()->user();
        $user->two_fact_auth = 1;
        $user->save();
        echo "success";
        /*if($user->two_fact_auth==0){
            $google2fa = app('pragmarx.google2fa');*/

        /*$registration_data["google2fa_secret"] = $google2fa->generateSecretKey();*/
        /* $registration_data["google2fa_secret"] = $google2fa->generateSecretKey();


             if(session()->get('registration_data')){
                $request->session()->forget('registration_data');
                session()->put('registration_data', $registration_data);
             }else{
                 session()->put('registration_data', $registration_data);
             }*/
        /*$request->session()->flash('registration_data', $registration_data);*/
        /*echo $url = $this->getQRCodeUrl(
                 config('app.name'),
                 $user->email,
                 $registration_data["google2fa_secret"]
            );

            //return view('inpanel.google2fa.index', ['issuer' =>  config('app.name'), 'label' => $user->email, 'user' => $user,'url' => $url, 'secret' => $registration_data["google2fa_secret"]]);
         }*/
    }

    private function getQRCodeUrl($company, $holder, $secret)
    {
        return 'otpauth://totp/' .
            rawurlencode($company) .
            ':' .
            rawurlencode($holder) .
            '?secret=' .
            $secret .
            '&issuer=' .
            rawurlencode($company) .
            '';
    }


    public function sendOtp()
    {

        $user = auth()->user();
        $six_digit_random_number = mt_rand(100000, 999999);
        $encrypt_otp = \Crypt::encrypt($six_digit_random_number);
        if ($encrypt_otp) {
            $insert_data = [
                'user_id' => $user->id,
                'otp' => $encrypt_otp,
            ];
            $save_user_email_otp = UserEmailOtp::create($insert_data);
        }
        try {
            Mail::to($user->email)->send(new TwoDisableMail($user, $six_digit_random_number));
            return response()->json(['success' => true, 'message' => __('inpanel.user.profile.preferences.two_fact.sendOtp')]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function disableTwoFactSetting(Request $request)
    {
        $user = auth()->user();
        $latestOtpRecord = UserEmailOtp::where('user_id', $user->id)->latest()->first();

        if (!$latestOtpRecord) {
            return response()->json(['success' => false, 'message' => 'OTP record not found. Please try again.'], 400);
        }

        try {
            $decryptedOtp = Crypt::decrypt($latestOtpRecord->otp);
            $providedOtp = $request->input('otp');

            if ($decryptedOtp != $providedOtp) {
                return response()->json(['success' => false, 'message' => 'Incorrect OTP. Please try again.'], 200);
            }
        } catch (DecryptException $e) {
            \Log::error("Error decrypting OTP: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error decrypting OTP. Please try again.'], 500);
        }

        $user->two_fact_auth = 0;
        $user->two_fact_confirm = 0;
        $user->google2fa_secret = null;
        $user->save();

        $latestOtpRecord->delete();

        return response()->json(['success' => true, 'message' => __('inpanel.user.profile.preferences.two_fact.disabled')]);
    }


    /**
     * Created by Vikash Yadav 
     * Support Panellist Start 
     * 
     */

    public function panellistSupport(Request $request)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $user = auth()->user();
        $country_lang = $user->locale;
        $tab = $request->query('tab');
        if ($request->isMethod('post')) {
            // echo '<pre>';
            // print_r($request->all());
            // die;
            // $user = auth()->user();
            $this->validate($request, [
                'subject' => 'required',
                'support_type' => 'required',
                'attachment' => 'image|mimes:jpeg,png,jpg|max:2048',
                'your_query' => 'required',

            ]);

            $panellistSupportDetails = PanellistSupport::select('id')->orderBy('id', 'desc')->first();
            $fiveRandomDigit = mt_rand(10000, 99999);
            if (!empty($panellistSupportDetails)) {
                $supportid = ($panellistSupportDetails->id + 1);
                $ticketId = $fiveRandomDigit . '' . $supportid;
            } else {
                $supportid = 1;
                $ticketId = $fiveRandomDigit . '' . $supportid;
            }


            if ($request->hasFile('attachment')) {
                /*
                $image = $request->file('attachment');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/support_attachment');
                $image->move($destinationPath, $filename);
                */
                $centralize_server_image = config('settings.centralize_server_image');
                $url = $centralize_server_image . "api/v1/images";

                $uploadedFile = $request->file('attachment');
                $imagePath = $uploadedFile->getPathname();
                $mimeType = $uploadedFile->getMimeType();
                $originalName = $uploadedFile->getClientOriginalName();

                $postFields = [
                    'image' => new \CURLFile($imagePath, $mimeType, $originalName),
                    'image_type' => 'pictures',
                    'id' => $user->id,
                    'key' => 'support_attachment',
                    'source' => 'web',
                    'reference_id' => $ticketId
                ];
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postFields,
                    CURLOPT_HTTPHEADER => [
                        'Accept: application/json;version=2.0',
                    ]
                ]);

                $response = curl_exec($curl);

                if (curl_errno($curl)) {
                    $error = curl_error($curl);
                    curl_close($curl);
                    return redirect()->back();
                }

                curl_close($curl);

                $responseArray = json_decode($response, true);

                if (!empty($responseArray['success']) && $responseArray['success'] === true) {

                    $mainPath = $responseArray['image_data'] ?? null;
                    $thumbnailPathForDb = $responseArray['image_data'] ?? null;
                    StoredImage::updateOrCreate(
                        [
                            'entity_id' => $user->id,
                            'storage_key'   => 'support_attachment',
                            'reference_id' => $ticketId
                        ],
                        [
                            'image_profile' => 'pictures',
                            'source' => 'web',
                            'disk' => 'public_direct',
                            'original_filename' => $uploadedFile->getClientOriginalName(),
                            'main_image_path' => $mainPath,
                            'thumbnail_image_path' => $thumbnailPathForDb,
                            'deleted_at' => null,
                        ]
                    );

                    $this->userRepository->giveProfilePicUploadPoints($user);
                } else {
                    return redirect()->back()->withErrors(['error' => $responseArray['message'] ?? 'Image processing failed.']);
                }
                $filename = $responseArray['image_data'];
            } else {
                $filename = NULL;
            }

            //print_r($ticketId);die;

            $supportid = PanellistSupport::create([
                'user_id'      => $user->id,
                'ticket_id'    => $ticketId,
                'project_code' => $request->input('subject'),
                'subject'      => $request->input('support_type'),
                'file_name'    => $filename,
                'message'      => $request->input('your_query'),
                'updated_at'   => NULL
            ])->id;

            //PanellistSupport::where('id',$supportid)->update(['ticket_id'=>$ticketId]);

            SupportChat::create([
                'ticket_id'        => $supportid,
                'user_id'          => $user->id,
                'content'          => $request->input('your_query'),
                'attach_file_name' => $filename
            ]);

            //                 @php
            //   $originalLocale = app()->getLocale();

            //    app()->setLocale($user->locale);

            // @endphp
            //   $locale_user = $user->locale;

            if ($country_lang == 'en_US') {
                $subject = __('inpanel.Panelist_Support_Mail.subject1') . " [ $supportid ] " . __('inpanel.Panelist_Support_Mail.subject2');
            } else {
                $subject = __('inpanel.Panelist_Support_Mail.subject1') . " [ $supportid ] " . __('inpanel.Panelist_Support_Mail.subject2');
            }

            // this code commented by pushpendra
            // if($country_lang == 'en_US'){
            //     $subject = __('inpanel.Panelist_Support_Mail.subject1') . " [ $supportid ] " . __('inpanel.Panelist_Support_Mail.subject2');

            // }else{
            //     $subject = __('inpanel.Panelist_Support_Mail.subject1') . " [ $supportid ] " ;
            // }
            // this code commented by pushpendra

            // this code uncommented by pushpendra
            $subject = __('inpanel.Panelist_Support_Mail.subject1') . " [ $supportid ] " . __('inpanel.Panelist_Support_Mail.subject2');
            // this code uncommented by pushpendra
            $supportHistory = PanellistSupport::where('id', $ticketId)->first();
            $email = new PanelistSupport($user, $supportHistory);
            $email->subject($subject);
            Mail::send($email);

            // $subject1 = __('inpanel.Panelist_Support_Mail.subject1') . " [ $supportid ] " .__('inpanel.Panelist_Support_Mail.subject3');
            $subject1 = "Support ticket [$supportid] has been received";
            $SupportHistory = PanellistSupport::where('id', $ticketId)->first();
            $email = new PanelSupport($user, $SupportHistory);
            $email->subject($subject1);
            $recipients = ['amarjitm@samplejunction.com'];
            Mail::to($recipients)->locale('en_US')->send($email);



            // $ticket_route = route('inpanel.user.support_history')."?ticket=created";


            return redirect()->route('inpanel.user.support_history', ['ticket' => 'created'])->withFlashSuccess(__('inpanel.user.support.support_success'));
        }

        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
        $user_assign_projects_info = $this->userRepository->getUserAssignProject($user);
        $active_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $fetch_user_achievement1 = $active_user_add_data->user_achievement;
        $active_user_count = count($fetch_user_achievement1);
        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $updated_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $fetch_user_achievement = $updated_user_add_data->user_filled_profiles;
        if (!empty($fetch_user_achievement)) {
            $count_User = count(@$fetch_user_achievement);
        } else {
            $count_User = 0;
        }
        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $supportHistory = PanellistSupport::where('user_id', $user->id)->orderBy("orderByUpdate", "desc")->get();

        $notifications = $this->notificationRepo->getNotification($user->uuid);
        // echo '<pre>';
        // print_r($notifications);die();

        $user_points = $this->userRepository->getUserPoints($user);
        $userPoints_head = $user_points->user_points['completed'];

        /* Parshant Sharma [21-08-2024] Starts */

        $locale = app()->getLocale();

        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

            $cntry = explode('_', $countryPoint->country_language);

            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang' => $cntry[1],
            );
        }
        /* Parshant Sharma [21-08-2024] Ends */

        return view('inpanel.support.panelist_support')
            ->with('supportHistory', $supportHistory)
            ->with('userTimezone', $user->timezone)
            ->with('allUserSurveys', $user_assign_projects)
            ->with('allUserSurveys', $user_assign_projects)
            ->with('user_assign_projects_info', $user_assign_projects_info)
            ->with('user_notifications', $notifications)
            ->with('active_user_count', $active_user_count)
            ->with('country_lang', $country_lang)
            ->with('completedSurveys', $user_completed_surveys)
            ->with('user_count', $count_User)
            ->with('userExpireSurveys', $user_expire_surveys)
            ->with('user_point', $userPoints_head)
            ->with('countryPoints', $countryPoints)
            ->with('currentCountry', $currentCountry)
            ->with('tab',$tab)
            ->with('currencies', $currencies);
    }

    public function supportHistory(Request $request)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $user = auth()->user();
        $supportHistory = PanellistSupport::where('user_id', $user->id)->orderBy("orderByUpdate", "desc")->get();
        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
        $user_assign_projects_info = $this->userRepository->getUserAssignProject($user);
        $active_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $fetch_user_achievement1 = $active_user_add_data->user_achievement;
        $active_user_count = count($fetch_user_achievement1);
        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $updated_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $fetch_user_achievement = $updated_user_add_data->user_filled_profiles;
        if (!empty($fetch_user_achievement)) {
            $count_User = count(@$fetch_user_achievement);
        } else {
            $count_User = 0;
        }
        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);
        $country_lang = $user->locale;
        /* Parshant Sharma [13-09-2024] Starts */

        $locale = app()->getLocale();

        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

            $cntry = explode('_', $countryPoint->country_language);

            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang' => $cntry[1],
            );
        }
        /* Parshant Sharma [13-09-2024] Ends */

        // echo '<pre>';
        // print_r($supportHistory);die;
        // return view('inpanel.support.support_history')
        // ->with('supportHistory' , $supportHistory)
        // ->with('userTimezone',$user->timezone)
        $redirect = [];
        if ($request->has('update')) {
            $update = $this->notificationRepo->updateNotificationSeenStatus($request->notification_id);
            $redirect[0] = 'history';
        }
        $notifications = $this->notificationRepo->getNotification($user->uuid);
        $user_points = $this->userRepository->getUserPoints($user);
        $userPoints_head = $user_points->user_points['completed'];
        return view('inpanel.support.panelist_support')
            ->with('supportHistory', $supportHistory)
            ->with('userTimezone', $user->timezone)
            ->with('allUserSurveys', $user_assign_projects)
            ->with('allUserSurveys', $user_assign_projects)
            ->with('user_assign_projects_info', $user_assign_projects_info)
            ->with('active_user_count', $active_user_count)
            ->with('country_lang', $country_lang)
            ->with('history', $redirect)
            ->with('user_notifications', $notifications)
            ->with('completedSurveys', $user_completed_surveys)
            ->with('user_count', $count_User)
            ->with('user_point', $userPoints_head)
            ->with('userExpireSurveys', $user_expire_surveys)
            ->with('countryPoints', $countryPoints)
            ->with('currentCountry', $currentCountry)
            ->with('currencies', $currencies);
    }


    public function supportChat(Request $request, $ticket_id)
    {
        $outHomeCntry = geoip(request()->ip());
        $currentCountry = $outHomeCntry->iso_code;
        $user = auth()->user();
        if ($request->all()) {
            //echo '<pre>';
            //print_r($request->all());die;
            $this->validate($request, [
                'comment' => 'required',
                'attachment' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);


            if ($request->hasFile('attachment')) {
                /*
                $image = $request->file('attachment');
                $filename = 'chat-'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/support_attachment');
                $image->move($destinationPath, $filename);*/

                $centralize_server_image = config('settings.centralize_server_image');
                $url = $centralize_server_image . "api/v1/images";

                $uploadedFile = $request->file('attachment');
                $imagePath = $uploadedFile->getPathname();
                $mimeType = $uploadedFile->getMimeType();
                $originalName = $uploadedFile->getClientOriginalName();

                $postFields = [
                    'image' => new \CURLFile($imagePath, $mimeType, $originalName),
                    'image_type' => 'pictures',
                    'id' => $user->id,
                    'key' => 'support_attachment',
                    'source' => 'web',
                    'reference_id' => $ticket_id
                ];
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_POSTFIELDS => $postFields,
                    CURLOPT_HTTPHEADER => [
                        'Accept: application/json;version=2.0',
                    ]
                ]);

                $response = curl_exec($curl);

                if (curl_errno($curl)) {
                    $error = curl_error($curl);
                    curl_close($curl);
                    return redirect()->back();
                }

                curl_close($curl);

                $responseArray = json_decode($response, true);

                if (!empty($responseArray['success']) && $responseArray['success'] === true) {

                    $mainPath = $responseArray['image_data'] ?? null;
                    $thumbnailPathForDb = $responseArray['image_data'] ?? null;
                    StoredImage::updateOrCreate(
                        [
                            'entity_id' => $user->id,
                            'storage_key'   => 'support_attachment',
                            'reference_id' => $ticket_id
                        ],
                        [
                            'image_profile' => 'pictures',
                            'source' => 'web',
                            'disk' => 'public_direct',
                            'original_filename' => $uploadedFile->getClientOriginalName(),
                            'main_image_path' => $mainPath,
                            'thumbnail_image_path' => $thumbnailPathForDb,
                            'deleted_at' => null,
                        ]
                    );

                    $this->userRepository->giveProfilePicUploadPoints($user);
                } else {
                    return redirect()->back()->withErrors(['error' => $responseArray['message'] ?? 'Image processing failed.']);
                }
                // $this->userRepository->giveProfilePicUploadPoints($user);
                $filename = $responseArray['image_data'];
            } else {
                $filename = NULL;
            }
            SupportChat::create([
                'ticket_id'        => $ticket_id,
                'user_id'          => $user->id,
                'content'          => $request->input('comment'),
                'attach_file_name' => $filename
            ]);

            PanellistSupport::where('id', $ticket_id)->update(['updated_at' => Carbon::now()]);
            return \Redirect::back();
        }
        //echo '<pre>';
        $supportHistory = PanellistSupport::where('id', $ticket_id)->where('user_id', $user->id)->first();

        if (empty($supportHistory)) {
            return redirect()->route('inpanel.user.support_history');
        }
        $allChatsById = SupportChat::where('ticket_id', $ticket_id)->get();
        //print_r($allChatsById);die;



        $user_assign_projects = $this->userRepository->getUserAssignProjectCount($user);
        $user_completed_surveys = $this->userRepository->getUserCompletedProject($user);
        $user_attempted_surveys = $this->userRepository->getUserAttemptedProject($user);
        $user_active_surveys = $this->userRepository->getUserActiveSurveys($user);
        $user_expire_surveys = $this->userRepository->getUserExpireSurveys($user);

        $active_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $fetch_user_achievement1 = $active_user_add_data->user_achievement;
        $active_user_count = count($fetch_user_achievement1);

        $updated_user_add_data = UserAdditionalData::where('uuid', '=', $user->uuid)->first();
        $fetch_user_achievement = $updated_user_add_data->user_filled_profiles;
        if (!empty($fetch_user_achievement)) {
            $count_User = count(@$fetch_user_achievement);
        } else {
            $count_User = 0;
        }

        $user_points = $this->userRepository->getUserPoints($user);
        $userPoints_head = $user_points->user_points['completed'];

        /* Parshant Sharma [13-09-2024] Starts */

        $locale = app()->getLocale();

        $countryPoint = $this->countriesCurrenciesRepository->getPointsDetail($locale);
        $countryPoints = isset($countryPoint->points) ? $countryPoint->points : 1000;

        // Initialize an empty array
        $currencies = array();

        if (isset($countryPoint->currency_symbols) && isset($countryPoint->currency_denom_singular)) {

            $cntry = explode('_', $countryPoint->country_language);

            $currencies = array(
                'currency_logo'  => $countryPoint->currency_symbols,
                'currency_denom_singular' => $countryPoint->currency_denom_singular,
                'currency_denom_plural' => $countryPoint->currency_denom_plural,
                'lang' => $cntry[1],
            );
        }
        /* Parshant Sharma [13-09-2024] Ends */

        return view('inpanel.support.new_support_chat')
            ->with('supportHistory', $supportHistory)
            ->with('allChatsById', $allChatsById)
            ->with('userTimezone', $user->timezone)

            ->with('allUserSurveys', $user_assign_projects)
            ->with('completedSurveys', $user_completed_surveys)
            ->with('userActiveSurveys', $user_active_surveys)
            ->with('userExpireSurveys', $user_expire_surveys)
            ->with('active_user_count', $active_user_count)
            ->with('user_count', $count_User)
            ->with('user_point', $userPoints_head)
            ->with('countryPoints', $countryPoints)
            ->with('currentCountry', $currentCountry)
            ->with('currencies', $currencies);
    }


    public function changeSupportStatus(Request $request)
    {

        $supportId = $request->input('supportId');

        // $updateSupport = PanellistSupport::where('id','=',$supportId)
        // ->update(['status' => 1,'updated_at'=>Carbon::now()]);
        $changeStatus = $request->input('statusData');
        $updateUsers = PanellistSupport::where('id', '=', $supportId)
            ->update(['status' => $changeStatus, 'updated_at' => Carbon::now()]);
        $user_uuid = auth()->user()->uuid;

        // Code updated by Vikas For handling notification according to Languages(Starting 3/11/2025)

        // if ($changeStatus == 0) {
        //     $msg =  __('frontend.notification_txt.support_rqst_status_3') . $supportId . __('frontend.notification_txt.support_rqst_status_4');
        // } else {
        //     $msg =  __('frontend.notification_txt.support_rqst_status_1') . $supportId . __('frontend.notification_txt.support_rqst_status_2');
        // }
        // $support_request = $this->notificationRepo->createNotification($user_uuid, 'Support Request', $supportId, $msg);

        if ($changeStatus == 0) {
            $msg_keys = [
                'start' => 'frontend.notification_txt.support_rqst_status_3',
                'end'   => 'frontend.notification_txt.support_rqst_status_4'
            ];
        } else {
            $msg_keys = [
                'start' => 'frontend.notification_txt.support_rqst_status_1',
                'end'   => 'frontend.notification_txt.support_rqst_status_2'
            ];
        }
        $support_request = $this->notificationRepo->createNotification($user_uuid, 'Support Request', $supportId, json_encode([
            'keys' => $msg_keys,
            'supportId' => $supportId
        ]));
        // Code updated by Vikas For handling notification according to Languages(Ending 3/11/2025) 
        
        // Platform Tracking code added by Vikas(Code Starting)
        $this->userRepository->storePlatForm(auth()->user()->uuid, 'web', 'support_ticket', $supportId);
        return response()->json(['status' => 200], 200);
    }
    /**
     * Support Panellist End
     */

    /**
     * This action is used for Adding activity log as the User Completes any profile.
     *
     * @param $user
     * @param $profile
     */
    private function logProfileAchievementActivity($user, $profile)
    {

        activity("user_achievements")
            ->causedBy($user->id)
            ->withProperties(["points" => $profile['points']])
            ->log('inpanel.activity_log.profile.' . $profile['code'] . '.achieved');
    }


    public function deactivateUser(Request $request)
    {

        $email = $request->user()->email;
        $reason = "SJ Panel User unsubscribe from email Frequency tab";
        $hashed_email = hash('sha1', $email);

        $user = User::where('email_hash', $hashed_email)->first();
        if (empty($user)) {
            return response()->json(['error' => 'User not found for email: ' . $hashed_email], 404);
        } else {
            UserUnsubscribe::create([
                'email' => $email,
                'reason' => $reason,
            ]);
            $user->deactivate_at = Carbon::now();
            $user->active = 0;
            $user->unsubscribed = 1;
            $user->save();

            $response = ['message' => __('inpanel.user.profile.preferences.preferences_menu.unsubscribe_email_success')];
            return response()->json($response, 200);
        }
    }
}
