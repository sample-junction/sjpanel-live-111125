<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Frontend\UniqueCheck\UniqueCheckEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Auth\ContactRequest;
use App\Http\Requests\PromoRegisterRequest;
//use App\Http\Requests\RegisterRequest;
use App\Helpers\Frontend\Auth\Socialite;
use App\Models\Setting\Setting;
use App\Events\Frontend\Auth\UserRegistered;
use App\Listeners\Inpanel\ReferralManage;
use App\Models\Affiliate\AffiliateCampaign;
use App\Models\Affiliate\AffiliateCampaignData;
use App\Models\Affiliate\AffiliateList;
use App\Models\Auth\User;
use App\Mail\Frontend\UserConfirm\UserConfirmation;
use Carbon\Carbon;
use App\Models\Auth\SjDfiqApiResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Repositories\Inpanel\General\GeneralRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use phpDocumentor\Reflection\DocBlock\Tags\Source;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite as SocialiteFacebook;
use App\Exceptions\GeneralException;
use App\Events\Frontend\Auth\UserProviderRegistered;
use App\Events\Frontend\Auth\UserConfirmed;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\PanellistAddress;
use App\Models\EmailRegisterLog;

/**
 * This class is used for handling registration process of both normal and promo link customers.
 *
 * Class RegisterController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package  App\Http\Controllers\Frontend\Auth\RegisterController
 */

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository, $generalRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(
        UserRepository $userRepository,
        GeneralRepository $generalRepository
    ) {
        $this->userRepository = $userRepository;
        $this->generalRepository = $generalRepository;
    }

    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    public function redirectPath()
    {
        return route(home_route());
    }

    /**
     * This function is used to Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm(Request $request)
    {
        $ip = request()->ip();
        $DFIQ = config("settings.dfiq.status");

        //UUID Genderate By Ramesh Kamboj//
        // $uuid = Str::uuid()->toString();
        //End Here//
        $sjtest = $request->input("sjtest", false);
        Cookie::queue("sjtest", $sjtest);
        $user_group = $request->input("user_group", false);
        Cookie::queue("user_group", $user_group);
        abort_unless(config("access.registration"), 404);
        $geodata = geoip(request()->ip());

        $ipcountryCode = $geodata->getAttribute('iso_code');
        if ($ipcountryCode == 'GB') {
            $ipcountryCode = 'UK';
        }


        //Code Added By Ramesh//

        $AllowCountry = ['US', 'UK', 'CA', 'IN', 'GB'];
        if (!in_array($ipcountryCode, $AllowCountry)) {
            //return redirect('home')->withErrors(__('validation.attributes.frontend.is_geopostal'));
        }

        //End Here//
        /*Todo for $countries as withTranslation() function is not working*/
        $countries = Cache::remember('countries', 3600, function () {
            return $this->generalRepository->getActiveCountries();
        });
        // print_r($countries);-exit();
        return view("frontend.auth.register")
            ->with("ip", str_replace(".", "-", request()->ip()))
            ->with("country_code", $ipcountryCode)
            ->with("uuid", $uuid)
            ->with("dfiq", $DFIQ)
            ->withSocialiteLinks((new Socialite())->getWithSignSocialLinks())
            ->withCurrentCountry($ipcountryCode)
            ->withCountries($countries);
    }
    public function index(Request $request)
    {
        $user = $request->session()->get("users");
        $flag = str_replace(
            "_",
            "-",
            strtoupper($request->session()->get("locale"))
        );

        /* Parshant [02-06-2025] */
        $utm_source = isset($_GET['utm_source']) ? $_GET['utm_source'] : null;

        if (!$utm_source && isset($_SERVER['HTTP_REFERER'])) {
            $refererUrl = $_SERVER['HTTP_REFERER'];
            $parsedUrl = parse_url($refererUrl);
            $host = isset($parsedUrl['host']) ? strtolower($parsedUrl['host']) : '';
            // dd($host);

            $sourceMap = [
                'youtube.com'    => 'Youtube',
                'www.youtube.com' => 'Youtube',
                'youtu.be'       => 'Youtube',
                'google'         => 'Google',
                'google.com'     => 'Google',
                'bing'           => 'Bing',
                'bing.com'       => 'Bing',
                'yahoo.com'      => 'Yahoo',
                'yahoo'            => 'Yahoo',
                'linkedin.com'   => 'LinkedIn',
                'com.linkedin.android' => 'LinkedIn',
                'm.facebook.com' => 'Facebook',
                'lm.facebook.com' => 'Facebook',
                'l.facebook.com' => 'Facebook',
                'chatgpt.com' => 'ChatGPT',
                'l.instagram.com' => 'Instagram',
                'facebook.com'   => 'Facebook',
                't.co'           => 'Twitter'
            ];
            foreach ($sourceMap as $keyword => $name) {
                if (strpos($host, $keyword) !== false) {
                    $utm_source = $name;
                    break;
                }
            }
        }
        $cookie_data = [
            'utm_campaign' => isset($_GET['utm_campaign']) ? $_GET['utm_campaign'] : null,
            'utm_source'   => $utm_source
        ];

        //echo '<pre>';print_r($cookie_data); exit;		

        //$cookie_data = $request->only(["utm_campaign", "utm_source"]);

        /* Parshant [02-06-2025] */

        //$cookie_data = $request->only(['utm_campaign', 'utm_source', 'utm_medium', 'utm_content']);
        $aff_vars = "aff_sub1";
        $varsData = $request->only($aff_vars);
        $cookie_data = array_merge($cookie_data, $varsData);

        Cookie::queue("affiliate_data", json_encode($cookie_data));

        // $countries = $this->generalRepository->getActiveCountries();
        $ip = request()->ip();
        $uuid = Str::uuid()->toString();
        $geodata = geoip(request()->ip());

        $ipcountryCode = $geodata->getAttribute('iso_code');
        $country = $geodata->getAttribute('country');
        if ($ipcountryCode == 'GB') {
            $ipcountryCode = 'UK';
        }
        if ($ipcountryCode != 'US') {
            if (!empty($request->session()->get('locale'))) {
                $flag = str_replace('_', '-', strtoupper($request->session()->get('locale')));
            } else {
                app()->setLocale('EN-' . $ipcountryCode);
                $flag = 'EN-' . $ipcountryCode;
            }
        } else {
            $flag = str_replace(
                "_",
                "-",
                strtoupper($request->session()->get("locale"))
            );
        }

        //Code Added By Ramesh//
        $AllowCountry = ['US', 'UK', 'CA', 'IN', 'GB'];
        if (!in_array($ipcountryCode, $AllowCountry)) {
            return redirect()->route(home_route())->withFlashDanger(__('validation.attributes.frontend.not_allowed_country'));
        }

        //End Here//
        $DFIQ = config("settings.dfiq.status");
        /**Code added to track users from campaign by RAS - 05/02/2024 */
        if ($request->has("is_reminder") || $request->has("is_campaign")) {
            $token = $request->token;
            DB::table("invite_campaigns")
                // DB::table('inv_camp_copy_for_mail_test_purpose')
                ->where("campaign_code", "=", $token)
                ->orWhere("reminder_code", "=", $token)
                ->update(["has_visited" => 1]);
            // print($token);die();
            /**code added for invite campaign with incentive for registration */
            // $request->
            session()->put("campaign", "1");
        }

        /**End code */
        return view("frontend.auth.register")
            ->withSocialiteLinks((new Socialite())->getWithSignSocialLinks())
            ->with("users", $user)
            // ->withCountries($countries)
            ->with("uuid", $uuid)
            ->with("ip", str_replace(".", "-", request()->ip()))
            ->with("country_code", $ipcountryCode)
            ->with("country_name", strtoupper($country))
            ->with("flags", $flag)
            ->with("dfiq", $DFIQ);
    }

    //Function added by Ramesh Kamboj//
    public function affiliate_register(Request $request)
    {
        $cookie_data = $request->only(["utm_campaign", "utm_source", "cid"]);
        //$cookie_data = $request->only(['utm_campaign', 'utm_source', 'utm_medium', 'utm_content']);
        $aff_vars = "aff_sub1";
        $varsData = $request->only($aff_vars);
        $cookie_data = array_merge($cookie_data, $varsData);
        Cookie::queue("affiliate_data", json_encode($cookie_data));
        $user = $request->session()->get("users");
        $flag = str_replace(
            "_",
            "-",
            strtoupper($request->session()->get("locale"))
        );

        //Code Added By Ramesh [02-03-2025]

        DB::table('affiliate_user_activities')->insert(
            ['medium' => $request->get('utm_source'), 'cid' => $request->get('cid'), 'sjid' => $request->get('aff_sub1'), 'log' => 'Campaign user reditect to Signup page', 'country' => $request->get('country'), 'campaign_type' => $request->get('utm_campaign'), 'created_at' => date("Y-m-d h:i:s")]
        );
        //End Here
        $countries = $this->generalRepository->getActiveCountries();
        $ip = request()->ip();
        $uuid = Str::uuid()->toString();
        $geodata = geoip(request()->ip());
        $ipcountryCode = $geodata->getAttribute('iso_code');
        $country = $geodata->getAttribute('country');
        if ($ipcountryCode == 'GB') {
            $ipcountryCode = 'UK';
        }
        if ($ipcountryCode != 'US') {
            if (!empty($request->session()->get('locale'))) {
                $flag = str_replace('_', '-', strtoupper($request->session()->get('locale')));
            } else {
                app()->setLocale('EN-' . $ipcountryCode);
                $flag = 'EN-' . $ipcountryCode;
            }
        } else {
            $flag = str_replace(
                "_",
                "-",
                strtoupper($request->session()->get("locale"))
            );
        }
        $DFIQ = config("settings.dfiq.status");

        return view("frontend.auth.register", compact("users", $user))
            ->withSocialiteLinks((new Socialite())->getWithSignSocialLinks())
            ->withCountries($countries)
            ->with("uuid", $uuid)
            ->with("ip", str_replace(".", "-", request()->ip()))
            ->with("country_code", $ipcountryCode)
            ->with("country_name", strtoupper($country))
            ->with("flags", $flag)
            ->with("dfiq", $DFIQ);
    }
    //EndHere//
    public function details(Request $request)
    {
        $user = $request->session()->get("users");
        return view("frontend.auth.personal-details", compact("users", $user));
    }
    public function thanks(Request $request)
    {
        return view("frontend.auth.thank-you");
    }
    public function submit(Request $request)
    {
        // echo "this is register function";exit();

        $validatedData = $request->validate(
            [
                "email" => ["required", "string", "email", "max:191"],
                "create_password" => [
                    "required",
                    "string",
                    'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
                    "min:8",
                    "max:20",
                ],
                "confirm_password" => "required|same:create_password",
            ],
            [
                "email.required" => "Enter valid Email address",
                "create_password.required" => "Enter valid Password ",
                "confirm_password.required" => "Password does not match",
            ]
        );

        $blacklistedUser = User::withTrashed()
            ->whereNotNull('deleted_at')
            ->where('is_blacklist', '1')
            ->get();

        //                 echo"<pre>";
        // print_r($blacklistedUser);
        // exit;


        foreach ($blacklistedUser as $deletedUser) {

            if ($deletedUser->email_hash == sha1($request->email) || $deletedUser->ip_registered_with == request()->ip()) {

                return redirect('register')->withErrors(__('frontend.messages.blacklist_acc_error'));
            }
        }

        $countries = $this->generalRepository->getActiveCountries();
        $ip = request()->ip();
        $uuid = Str::uuid()->toString();
        $geodata = geoip(request()->ip());
        $ipcountryCode = $geodata->getAttribute('iso_code');
        $country = $geodata->getAttribute('country');

        if ($ipcountryCode == 'GB') {

            $ipcountryCode = 'UK';
        }
        //Code Added By Ramesh [02-03-2025]
        $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
        if (!empty($check_affiliate_cookie)) {
            $cookie_data = json_decode($check_affiliate_cookie);
            $cid = isset($cookie_data->cid) ? $cookie_data->cid : '';
            $aff_sub1 = isset($cookie_data->aff_sub1) ? $cookie_data->aff_sub1 : '';
            $medium = isset($cookie_data->utm_source) ? $cookie_data->utm_source : '';
            DB::table('affiliate_user_activities')->insert(
                ['medium' => $medium, 'cid' => $cid, 'sjid' => $aff_sub1, 'log' => 'personal details page', 'country' => $ipcountryCode, 'campaign_type' => 'doi_campaign', 'created_at' => date("Y-m-d h:i:s")]
            );
        }
        //End Here
        $DFIQ = config('settings.dfiq.status');

        if ($ipcountryCode != 'US') {
            if (!empty($request->session()->get('locale'))) {
                $flag = str_replace('_', '-', strtoupper($request->session()->get('locale')));
            } else {

                app()->setLocale('EN-' . $ipcountryCode);
                $flag = 'EN-' . $ipcountryCode;
            }
        } else {
            $flag = str_replace(
                "_",
                "-",
                strtoupper($request->session()->get("locale"))
            );
        }
        //Code Added By Ramesh [02-03-2025]
        $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
        if (!empty($check_affiliate_cookie)) {
            $cookie_data = json_decode($check_affiliate_cookie);
            $cid = isset($cookie_data->cid) ? $cookie_data->cid : '';
            $aff_sub1 = isset($cookie_data->aff_sub1) ? $cookie_data->aff_sub1 : '';
            $utm_source = isset($cookie_data->utm_source) ? $cookie_data->utm_source : '';
            DB::table('affiliate_user_activities')->insert(
                ['medium' => $utm_source, 'cid' => $cid, 'sjid' => $aff_sub1, 'log' => 'personal details page', 'country' => $ipcountryCode, 'campaign_type' => 'doi_campaign', 'created_at' => date("Y-m-d h:i:s")]
            );
        }
        //End Here
        // return redirect('personal-details');
        //  return view('inpanel.basic_detail.index');
        return view("frontend.auth.personal-details")
            ->with("email", $request->get("email", false))
            ->with("password", $request->get("create_password", false))
            ->withCountries($countries)
            ->with("uuid", $uuid)
            ->with("ip", str_replace(".", "-", request()->ip()))
            ->with("country_code", $ipcountryCode)
            ->with("country_name", strtoupper($country))
            ->with("flags", $flag)
            ->with("dfiq", $DFIQ);
    }
    public function proceed(Request $request)
    {
        /* echo '<pre>';
        print_r($request->all());
        echo $request->session()->get('locale');

        exit(); */

        // echo "thank you";exit();

        $ip = request()->ip();
        $countryName = $request->input('country_name');
        $min_age = 0;
        if ($countryName == 'India') {
            $min_age = 18;
        } else {

            $min_age = 13;
        }
        $olderThanDate = date("Y-m-d", strtotime("-" . $min_age . "years"));
        $validatedData = $request->validate(
            [
                "firstname" => ["required", "string", "max:191"],
                "lastname" => ["required", "string", "max:191"],
                "gender" => ["required"],
                "date" => "required",
                "zip" => "required",
                "country_name" => "required",
                "language" => "required",
            ],
            [
                "firstname.required" => "Enter Firstname",
                "lastname.required" => "Enter Lastname",
                "gender.required" => __("frontend.index.contact_us.sel_gender"),
                "date.required" => "Select Date",
                "zip.required" => "Enter Zip code",
                "country_name.required" => "Select Country",
                "language.required" => "Select Language",
            ]
        );
        $isEmailExist = $this->getUsersEmail($request);
        if (!empty($isEmailExist)) {
            return redirect('register')->withErrors(__('frontend.index.contact_us.toastr_2'));
        } else {
            // print($validatedData);exit();
            $RecordCnt = $this->userRepository->getRecordsCountForCurrentDay();

            //$panId =  date('ymd').str_pad($RecordCnt+1, 4, "0", STR_PAD_LEFT);
            if (strlen($RecordCnt) >= 4 && $RecordCnt >= 9999) {
                $RCnt = $RecordCnt + 1;
                $panId = date("ymds") . $RCnt;
            } else {
                $panId =
                    date("ymds") . str_pad($RecordCnt + 1, 4, "0", STR_PAD_LEFT);
            }
            // echo '<pre>'; print_r(app()->getLocale());die();
            $data["panellist_id"] = $panId;
            $dataArr = explode("-", $request["date"]);
            $DOB = $dataArr[2] . "-" . $dataArr[0] . "-" . $dataArr[1];
            $register_input_data = $request->only(
                "firstname",
                "lastname",
                "email",
                "create_password",
                "gender",
                "date",
                "country_name"
            );
            $user = User::create([
                "panellist_id" => $panId,
                "first_name" => $request["firstname"],
                "last_name" => $request["lastname"],
                "middle_name" => "",
                "email" => $request["email"],
                "email_hash" => sha1(strtolower($request["email"])), // strtolower added by Vikas
                "confirmation_code" => md5(uniqid(mt_rand(), true)),
                "active" => 1,
                "password" => trim($request["create_password"]),
                "dob" => !empty($DOB) ? $DOB : null,
                "gender" => !empty($request["gender"]) ? $request["gender"] : null,
                "country" => trim($request["country_name"]),
                /*  "locale" => !empty($request->session()->get("locale"))
                    ? $request->session()->get("locale")
                    : "en_US", */
                "locale" => !empty($request['language'])
                    ? strtolower(trim($request['language'])) . '_' . trim($request["country_name"])
                    : "en_US",
                "user_group" => !empty($data["user_group"])
                    ? $data["user_group"]
                    : 1,
                "ip_registered_with" => request()->ip(),
                "profile_updatetoken" => 0,
                "zipcode" => $request["zip"],
                // If users require approval or needs to confirm email
                "confirmed" =>
                config("access.users.requires_approval") ||
                    config("access.users.confirm_email")
                    ? 0
                    : 1,
            ]);


            if ($user) {
                // Platform Tracking code added by Vikas(Code Starting)
                $this->userRepository->storePlatForm($user->uuid, 'web', 'registration', null);

                // Platform Tracking (Code Ending)

                $state = $this->getStateFromZipCode($request["zip"], trim($request["country_name"]), $panId);

                // Check if state is valid
                if ($state !== null) {

                    // Do something with $state, for example, add it to the usersData array
                    $stateName = $state[0] ?? null;
                    $cityName = $state[1] ?? null;
                    $regionName = $state[2] ?? '-';

                    $panellistAddressArr = [
                        'user_id' => $user->id,
                        'city' => $cityName,
                        'state' => $stateName,
                        'region' => $regionName
                    ];

                    $this->savePanellistAddress($panellistAddressArr);
                }

                //Code Added By Ramesh [02-03-2025]

                $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
                if (!empty($check_affiliate_cookie)) {

                    $cookie_data = json_decode($check_affiliate_cookie);
                    $cid = isset($cookie_data->cid) ? $cookie_data->cid : '';
                    $aff_sub1 = isset($cookie_data->aff_sub1) ? $cookie_data->aff_sub1 : '';
                    $utm_source = isset($cookie_data->utm_source) ? $cookie_data->utm_source : '';

                    $checkInsert = DB::table('affiliate_user_activities')->insert(
                        ['medium' => $utm_source, 'cid' => $cid, 'sjid' => $aff_sub1, 'log' => 'Sign up Completed', 'country' => trim($request["country_name"]), 'panelist_id' => $panId, 'campaign_type' => 'doi_campaign', 'created_at' => date("Y-m-d h:i:s")]
                    );
                }
                //End Here
                //event(new UserRegistered($user,$register_input_data));

                /*
                 * Add the default site role to the new user
                 */
                /**modified by obhi**/
                if (isset($request["email"]) && !empty($request["email"])) {
                    // Split the email address by @
                    $emailParts = explode("@", $request["email"]);
                    $emailArr = [
                        "sayani.deb.test@gmail.com",
                        "amar.das.test@gmail.com",
                        "riya.roy.test6@gmail.com",
                        "majumderamarjit16@gmail.com",
                        "bochkarirohan@gmail.com",
                        "majumderamarjit950@gmail.com",
                        "pranavtest001@gmail.com",
                        "pranavtest0002@gmail.com",
                        "pranavtest003@gmail.com",
                        "pranavtest005@gmail.com",
                        "pranavtest006@gmail.com",
                        "pranavtest0007@gmail.com",
                        "pranavtest0008@gmail.com",
                        "pranavtest009@gmail.com",
                        "pranavs.sj007@gmail.com",
                        "Pranavtest005@gmail.com",
                        "alpad.sj007@gmail.com",
                    ];

                    if (
                        strtolower($emailParts[1]) === "samplejunction.com" ||
                        in_array($request["email"], $emailArr)
                    ) {
                        $user->assignRole(
                            config("access.users.test_penalist_role")
                        );
                    } else {
                        $user->assignRole(config("access.users.default_role"));
                    }
                }
                /**modified by obhi**/
                //$user->assignRole(config('access.users.default_role'));
            }
            // echo "<pre>";
            // print($user);exit();
            $check_invite_cookie = $this->userRepository->checkInviteCookieCode();
            $METHOD_TYPE = \Cookie::get('SJ_SECURE_METHOD_TYPE');
            $REFER_CODE = \Cookie::get('SJ_SECURE_REF_CODE');
            event(new UserRegistered($user, $register_input_data));
            $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
            \Log::info('Email Delivered:' . $user->email);
            //Code Added By ramesh for Affiliate Campaign//

            if (!empty($check_affiliate_cookie)) {
                //$user=auth()->user();
                $cookie_data = json_decode($check_affiliate_cookie);
                $source = $cookie_data->utm_source;
                $campaign = $cookie_data->utm_campaign;
                $cid = isset($cookie_data->cid) ? $cookie_data->cid : ''; // [09-09-2024]
                $varsData["aff_sub1"] = isset($cookie_data->aff_sub1) ? $cookie_data->aff_sub1 : '';
                $varsData["cid"] = isset($cookie_data->cid) ? $cookie_data->cid : '';
                $varsData["utm_source"] = isset($cookie_data->utm_source) ? $cookie_data->utm_source : '';
                $affiliate_campaign_data = [
                    "user_id" => $user->id,
                    "aff_camp_id" => 2,
                    "source_id" => 1,
                    "medium" => $cookie_data->utm_source,
                    "aff_vars" => json_encode($varsData),
                ];

                AffiliateCampaignData::create($affiliate_campaign_data);
            }

               /**Code added by Anil Sharma
             * Date: 24-09-2025
             */
            $emailLogs = EmailRegisterLog::where('user_ip', request()->ip())->first();
 
            if ($emailLogs) {
                $affiliate_campaign_data = [
                    "user_id"    => $user->id,
                    "aff_camp_id" => 2,
                    "source_id"  => 1,
                    "medium"     => $emailLogs->affiliate,
                ];
 
                AffiliateCampaignData::create($affiliate_campaign_data);
            }
            // Anil code end

            //End Here//
            if ($check_invite_cookie) {
                $this->userRepository->giveUserInvitePoints($check_invite_cookie, $user, $REFER_CODE, $METHOD_TYPE);
                //Add code by vikash (29-11-2022)
                // $this->userRepository->giveUserReferralPoints($check_invite_cookie,$user,$REFER_CODE,$METHOD_TYPE);
            }
            session()->put("last_active", time());

            //Added by RAS for confirmation mail coming in english for spanish account issue 07-09-23
            app()->setLocale(
                !empty($request->session()->get("locale"))
                    ? $request->session()->get("locale")
                    : "en_US"
            );
            //end code by RAS
            if (config("access.users.confirm_email")) {
                // Pretty much only if account approval is off, confirm email is on, and this isn't a social account.
                $get_unsubscribe_details = $user->checkUnsubscribedEmail(
                    $user->email
                );

                /**code added for invite campaign with incentive */
                if (session()->has("campaign")) {
                    $get_reffer_point = Setting::whereIn("key", [
                        "PANEL_SIGNUP_POINTS",
                        "PANEL_ACCOUNT_ACTIVATION_POINTS",
                        "PANEL_BASIC_PROFILE_POINTS",
                        "PANEL_CAMPAIGN_INCENTIVE",
                    ])->sum("value");
                } else {
                    /**Query modified by RAS 08/01/24 */
                    $get_reffer_point = Setting::whereIn("key", [
                        "PANEL_SIGNUP_POINTS",
                        "PANEL_ACCOUNT_ACTIVATION_POINTS",
                        "PANEL_BASIC_PROFILE_POINTS",
                    ])->sum("value");
                }

                if (!$get_unsubscribe_details) {
                    if (session()->has("campaign")) {
                        $email = new UserConfirmation(
                            $user,
                            $user->confirmation_code,
                            $get_reffer_point,
                            0,
                            1
                        );
                    } else {
                        $email = new UserConfirmation(
                            $user,
                            $user->confirmation_code,
                            $get_reffer_point,
                            0
                        );
                    }

                    Mail::send($email);
                }
                /* $user->notify(new UserNeedsConfirmation($user->confirmation_code));*/
            }

            if (
                config("access.users.confirm_email") ||
                config("access.users.requires_approval")
            ) {
                activity()
                    ->causedBy($user)
                    ->log("inpanel.activity_log.registration");
                return view("frontend.auth.thank-you")->withFlashSuccess(
                    config("access.users.requires_approval")
                        ? __(
                            "exceptions.frontend.auth.confirmation.created_pending"
                        )
                        : __(
                            "exceptions.frontend.auth.confirmation.created_confirm"
                        )
                )->with('user_id', $user->id);
            } else {
                // return redirect('thank-you');
                //return view('frontend.auth.thank-you');
                auth()->login($user);
                return redirect($this->redirectPath());
            }
        }
    }

    /**
     * This function is used to check Email exit in database or not.
     **/
    public function getUsersEmail(Request $request)
    {
        $key = config("settings.EMAIL_QUALITY_SCORE");
        $EMAIL_QUALITY_URL = config("settings.EMAIL_QUALITY_URL");
        $email = $request->input("email", false);
        //Code Added By Ramesh [02-03-2025]
        $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
        if (!empty($check_affiliate_cookie)) {
            $cookie_data = json_decode($check_affiliate_cookie);
            $cid = isset($cookie_data->cid) ? $cookie_data->cid : '';
            $aff_sub1 = isset($cookie_data->aff_sub1) ? $cookie_data->aff_sub1 : '';
            $utm_source = isset($cookie_data->utm_source) ? $cookie_data->utm_source : '';
            DB::table('affiliate_user_activities')->insert(
                ['medium' => $utm_source, 'cid' => $cid, 'sjid' => $aff_sub1, 'log' => 'Email: ' . $email, 'country' => '', 'campaign_type' => 'doi_campaign', 'created_at' => date("Y-m-d h:i:s")]
            );
        }
        //End Here 
        //$is_email = User::where('email',$email)->count();
        $is_email = User::where("email_hash", sha1(strtolower($email)))->count(); // strtolower added by Vikas
        //Code Added By Ramesh [02-03-2025]
        $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
        if (!empty($check_affiliate_cookie)) {
            $cookie_data = json_decode($check_affiliate_cookie);
            $cid = isset($cookie_data->cid) ? $cookie_data->cid : '';
            $aff_sub1 = isset($cookie_data->aff_sub1) ? $cookie_data->aff_sub1 : '';
            $medium = isset($cookie_data->utm_source) ? $cookie_data->utm_source : '';
            DB::table('affiliate_user_activities')->insert(
                ['medium' => $medium, 'cid' => $cid, 'sjid' => $aff_sub1, 'log' => 'Email: ' . $email, 'country' => '', 'campaign_type' => 'doi_campaign', 'created_at' => date("Y-m-d h:i:s")]
            );
        }
        //End Here 
        return json_decode($is_email);
        //code Added By Ramesh Kamboj//
        /*
         * Set the maximum number of seconds to wait for a reply
         * from an email service provider. If speed is not a concern
         * or you want higher accuracy we recommend setting this in
         * the 20 - 40 second range in some cases. Any results which
         * experience a connection timeout will return the "timed_out"
         * variable as true. Default value is 7 seconds.
         */
        $timeout = 1;

        /*
         * If speed is your major concern set this to true,
         * but results will be less accurate.
         */
        $fast = "false";
        /*
         * Adjusts abusive email patterns and detection rates
         * higher levels may cause false-positives (0-2)
         */
        $abuse_strictness = 0;

        if ($is_email == 0) {
            // Create parameters array.
            $parameters = [
                "timeout" => $timeout,
                "fast" => $fast,
                "abuse_strictness" => $abuse_strictness,
            ];
            // Format our parameters.
            $formatted_parameters = http_build_query($parameters);
            $url = sprintf(
                $EMAIL_QUALITY_URL . "/%s/%s?%s",
                $key,
                urlencode($email),
                $formatted_parameters
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

            $json = curl_exec($curl);
            curl_close($curl);

            // Decode the result into an array.
            $result = json_decode($json, true);

            if (isset($result["success"]) && $result["success"] === true) {
                if (
                    $result["recent_abuse"] === false &&
                    ($result["valid"] === true ||
                        ($result["timed_out"] === true &&
                            $result["disposable"] === false &&
                            $result["dns_valid"] === true))
                ) {
                    return "0";
                } else {
                    return "2";
                }
            }
        } else {
            return $is_email;
        }
        //End Here//
    }

    /**
     * This function is used to register new user and if the user is from invite links than invite details will be updated in user additional data
     * and than registration of this user will be done.
     *
     * @param RegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */
    public function register(Request $request)
    {
        // echo"<pre>";
        // print_r($request->all());
        // exit;

        abort_unless(config("access.registration"), 404);

        //$geoip = geoip(request()->ip());
        $con = $request->input("country", false);
        if ($con == "US") {
            $ip = "206.223.192.11";
            $geoip = geoip($ip);
        } else {
            $geoip = geoip(request()->ip());
        }
        $current_ip = $geoip->getAttribute("ip");
        //$this->checkProxy($request);
        //$this->ipDClassCheck($current_ip);
        $input = $request->only("dob");
        $date = Carbon::parse($input["dob"])->format("Y-m-d");
        $request->merge(["dob" => $date]);
        $lang = $request->input("language", false);

        /*
         * Check Selected Country with Geo Location Check- Starts
         * Get Client's country and lattitue/longitue from there IP and validate with User's
         * Provided country
         */
        $ipcountryCode = $geoip->getAttribute("iso_code");
        /*$lat = $geoip->getAttribute('lat');
         $lon = $geoip->getAttribute('lon');*/

        if ($con && $con != $ipcountryCode) {
            throw ValidationException::withMessages([
                $con => [trans("auth.countryLocationFraud")],
            ]);
            return false;
        }
        /* Check Selected Country with Geo Location Check- Ends */

        /*$sjtest = "";
        if($request->hasCookie('sjtest')){
            $sjtest = Cookie::get('sjtest');
        }*/

        // print_r('test data1');die;
        $unique_ip_check = setting()->get("unique_ip_check");

        //$current_ip = $geoip; //$request->ip();
        //$users_data = User::all()->toArray();
        /*$ip_matched = false;
        $row = [];
        if(file_exists(resource_path().DIRECTORY_SEPARATOR."blacklisted_ips".DIRECTORY_SEPARATOR."blacklisted_ips.csv")){
            $link_file = fopen(resource_path().DIRECTORY_SEPARATOR."blacklisted_ips".DIRECTORY_SEPARATOR."blacklisted_ips.csv",'r');
            while (($line = fgetcsv($link_file)) !== FALSE) {
                $row[] = $line;
            }
            unset($row[0]);
        }
        $ip_array = array_values($row);
        $blacklisted_ips = [];
        foreach($ip_array as $val){
            $blacklisted_ips[] = $val[0];
        }*/
        /*if($sjtest==0 || $sjtest==""){
            foreach ($users_data as $index=>$value){
                if($value['last_login_ip'] == $current_ip || in_array($current_ip,$blacklisted_ips)){
                    $ip_matched = true;
                }
            }
            if($unique_ip_check && $ip_matched){
                return view('frontend.index')
                    ->withErrors(__('frontend.register.static.messages.ip_check'));
            }
        }*/
        // code changes for email_hash by vikash(20-12-2022)
        $locales = [
            "locale" => strtolower($lang) . "_" . $con,
            "email_hash" => sha1($request->email),
        ];

        $register_input_data = $request->only(
            "first_name",
            "middle_name",
            "last_name",
            "email",
            "password",
            "gender",
            "consent",
            "dob",
            "country"
        );
        $updated_register_data = array_merge($register_input_data, $locales);
        //print_r($updated_register_data);die;
        $user = $this->userRepository->create($updated_register_data);
        // $check_invite_cookie = $this->userRepository->checkInviteCookieCode();
        //  $METHOD_TYPE = \Cookie::get('SJ_SECURE_METHOD_TYPE');
        //  $REFER_CODE = \Cookie::get('SJ_SECURE_REF_CODE');
        //  echo "<pre>";
        //  print_r($METHOD_TYPE.' '.$REFER_CODE); die();

        event(new UserRegistered($user, $register_input_data));
        // if($check_invite_cookie){
        //     $this->userRepository->giveUserInvitePoints($check_invite_cookie,$user,$REFER_CODE,$METHOD_TYPE);
        //     //Add code by vikash (29-11-2022)
        //     $this->userRepository->giveUserReferralPoints($check_invite_cookie,$user,$REFER_CODE,$METHOD_TYPE);
        // }
        session()->put("last_active", time());
        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (
            config("access.users.confirm_email") ||
            config("access.users.requires_approval")
        ) {
            activity()
                ->causedBy($user)
                ->log("inpanel.activity_log.registration");
            return view(
                "frontend.auth.confirmation_sent_page"
            )->withFlashSuccess(
                config("access.users.requires_approval")
                    ? __(
                        "exceptions.frontend.auth.confirmation.created_pending"
                    )
                    : __(
                        "exceptions.frontend.auth.confirmation.created_confirm"
                    )
            );
        } else {
            auth()->login($user);
            return redirect($this->redirectPath());
        }
    }

    /**
     * Attempt to check the client's proxy, vpn or tor network
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function checkProxy(Request $request)
    {
        $key = "Jaxm7e3Msbmj74a19Uay0ZI0uhws4p7H";
        $ip = isset($_SERVER["REMOTE_ADDR"])
            ? $_SERVER["REMOTE_ADDR"]
            : $_SERVER["HTTP_CLIENT_IP"];

        $strictness = 1;
        $result = json_decode(
            file_get_contents(
                sprintf(
                    "https://ipqualityscore.com/api/json/ip/%s/%s?strictness=%s",
                    $key,
                    $ip,
                    $strictness
                )
            ),
            true
        );

        // Remove $ip condition from below on production
        if ($result !== null && $ip != "127.0.0.1") {
            if ($result["vpn"] || $result["tor"]) {
                //exit("Please disable your proxy connection!");
                throw ValidationException::withMessages([
                    $request->first_name => [trans("auth.proxyFraud")],
                ]);
            }
        }
        return true;
    }

    /**
     * Attempt to check the similar Ip's D class check
     *
     * @return bool
     */
    protected function ipDClassCheck($ip)
    {
        $abcClass = substr($ip, 0, strrpos($ip, "."));
        $Dclass = substr($ip, strrpos($ip, ".") + 1);
        $repeatIPCnt = "";
        $info = DB::select("SELECT SUBSTRING_INDEX(ip_registered_with, '.', 3) AS abc_Class 
            ,COUNT(SUBSTRING_INDEX(ip_registered_with, '.', 3)) AS abc_Class_cnt 
            ,group_concat(id)
            ,group_concat(ip_registered_with)
            FROM users
            WHERE deleted_at IS NULL
            AND SUBSTRING_INDEX(ip_registered_with, '.', 3) = '$abcClass'
            AND SUBSTRING_INDEX(ip_registered_with, '.', -1) != '$Dclass'
            GROUP BY SUBSTRING_INDEX(ip_registered_with, '.', 3) ");

        $uniqueIpCheck = DB::select(
            "SELECT COUNT(id) AS cnt FROM users WHERE ip_registered_with = '$ip' "
        )[0];

        if (isset($info[0])) {
            $repeatIPCnt = $info[0]->abc_Class_cnt;
            if ($repeatIPCnt >= 2) {
                throw ValidationException::withMessages([
                    $ip . "-Dclass-fraud" => [
                        trans("auth.repeatedIPFraudRegister"),
                    ],
                ]);
            }
        }
        if ($uniqueIpCheck->cnt > 0) {
            throw ValidationException::withMessages([
                $ip . "-unique-ip-fraud" => [
                    trans("auth.repeatedIPFraudRegister"),
                ],
            ]);
        }

        return true;
    }

    /**
     * Shows the application consentual information page that redirects a user to registration page of promo.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function showPromoConsentPage(Request $request)
    {
        $request_data = $request->query();

        return view("frontend.auth.promo_consent");
        /* ->withSocialiteLinks((new Socialite)->getSocialLinks())
            ->withCurrentCountry($ipcountryCode)
            ->withCountries($countries)
            ->with('con_code',$country_code)
            ->with('lang_code',$lang_code);*/
    }

    /**
     * Show the application registration form that are redirected by Promo Landing and saving the affiliate_data.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function showPromoRegistrationForm(Request $request)
    {
        $geodata = geoip(request()->ip()); //geoip(request()->ip());

        $request_data = $request->query();
        $country_code = $request->input("con", $geodata->iso_code);
        $lang_code = $request->input("lang", false);
        $user_group = $request->input("user_group", false);
        Cookie::queue("user_group", $user_group);
        $cookie_data = $request->only([
            "utm_campaign",
            "utm_source",
            "utm_medium",
            "utm_content",
        ]);
        if (!empty($cookie_data) && !empty($cookie_data["utm_source"])) {
            $aff = AffiliateList::where(
                "code",
                "=",
                $cookie_data["utm_source"]
            )->first(["aff_vars"]);
            $aff_vars = explode(",", $aff->aff_vars);
            $varsData = $request->only($aff_vars);
            $cookie_data = array_merge($cookie_data, $varsData);
        }
        Cookie::queue("affiliate_data", json_encode($cookie_data));
        abort_unless(config("access.registration"), 404);
        $geodata = geoip(request()->ip());

        $ipcountryCode = $geodata->getAttribute("iso_code");
        /*Todo for $countries as withTranslation() function is not working*/
        $countries = $this->generalRepository->getActiveCountries();
        return view("frontend.auth.promo_register")
            ->withSocialiteLinks((new Socialite())->getSocialLinks())
            ->withCurrentCountry($ipcountryCode)
            ->withCountries($countries)
            ->with("con_code", $country_code)
            ->with("lang_code", $lang_code);
    }

    /**
     * Registration for Promo Landing Users.
     *
     * @param PromoRegisterRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Throwable
     */

    public function postPromoRegister(PromoRegisterRequest $request)
    {
        abort_unless(config("access.registration"), 404);
        $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
        $lang = $request->input("language", false);
        $con = $request->input("country", false);
        $locales = [
            "locale" => strtolower($lang) . "_" . $con,
        ];
        $register_input_data = $request->only(
            "first_name",
            "last_name",
            "email",
            "consent",
            "password",
            "country"
        );
        if ($request->hasCookie("user_group")) {
            $user_group = Cookie::get("user_group");
            $register_input_data["user_group"] = $user_group;
        }
        $updated_register_data = array_merge($register_input_data, $locales);
        $user = $this->userRepository->create($updated_register_data);
        $check_invite_cookie = $this->userRepository->checkInviteCookieCode();
        if ($check_invite_cookie) {
            $this->userRepository->giveUserInvitePoints(
                $check_invite_cookie,
                $user,
                $REFER_CODE,
                $METHOD_TYPE
            );
        }
        if (!empty($check_affiliate_cookie)) {
            $cookie_data = json_decode($check_affiliate_cookie);
            $this->userRepository->createAffiliateCampData($cookie_data, $user);
        }
        event(new UserRegistered($user, $updated_register_data));
        // If the user must confirm their email or their account requires approval,
        // create the account but don't log them in.
        if (
            config("access.users.confirm_email") ||
            config("access.users.requires_approval")
        ) {
            activity()
                ->causedBy($user)
                ->log("inpanel.activity_log.registration");
            return view(
                "frontend.auth.confirmation_sent_page"
            )->withFlashSuccess(
                config("access.users.requires_approval")
                    ? __(
                        "exceptions.frontend.auth.confirmation.created_pending"
                    )
                    : __(
                        "exceptions.frontend.auth.confirmation.created_confirm"
                    )
            );
        } else {
            auth()->login($user);
            return redirect($this->redirectPath());
        }
    }

    public function getCountryLanguage(Request $request)
    {
        $country_code = $request->country_code;
        $language = $this->userRepository->getCountry($country_code);
        return response()->json($language);
    }

    public function complete2FARegister(Request $request)
    {
        $user = $request->user;
        $request->merge(session("registration_data"));

        // Call the default laravel authentication

        return $this->registerTwoFactorAuth($user, $request);
    }

    private function registerTwoFactorAuth($user, $data)
    {
        $user->google2fa_secret = $data->google2fa_secret;
        $user->save();
        return redirect()
            ->route("frontend.auth.logout")
            ->withFlashSuccess(
                "Successfully updated Two Factor Authentication"
            );
    }

    public function postDfiqData(Request $request)
    {
        if ($request->ajax()) {
            $DFIQJSONData = $request->get("datajsondata")["forensic"];
            $requestId = $DFIQJSONData["requestId"];
            $deviceId = $DFIQJSONData["deviceId"];
            //property//
            /*$deviceType=$DFIQJSONData['property']['deviceType'];
                $isMobile=$DFIQJSONData['property']['isMobile'];
                $os=$DFIQJSONData['property']['os'];
                $platform=$DFIQJSONData['property']['platform'];
                $browser=$DFIQJSONData['property']['browser'];
                $hardwareName=$DFIQJSONData['property']['hardwareName'];
                $hardwareModel=$DFIQJSONData['property']['hardwareModel'];
                $hardwareVendor=$DFIQJSONData['property']['hardwareVendor'];
                $ipAddress=$DFIQJSONData['property']['ipAddress'];
                $domain=$DFIQJSONData['property']['domain'];
                //END Here//
                //frequency//
                $isEventUnique=$DFIQJSONData['unique']['isEventUnique'];
                $eventDupeId=$DFIQJSONData['unique']['eventDupeId'];
                $eventDupeDate=$DFIQJSONData['unique']['eventDupeDate'];
                $eventDupeReason=$DFIQJSONData['unique']['eventDupeReason'];
                //marker
                 $score=$DFIQJSONData['marker']['score'];
                 $invalidCount=$DFIQJSONData['marker']['invalidCount'];
                 $invalidLowCount=$DFIQJSONData['marker']['invalidLowCount'];
                 $invalidMediumCount=$DFIQJSONData['marker']['invalidMediumCount'];
                 $invalidHighCount=$DFIQJSONData['marker']['invalidHighCount'];
                 $invalidCriticalCount=$DFIQJSONData['marker']['invalidCriticalCount'];
                 $isKnownBrowser=$DFIQJSONData['marker']['isKnownBrowser'];
                 $isObsoleteBrowser=$DFIQJSONData['marker']['isObsoleteBrowser'];
                 $isKnownOs=$DFIQJSONData['marker']['isKnownOs'];
                 $isObsoleteOs=$DFIQJSONData['marker']['isObsoleteOs'];
                 $isKnownDeviceType=$DFIQJSONData['marker']['isKnownDeviceType'];
                 $isKnownUserAgent=$DFIQJSONData['marker']['isKnownUserAgent'];
                 $isKnownDomain=$DFIQJSONData['marker']['isKnownDomain'];
                 $isBot=$DFIQJSONData['marker']['isBot'];
                 $isBlacklisted=$DFIQJSONData['marker']['isBlacklisted'];
                 $isWhitelisted=$DFIQJSONData['marker']['isWhitelisted'];
                 $isAnonymous=$DFIQJSONData['marker']['isAnonymous'];
                 $anonymousReason=$DFIQJSONData['marker']['anonymousReason'][0];
                 $isTampered=$DFIQJSONData['marker']['isTampered'];
                 $isResist=$DFIQJSONData['marker']['isResist'];
                 $isVelocity=$DFIQJSONData['marker']['isVelocity'];
                 $isOscillating=$DFIQJSONData['marker']['isOscillating'];
                 $isBehavioral=$DFIQJSONData['marker']['isBehavioral'];
                 $isLang=$DFIQJSONData['marker']['isLang'];
                 $isGeoLang=$DFIQJSONData['marker']['isGeoLang'];
                 $isGeoOsLang=$DFIQJSONData['marker']['isGeoOsLang'];
                 $isGeoPostal=$DFIQJSONData['marker']['isGeoPostal'];
                 $isGeoCountry=$DFIQJSONData['marker']['isGeoCountry'];
                 $isGeoTz=$DFIQJSONData['marker']['isGeoTz'];
                 //geo
                 $city=$DFIQJSONData['geo']['city'];
                 $stateProvince=$DFIQJSONData['geo']['stateProvince'];
                 $countryCode=$DFIQJSONData['geo']['countryCode'];*/
            //JSon Format//
            $geo_json = json_encode($DFIQJSONData["geo"]);
            $marker_json = json_encode($DFIQJSONData["marker"]);
            $unique_json = json_encode($DFIQJSONData["unique"]);
            $property_json = json_encode($DFIQJSONData["property"]);
            //End Here//

            $rId = $DFIQJSONData["rId"];
            $SjDfiqApiResponse = new SjDfiqApiResponse();
            $SjDfiqApiResponse->requestId = $requestId;
            $SjDfiqApiResponse->deviceId = $deviceId;
            $SjDfiqApiResponse->property = $property_json;
            $SjDfiqApiResponse->unique_ip = $unique_json;
            $SjDfiqApiResponse->marker = $marker_json;
            $SjDfiqApiResponse->geo = $geo_json;
            $SjDfiqApiResponse->rId = $rId;
            $SjDfiqApiResponse->email = $request->get("email");
            $SjDfiqApiResponse->ip_address = $request->get("ip_address");
            $SjDfiqApiResponse->panelistId = $request->get("panelistId");
            $SjDfiqApiResponse->save();

            //Code Added By Ramesh [02-03-2025]

            $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
            if (!empty($check_affiliate_cookie)) {
                $cookie_data = json_decode($check_affiliate_cookie);
                DB::table('affiliate_user_activities')->insert(
                    ['medium' => $cookie_data->utm_source, 'cid' => @$cookie_data->cid, 'sjid' => $cookie_data->aff_sub1, 'log' => 'Affiliate DFIQ Check ', 'country' => '', 'campaign_type' => 'doi_campaign', 'created_at' => date("Y-m-d h:i:s")]
                );
            } //End Here

        }
        return Response::json([
            "success" => true,
            "data" => "1",
        ]);
    }
    //End Here//

    public function redirectToFacebook()
    {
        return SocialiteFacebook::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $facebookUser = SocialiteFacebook::driver('facebook')->user();

            $user_email = $facebookUser->getEmail() ?: "{$facebookUser->getId()}@facebook.com";
            $user_email_hash = sha1(trim($user_email));

            $user = User::where('email_hash', $user_email_hash)->first();
            $geodata = geoip(request()->ip());

            $ipcountryCode = $geodata->getAttribute('iso_code');
            $country = $geodata->getAttribute('country');

            if (!$user) {
                // Check if registration is enabled
                if (!config('access.registration')) {
                    throw new GeneralException(__('exceptions.frontend.auth.registration_disabled'));
                }

                // Extract first and last name
                $nameParts = $this->userRepository->getNameParts($facebookUser->getName());

                // Check for affiliate cookie data
                $check_affiliate_cookie = $this->userRepository->checkAffiliateCookie();
                if (!empty($check_affiliate_cookie)) {
                    $cookie_data = json_decode($check_affiliate_cookie);
                    $this->userRepository->createAffiliateCampData($cookie_data, $user);
                }

                $RecordCnt = $this->userRepository->getRecordsCountForCurrentDay();
                if (strlen($RecordCnt) >= 4 && $RecordCnt >= 9999) {
                    $RCnt = $RecordCnt + 1;
                    $panId = date('ymds') . $RCnt;
                } else {
                    $panId = date('ymds') . str_pad($RecordCnt + 1, 4, "0", STR_PAD_LEFT);
                }
                if ($ipcountryCode == 'US') {
                    $locale = "en_US";
                }
                if ($ipcountryCode == 'CA') {
                    $locale = "en_CA";
                }
                if ($ipcountryCode == 'IN') {
                    $locale = "en_IN";
                }
                if ($ipcountryCode == 'UK' || $ipcountryCode == 'GB') {
                    $locale = "en_UK";
                    $ipcountryCode = 'UK';
                }

                $user = User::create([
                    'panellist_id' => $panId,
                    'first_name' => $nameParts['first_name'],
                    'last_name' => $nameParts['last_name'],
                    'email' => $user_email,
                    'social_email' => $user_email,
                    'email_hash' => $user_email_hash,
                    'active' => 1,
                    'locale' => $locale,
                    'confirmed' => 0,
                    'password' => null,
                    'avatar_type' => 'facebook',
                    'is_social' => 1,
                    'country' => $ipcountryCode,
                    'country_code' => $ipcountryCode,
                ]);

                if ($user) {
                    $user->assignRole(config('access.users.default_role'));
                }

                event(new UserProviderRegistered($user));
                event(new UserConfirmed($user));
                activity()
                    ->causedBy($user)
                    ->log('inpanel.activity_log.user_confirm');
            }

            if (!$user->hasProvider('facebook')) {
                $user->providers()->save(new SocialAccount([
                    'provider' => 'facebook',
                    'provider_id' => $facebookUser->getId(),
                    'token' => $facebookUser->token,
                    'avatar' => $facebookUser->avatar,
                ]));
            } else {
                $user->providers()->update([
                    'token' => $facebookUser->token,
                    'avatar' => $facebookUser->avatar,
                ]);

                $user->avatar_type = 'facebook';
                $user->update();
            }

            \Log::info("User logged in via Facebook: " . $user->social_email);

            Auth::login($user);

            return redirect('/home'); // Redirect after login

        } catch (\Exception $e) {
            \Log::error("Facebook login error: " . $e->getMessage());
            return redirect('/login')->with('error', 'Something went wrong');
        }
    }

    private function savePanellistAddress($panellistData = null)
    {
        try {
            PanellistAddress::firstOrCreate(
                ['user_id' => $panellistData['user_id']],
                $panellistData
            );
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }
    }

    function getStateFromZipCode($zipcode, $country, $panellist_id, $stateToRegionMapping = [])
    {

        if (!$stateToRegionMapping) {

            $stateToRegionMapping = [
                // Northeast
                "CT" => "Northeast",
                "ME" => "Northeast",
                "MA" => "Northeast",
                "NH" => "Northeast",
                "RI" => "Northeast",
                "VT" => "Northeast",
                "NJ" => "Northeast",
                "NY" => "Northeast",
                "PA" => "Northeast",
                "DE" => "Northeast", // Delaware
                "MD" => "Northeast", // Maryland
                "DC" => "Northeast", // District of Columbia
                "WV" => "Northeast", // West Virginia

                // South
                "VA" => "South",
                "NC" => "South",
                "SC" => "South",
                "GA" => "South",
                "FL" => "South",
                "AL" => "South",
                "MS" => "South",
                "TN" => "South",
                "KY" => "South",
                "LA" => "South",
                "AR" => "South",
                "OK" => "South",
                "TX" => "South",

                // Midwest
                "OH" => "Midwest",
                "MI" => "Midwest",
                "IN" => "Midwest",
                "IL" => "Midwest",
                "WI" => "Midwest",
                "MN" => "Midwest",
                "IA" => "Midwest",
                "MO" => "Midwest",
                "KS" => "Midwest",
                "NE" => "Midwest",
                "SD" => "Midwest",
                "ND" => "Midwest",

                // West
                "WA" => "West",
                "OR" => "West",
                "CA" => "West",
                "NV" => "West",
                "ID" => "West",
                "MT" => "West",
                "WY" => "West",
                "CO" => "West",
                "UT" => "West",
                "AZ" => "West",
                "NM" => "West",
                "AK" => "West",
                "HI" => "West",

                // India
                /*"AP" => "India",
                "AR" => "India",
                "AS" => "India",
                "BR" => "India",
                "CG" => "India",
                "GA" => "India",
                "GJ" => "India",
                "HR" => "South West",
                "GJ" => "West",
                "GJ" => "India",
                "DL" => "North",
                "WB" => "East" ,
                "CH" => "North",*/
            ];
        }

        $country_code = '';
        switch ($country) {
            case 'US':
                $country_code = 'US';
                break;
            case 'IN':
                $country_code = 'IN';
                break;
            case 'CA':
                $country_code = 'CA';
                break;
            default:
                $country_code = 'US'; // Default 
        }

        $url = "https://api.zippopotam.us/{$country_code}/{$zipcode}";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if ($response === false) {
            return null;
        }

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code !== 200) {
            return null;
        }

        $data = json_decode($response, true);

        if (isset($data['places'][0])) {
            $state = $data['places'][0]['state'];
            $city = $data['places'][0]['place name'];

            $stateAbbreviation = $data['places'][0]['state abbreviation'];
            $region = $stateToRegionMapping[$stateAbbreviation] ?? '-';
            return [$state, $city, $region];
        } else {
            return null;
        }

        curl_close($ch);
    }

    public function resendConfirmationMail(Request $request)
    {
        try {
            $user_id = $request['user_id'];
            $user = User::where('id', $user_id)->first();
            $get_reffer_point = Setting::whereIn("key", [
                "PANEL_SIGNUP_POINTS",
                "PANEL_ACCOUNT_ACTIVATION_POINTS",
                "PANEL_BASIC_PROFILE_POINTS",
            ])->sum("value");
            Mail::to($user->email)->send(new UserConfirmation(
                $user,
                $user->confirmation_code,
                $get_reffer_point,

                0
            ));

            return response()->json(['message' => __('frontend.index.contact_us.resend_email_sent')]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => __('frontend.index.contact_us.failed_resend_confirmation_mail'),
                'error' => $e->getMessage()
            ], 500);
        }
    }

      /**functions added by Anil for track user */

    public function appEmailTemplate(Request $request)
    {
        return view("frontend.auth.appEmailTemplate");
    }

    public function sendToPlatform(Request $request, $platform)
    {
        $ip = $request->ip();
        $geodata = geoip($ip);

 
        $ipcountryCode = $geodata->getAttribute('iso_code');
        $countryName = $geodata->getAttribute('country');
        $name = $request->query('name');
        // Adjust GB → UK
        if ($ipcountryCode == 'GB') {
            $ipcountryCode = 'UK';
        }
 
        $allowedCountries = ['US', 'UK', 'CA', 'IN', 'GB'];
 

        if (!in_array($ipcountryCode, $allowedCountries)) {
            return response()->json([
                'message' => "Your country is not allowed to access the {$platform} store."
            ], 403);
        }

        // Map platform to URLs
        $urls = [
            'android' => 'https://play.google.com/store/apps/details?id=com.sjpanel',
            'ios'     => 'https://apps.apple.com/us/app/sj-panel/id6743372465',
            'web'     => 'https://www.sjpanel.com/register',
        ];
 

        // Store log
        EmailRegisterLog::updateOrCreate(
            [
                'user_ip' => $ip,
            ],
            [
                'country_code' => $ipcountryCode,
                'country_name' => $countryName,
                'user_agent'   => $request->header('User-Agent'),
                'platform'     => $platform,
                'affiliate'    => $name,
            ]
        );
        return redirect()->away($urls[$platform] ?? '/');
    }
}
