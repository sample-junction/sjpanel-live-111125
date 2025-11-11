<?php

namespace App\Http\Controllers\Api\mobileAPI;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\App;
use App\Models\Auth\User;
use App\Events\Frontend\Auth\UserRegistered;
use App\Repositories\Frontend\Auth\UserRepository;
use Carbon\Carbon;
use App\Mail\Frontend\UserConfirm\UserConfirmation;
use App\Models\Setting\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use App\Models\Auth\UserEmailOtp;
use App\Mail\mobileMails\forgetOtpMail;
use App\Models\mobileAPI\UserToken;
use App\Models\mobileAPI\deviceHistory;
use Illuminate\Support\Str;
use App\Mail\Inpanel\User\TwoDisableMail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use CustomLogger;
use App\Models\Profiler\UserAdditionalData;




class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;
    /*   protected string $dfiqApiKey = '29109E607D0B6E11DE0B966F50EA617A-5004-1';
    protected string $dfiqApiUrl = 'https://api.dfiq.net/'; */

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Author: Anil
     * Register new user.
     * Table Used:Users
     */
    public function register(Request $request)
    {
        $countryLang = !empty($request['lang']) ? strtolower(trim($request['lang'])) . '_' . trim($request["countryName"]) : "en_US";
        if (!empty($countryLang)) {
            App::setLocale($countryLang);
        }
        $genderOptions = [
            'male',
            'female',
            'पुरुष',
            'महिला',
            'homme',
            'femme',
            'hombre',
            'mujer'
        ];

        $validator = Validator::make($request->all(), [
            // In first name and last name validation min. character change 3 to 2 (Code Added by Vikas)
            'firstname' => ['required', 'string', 'min:2', 'max:100', 'regex:/^(?!.*(.)\1{2})[A-Za-z\s]+$/'],
            'lastname' => ['required', 'string', 'min:2', 'max:100', 'regex:/^(?!.*(.)\1{2})[A-Za-z\s]+$/'],
            'zip' => ['required', 'string', 'regex:/^[A-Za-z\d\s]+$/'],
            'gender' => 'required|string|in:' . implode(',', $genderOptions),
            'dob' => 'required|date_format:Y-m-d',
            'email' => 'required|string|email|max:255',
            'countryName' => 'required|string|in:US,IN,AU,CA,UK',
            'lang' => 'required|string|in:hi,en,fr,es',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:20',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
            ],
        ], [
            /* First Name Validation start*/
            'firstname.required' => __('validation.mobileAPI.firstname.required'),
            'firstname.string' => __('validation.mobileAPI.firstname.string'),
            'firstname.min' => __('validation.mobileAPI.firstname.min'),
            'firstname.max' => __('validation.mobileAPI.firstname.max'),
            'firstname.regex' => __('validation.mobileAPI.firstname.specialCharacter'),
            /* First Name Validation End*/

            /* Last Name Validation start*/
            'lastname.required' => __('validation.mobileAPI.lastname.required'),
            'lastname.string' => __('validation.mobileAPI.lastname.string'),
            'lastname.min' => __('validation.mobileAPI.lastname.min'),
            'lastname.max' => __('validation.mobileAPI.lastname.max'),
            'lastname.regex' => __('validation.mobileAPI.lastname.specialCharacter'),
            /* Last Name Validation End*/

            /* Gender Validation start*/
            'gender.required' => __('validation.mobileAPI.gender.required'),
            /* Gender Validation End*/

            /* country Validation start*/
            'countryName.required' => __('validation.mobileAPI.countryName.required'),
            'countryName.string' => __('validation.mobileAPI.countryName.string'),
            /* country Validation End*/

            /* Date of Birth Validation start*/
            'dob.required' => __('validation.mobileAPI.date.required'),
            'dob.date_format' => __('validation.mobileAPI.date.format'),
            /* Date of Birth Validation End*/

            /* ZIP Validation start*/
            'zip.required' => __('validation.mobileAPI.zip.required'),
            'zip.numeric' => __('validation.mobileAPI.zip.integer'),
            'zip.regex' => __('validation.mobileAPI.zip.regex'),
            /* ZIP Validation End*/

            /* Email Validation Start*/
            'email.required' => __('validation.mobileAPI.email.required'),
            'email.email' => __('validation.mobileAPI.email.email'),
            /* Email Validation End*/

            /* Password Validation Start*/
            'password.required' => __('validation.mobileAPI.password.required'),
            'password.confirmed' => __('validation.mobileAPI.password.confirmed'),
            'password.regex' => __('validation.mobileAPI.password.regex'),
            'password.min' => __('validation.mobileAPI.password.min'),
            'password.max' => __('validation.mobileAPI.password.max'),
            /* Password Validation End*/
        ]);
        if ($validator->fails()) {
            // Need same data type for error messages for mobile App
            $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
            return response()->json([
                'status' => false,
                'error' => $errorMessages,
            ], 422);
        } else {
            $country = $request['countryName'];

            $isEmailExist = $this->getUsersEmail($request);
            $isEmailExist = $isEmailExist->getData();

            if (!empty($isEmailExist) && $isEmailExist->type == 1) {
                return response()->json([
                    'status' => false,
                    'error' => __('validation.mobileAPI.email_exists'),
                ], 409);
            } elseif (!empty($isEmailExist) && $isEmailExist->type == 2) {
                return response()->json([
                    'status' => false,
                    'error' => "This is not a valid Email",
                ], 409);
            } else {
                $checkIP = $this->checkIPwithQUalityCheck($request);
                $checkIP = $checkIP->getData();

                // if ($checkIP->status === false) {
                //     return response()->json([
                //         'status' => false,
                //         'error' => "This is not a valid IP",
                //     ], 409);
                // }
                $dateOfBirth = Carbon::parse($request["dob"]);
                $age = $dateOfBirth->diffInYears(Carbon::now());
                $minAge = config("age_limits.$country", 18);
                if ($age < $minAge) {
                    return response()->json([
                        'status' => false,
                        'error' => __('validation.mobileAPI.age_restriction', [
                            'minAge' => $minAge,
                            'country' => $country
                        ]),

                    ], 422);
                }

                $RecordCnt = $this->userRepository->getRecordsCountForCurrentDay();
                $panId = "";
                if (strlen($RecordCnt) >= 4 && $RecordCnt >= 9999) {
                    $RCnt = $RecordCnt + 1;
                    $panId = date("ymds") . $RCnt;
                } else {
                    $panId =
                        date("ymds") . str_pad($RecordCnt + 1, 4, "0", STR_PAD_LEFT);
                }
                $newUser = User::create([
                    "panellist_id" => $panId,
                    "first_name" => $request["firstname"],
                    "last_name" => $request["lastname"],
                    "middle_name" => "",
                    "email" => strtolower($request["email"]),
                    "email_hash" => sha1(strtolower($request["email"])),
                    "confirmation_code" => md5(uniqid(mt_rand(), true)),
                    "active" => 1,
                    "password" => $request["password"],
                    "dob" => $request['dob'],
                    "gender" => !empty($request["gender"]) ? $request["gender"] : null,
                    "country" => trim($request["countryName"]),
                    "locale" => $countryLang,
                    "profile_updatetoken" => 0,
                    "zipcode" => $request["zip"],
                    "ip_registered_with" => $request["ip"],
                    "confirmed" => config("access.users.requires_approval") || config("access.users.confirm_email") ? 0 : 1,
                ]);
                if ($newUser) {
                    $register_input_data = $request->only(
                        "firstname",
                        "lastname",
                        "email",
                        "password",
                        "gender",
                        "dob",
                        "countryName"
                    );
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
                            $newUser->assignRole(
                                config("access.users.test_penalist_role")
                            );
                        } else {
                            $newUser->assignRole(config("access.users.default_role"));
                        }
                    }
                    event(new UserRegistered($newUser, $register_input_data));
                    if (config("access.users.confirm_email")) {
                        $get_unsubscribe_details = $newUser->checkUnsubscribedEmail(
                            $newUser->email
                        );
                        $get_reffer_point = Setting::whereIn("key", [
                            "PANEL_SIGNUP_POINTS",
                            "PANEL_ACCOUNT_ACTIVATION_POINTS",
                            "PANEL_BASIC_PROFILE_POINTS",
                        ])->sum("value");

                        if (!empty($get_unsubscribe_details)) {
                            $email = new UserConfirmation(
                                $newUser,
                                $newUser->confirmation_code,
                                $get_reffer_point,
                                0,
                                0,
                                1
                            );
                        } else {
                            $email = new UserConfirmation(
                                $newUser,
                                $newUser->confirmation_code,
                                $get_reffer_point,
                                0,
                                0,
                                1
                            );
                            // insert data into mongodb
                            $insertIntoMongo = $this->saveDataInMongo($newUser->id);
                            Mail::send($email);
                        }
                    }

                    return response()->json([
                        "status" => true,
                        'message' => __('validation.mobileAPI.email_verification'),
                    ], 201);
                }
            }
        }
    }

    /**
     * Author:Anil
     * Login user and return a token.
     * Table Used:User
     */
    public function login(Request $request)
    {
        $countryLang = !empty($request['lang']) ? strtolower(trim($request['lang'])) . '_' . trim($request["countryName"]) : "en_US";
        if (!empty($countryLang)) {
            App::setLocale($countryLang);
        }
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'device_name' => 'required',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/'
            ],
        ], [
            'email.required' => __('validation.mobileAPI.email.required'),
            'email.email' => __('validation.mobileAPI.email.email'),
            /* Email Validation End*/

            /* Password Validation Start*/
            'password.required' => __('validation.mobileAPI.password.required'),
            'password.string' => __('validation.mobileAPI.password.string'),
            'password.min' => __('validation.mobileAPI.password.min'),
            'password.regex' => __('validation.mobileAPI.password.regex'),
            /* Password Validation End*/

            'device_name' => __('validation.mobileAPI.device_name.required')
        ]);
        if ($validator->fails()) {
            $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
            return response()->json([
                'status' => 'error',
                'error' => $errorMessages,
            ], 422);
        } else {

            $isEmailExist = $this->verifyEmail($request['email']);
            if (!$isEmailExist) {
                return response()->json([
                    'status' => false,
                    'error' => __('validation.mobileAPI.userExist')
                ], 401);
            }

            $user = User::where('email_hash', sha1(strtolower($request->email)))->first();
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'error' => __('validation.mobileAPI.userExist'), // User does not exist
                ], 401);
            }

            // Check if the user is inactive
            if ($user->active != '1') {
                return response()->json([
                    'status' => false,
                    'error' => 'Your account is Inactive. Please Reach Our Support Team', // Custom message for inactive users
                ], 401);
            }

            // Check if the user is not confirmed
            if ($user->confirmed != '1') {
                return response()->json([
                    'status' => false,
                    'error' => __('validation.mobileAPI.account_not_confirmed'), // Custom message for unconfirmed users
                ], 401);
            } else {
                if (!Hash::check($request['password'], $user->password)) {
                    return response()->json(
                        [
                            'status' => false,
                            'error' => __('validation.mobileAPI.password.not_matched'),
                        ],
                        401
                    );
                } else {
                    if ($user->two_fact_auth == 1) {
                        try {
                            $otp = rand(100000, 999999);
                            $encrypt_otp = Crypt::encrypt($otp);

                            UserEmailOtp::updateOrCreate(
                                ['user_id' => $user->id],
                                ['otp' => $encrypt_otp]
                            );

                            Mail::to($user->email)->queue(new TwoDisableMail($user, $otp));

                            return response()->json([
                                'status' => true,
                                'is_2fa_required' => true,
                                'message' => __('validation.mobileAPI.otp_sent_success'),
                                'user_id' => $user->id,
                            ], 200);
                        } catch (\Exception $e) {
                            return response()->json([
                                'status' => false,
                                'error' => __('validation.mobileAPI.otp_send_failed'),
                            ], 422);
                        }
                    }

                    $deviceToken = (!empty($request->device_token)) ? $request->device_token : '';
                    $token = Str::random(60);
                    $userToken = UserToken::updateOrCreate(
                        ['token' => $token, 'device_name' => $request->device_name, 'device_token' => $deviceToken, 'device_type' => $request->device_type], // Condition to find existing entry
                        ['user_id' => $user->id]
                    );
                    if ($userToken) {
                        DeviceHistory::create([
                            'user_id' => $user->id,
                            'device_name' => $request->device_name,
                            'device_token' => $deviceToken,
                            'device_type' => $request->device_type,
                        ]);
                        if (!empty($user->image_url)) {
                            $imagePath = public_path('img') . "/" . $user->image_url;
                            $mimeType = File::mimeType($imagePath);
                            $imageData = base64_encode(File::get($imagePath));
                            $user->image_url = "data:$mimeType;base64,$imageData";
                        }
                        return response()->json([
                            "status" => true,
                            'user' => $user,
                            'token' => $token,
                            'message' => __('validation.mobileAPI.userLoggeIn'),
                        ], 200);
                    } else {
                        return response()->json([
                            "status" => false,
                            'error' => __('validation.mobileAPI.tokenFailed'),
                        ], 401);
                    }
                }
            }
        }
    }
    public function forgetPasswordOTP(Request $request)
    {
        $countryLang = !empty($request['lang']) ? strtolower(trim($request['lang'])) . '_' . trim($request["countryName"]) : "en_US";
        if (!empty($countryLang)) {
            App::setLocale($countryLang);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ], [
            'email.required' => __('validation.mobileAPI.email.required'),
            'email.email' => __('validation.mobileAPI.email.email'),
        ]);
        $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $errorMessages
            ], 422);
        }
        // Find the user by email_hash
        $isEmailExist = $this->verifyEmail($request['email']);
        if (!$isEmailExist) {
            return response()->json([
                'status' => false,
                'error' => __('validation.mobileAPI.userExist')
            ], 401);
        }
        $user = User::where('email_hash', sha1($request->email))->where('confirmed', '1')->where('active', '1')->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => __('validation.mobileAPI.account_in_process')
            ], 401);
        }
        $otp = rand(100000, 999999);
        $encrypt_otp = \Crypt::encrypt($otp);
        $insert_data = [
            'user_id' => $user->id,
            'otp' => $encrypt_otp,
        ];
        $save_user_email_otp = UserEmailOtp::create($insert_data);
        try {
            $email = new forgetOtpMail($user, $otp);
            Mail::send($email);
            return response()->json([
                'status' => true,
                'message' => __('validation.mobileAPI.otp_sent_success'),
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => __('validation.mobileAPI.otp_send_failed'),
            ], 500);
        }
    }
    public function verifyforgetOTP(Request $request)
    {
        $countryLang = !empty($request['lang']) ? strtolower(trim($request['lang'])) . '_' . trim($request["countryName"]) : "en_US";
        if (!empty($countryLang)) {
            App::setLocale($countryLang);
        }
        $validator = Validator::make(
            $request->all(),
            [
                'otp' => 'required|numeric',
                'user_id' => 'required|numeric',
            ],
            [
                'otp.required' => __('validation.mobileAPI.otp.required'),
                'otp.numeric' => __('validation.mobileAPI.otp.numeric'),
                'user_id.required' => __('validation.mobileAPI.user_id.required'),
                'user_id.numeric' => __('validation.mobileAPI.user_id.required'),
            ]
        );
        if ($validator->fails()) {
            $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
            return response()->json([
                'status' => 'error',
                'error' => $errorMessages,
            ], 422);
        }
        $user = UserEmailOtp::where('user_id', '=', $request['user_id'])->orderBy('updated_at', 'DESC')->first();
        $userOtpValue = \Crypt::decrypt($user->otp);
        if ($userOtpValue == $request['otp']) {
            return response()->json([
                'status' => true,
                'message' => __('validation.mobileAPI.otp_matched'),
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'error' => __('validation.mobileAPI.otp_not_matched'),
            ], 422);
        }
    }
    public function updatePassword(Request $request)
    {
        $countryLang = !empty($request['lang']) ? strtolower(trim($request['lang'])) . '_' . trim($request["countryName"]) : "en_US";
        if (!empty($countryLang)) {
            App::setLocale($countryLang);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one digit
                'regex:/[@$!%*?&]/' // At least one special character
            ],
        ], [
            /* Password Validation Start*/
            'user_id.required' => __('validation.mobileAPI.user_id.required'),
            'user_id.numeric' => __('validation.mobileAPI.user_id.numeric'),
            'password.required' => __('validation.mobileAPI.password.required'),
            'password.string' => __('validation.mobileAPI.password.string'),
            'password.min' => __('validation.mobileAPI.password.min'),
            'password.confirmed' => __('validation.mobileAPI.password.confirmed'),
            'password.regex' => __('validation.mobileAPI.password.regex'),
            /* Password Validation End*/
        ]);
        if ($validator->fails()) {
            $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
            return response()->json([
                'status' => false,
                'error' => $errorMessages,
            ], 422);
        }
        $user = User::where("id", $request['user_id'])->first();
        if (!$user) {
            return response()->json([
                'status' => false,
                'error' => __('validation.mobileAPI.userExist')
            ], 404);
        }

        if (Hash::check($request['password'], $user->password)) {
            return response()->json([
                'status' => false,
                'error' => __('validation.mobileAPI.password.old_password_not_allowed')
            ], 400);
        }
        $user->password = Hash::make($request['password']);
        $user->save();
        return response()->json([
            'status' => true,
            'message' => __('validation.mobileAPI.password.password_updated')
        ], 200);
    }
    public function verifyEmailExist(Request $request)
    {
        $countryLang = !empty($request['lang']) ? strtolower(trim($request['lang'])) . '_' . trim($request["countryName"]) : "en_US";
        if (!empty($countryLang)) {
            App::setLocale($countryLang);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
        ], [
            'email.required' => __('validation.mobileAPI.email.required'),
            'email.email' => __('validation.mobileAPI.email.email'),

        ]);
        if ($validator->fails()) {
            $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
            return response()->json([
                'status' => false,
                'error' => $errorMessages,
            ], 422);
        } else {
            $isEmailExist = $this->getUsersEmail($request);
            $isEmailExist = $isEmailExist->getData();

            if (!empty($isEmailExist) && $isEmailExist->type == 1) {
                return response()->json([
                    'status' => false,
                    'error' => __('validation.mobileAPI.email_exists'),
                ], 409);
            } elseif (!empty($isEmailExist) && $isEmailExist->type == 2) {
                return response()->json([
                    'status' => false,
                    'error' => "This is not a valid Email",
                ], 409);
            } else {
                return response()->json([
                    'status' => true,
                    'message' => __('validation.mobileAPI.email_valid'),
                ], 200);
            }
        }
    }
    public function verifyEmail($email)
    {
        $is_email = User::where("email_hash", sha1(strtolower($email)))->count();
        return json_decode($is_email);
    }
    public function logout(Request $request)
    {
        try {
            // Validate user_id input
            $validator = Validator::make($request->all(), [
                'user_id' => 'required|numeric',
            ], [
                'user_id.required' => __('validation.mobileAPI.user_id.required'),
                'user_id.numeric' => __('validation.mobileAPI.user_id.numeric'),
            ]);

            if ($validator->fails()) {
                $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
                return response()->json([
                    'status' => false,
                    'error' => $errorMessages,
                ], 422);
            }

            $user_id = $request->user_id;


            if ($user_id) {
                UserToken::where('user_id', $user_id)->delete();

                return response()->json([
                    'status' => true,
                    'message' => 'Successfully logged out'
                ], 200);
            }

            return response()->json([
                'status' => false,
                'message' => 'Token not found'
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong!',
            ], 500);
        }
    }

    // public function send2faOTP(Request $request)
    // {

    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'user_id' => 'required|numeric',
    //         ], [
    //             'user_id.required' => __('validation.mobileAPI.user_id.required'),
    //             'user_id.numeric' => __('validation.mobileAPI.user_id.numeric'),
    //         ]);
    //         $errorMessages = implode(', ', array_flatten($validator->errors()->toArray()));
    //         if ($validator->fails()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'error' => $errorMessages
    //             ], 422);
    //         }
    //         $user = User::where('id', $request->user_id)->where('confirmed', '1')->where('active', '1')->first();
    //         if (!$user) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'User not found.',
    //             ], 404);
    //         }

    //         $otp = rand(100000, 999999);
    //         $encrypt_otp = \Crypt::encrypt($otp);
    //         $insert_data = [
    //             'user_id' => $user->id,
    //             'otp' => $encrypt_otp,
    //         ];
    //         $save_user_email_otp = UserEmailOtp::create($insert_data);
    //         Mail::to($request->email)->send(new TwoDisableMail($user, $otp));
    //         return response()->json([
    //             'status' => true,
    //             'message' => __('validation.mobileAPI.otp_sent_success'),
    //         ], 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'error' => __('validation.mobileAPI.otp_send_failed'),
    //         ], 500);
    //     }
    // }
    public function otp2faConfirm(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'otp' => 'required|numeric',
            ], [
                'otp.required' => 'OTP is required.',
                'otp.numeric' => 'OTP must be numeric.',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'error' => implode(',', array_flatten($validator->errors()->toArray())),
                ], 422);
            }

            $otp = $request->input('otp');
            $user = User::where("id", $request['user_id'])->first();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'error' => 'Unauthorized user.',
                ], 401);
            }

            $user_email_otp = UserEmailOtp::where('user_id', $user->id)
                ->orderBy('updated_at', 'DESC')->first();

            if (!$user_email_otp) {
                return response()->json([
                    'status' => false,
                    'error' => 'No OTP found for this user.',
                ], 404);
            }

            $userOtpValue = \Crypt::decrypt($user_email_otp->otp);
            if ($userOtpValue == $otp) {
                $user->two_fact_confirm = 1;
                $user->save();
                UserEmailOtp::where('user_id', $user->id)->delete();
                $token = Str::random(60);
                $userToken = UserToken::updateOrCreate(
                    ['user_id' => $user->id, 'device_name' => $request->device_name, 'device_token' => $request->device_token, 'device_type' => $request->device_type], // Condition to find existing entry
                    ['token' => $token]
                );
                if ($userToken) {
                    DeviceHistory::create([
                        'user_id' => $user->id,
                        'device_name' => $request->device_name,
                        'device_token' => $request->device_token,
                        'device_type' => $request->device_type,
                    ]);
                    if (!empty($user->image_url)) {
                        $imagePath = public_path('img') . "/" . $user->image_url;
                        $mimeType = File::mimeType($imagePath);
                        $imageData = base64_encode(File::get($imagePath));
                        $user->image_url = "data:$mimeType;base64,$imageData";
                    }


                    return response()->json([
                        "status" => true,
                        'user' => $user,
                        'token' => $token,
                        'message' => __('validation.mobileAPI.userLoggeIn'),
                    ], 200);
                } else {
                    return response()->json([
                        "status" => false,
                        'error' => __('validation.mobileAPI.tokenFailed'),
                    ], 401);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'error' => 'Invalid OTP.',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'error' => 'Something went wrong.',
            ], 422);
        }
    }
    protected function validateWithDfiq(string $email, string $zipcode): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->dfiqApiKey,
            'Accept' => 'application/json',
        ])->post($this->dfiqApiUrl, [
            'email' => $email,
            'zipcode' => $zipcode,
        ]);

        return $response->json();
    }

    public function checkDfiq(REQUEST $request)
    {

        $ip = '174.138.34.145';
        return $this->callAction('DFIQCheck', [$request, $ip]);
    }


    public function logMessage()
    {
        Log::info('AJAX request triggered automatically on page load.');
        return response()->json(['message' => 'Log written successfully!']);
    }

    public function DFIQCheck($request, $ip)
    {

        $eventId = $ip;
        echo $html = view('api.forensic', compact('request', 'eventId'));
    }

    public function postDfiqData(Request $request)
    {

        Log::info('This is test DFIQ');
    }
    private function getUsersEmail(Request $request)
    {
        $key = config("settings.EMAIL_QUALITY_SCORE");
        $EMAIL_QUALITY_URL = config("settings.EMAIL_QUALITY_URL");
        $email = $request->input("email", false);

        //$is_email = User::where('email',$email)->count();
        $is_email = User::where("email_hash", sha1(strtolower($email)))->count();

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

            $result = json_decode($json, true);
            if (isset($result["success"]) && $result["success"] === true) {
                if (
                    $result["recent_abuse"] === false && ($result["valid"] === true ||
                        ($result["timed_out"] === true &&
                            $result["disposable"] === false &&
                            $result["dns_valid"] === true))
                ) {
                    return response()->json([
                        'status' => true,
                        'type' => 0,
                        'message' => 'Correct Email'
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'type' => 2,
                        'error' => 'This Email address appears to be high risk.'
                    ], 403);
                }
            }
        } else {
            return response()->json([
                'status' => false,
                'type' => 1,
                'error' => 'email already Exist.'
            ], 200);
        }
    }
    private function checkIPwithQUalityCheck(Request $request)
    {

        // Your API Key.

        $key = 'zYC1jnxggPR7OxLZhhYWZl9YSYqAZQYk';

        /*
* Retrieve the user's IP address. 
* You could also pull this from another source such as a database.
* 
*/
        $ip = $request->ip;

        // Retrieve additional (optional) data points which help us enhance fraud scores.

        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        // $user_language = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        // Set the strictness for this query. (0 (least strict) - 3 (most strict))

        $strictness = 1;

        // You may want to allow public access points like coffee shops, schools, corporations, etc...

        $allow_public_access_points = 'true';

        // Reduce scoring penalties for mixed quality IP addresses shared by good and bad users.

        $lighter_penalties = 'false';

        // Create parameters array.

        $parameters = array(

            'user_agent' => $user_agent,

            // 'user_language' => $user_language,

            'strictness' => $strictness,

            'allow_public_access_points' => $allow_public_access_points,

            'lighter_penalties' => $lighter_penalties

        );

        /* User & Transaction Scoring

* Score additional information from a user, order, or transaction for risk analysis

* Please see the documentation and example code to include this feature in your scoring:

* https://www.ipqualityscore.com/documentation/proxy-detection-api/transaction-scoring

* This feature requires a Premium plan or greater

*/

        // Format Parameters

        $formatted_parameters = http_build_query($parameters);

        // Create API URL

        $url = sprintf(

            'https://www.ipqualityscore.com/api/json/ip/%s/%s?%s',

            $key,

            $ip,

            $formatted_parameters

        );

        // Fetch The Result

        $timeout = 5;

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);

        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);

        $json = curl_exec($curl);

        curl_close($curl);

        // Decode the result into an array.

        $result = json_decode($json, true);
        $flag = false;

        // Check to see if our query was successful.

        if (isset($result['success']) && $result['success'] === true) {

            if ($result['proxy'] === true) {

                $flag = true;
            }

            if ($result['fraud_score'] >= 50 && $result['is_crawler'] === false) {

                $flag = true;
            }

            if ($result['tor'] === true || $result['active_tor'] === true) {

                $flag = true;
            }

            if ($result['bot_status'] === true) {

                $flag = true;
            }

            if ($result['vpn'] === true || $result['active_vpn'] === true) {
                $flag = true;
            }
        }
        if ($flag === true) {
            return response()->json([
                'status' => false,
                'error' => 'This IP address appears to be high risk.'
            ], 403);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'Right IP'
            ], 200);
        }
    }
    private function saveDataInMongo($user_id)
    {
        $code = [];
        $answersArray = [];
        $user = User::where("id", $user_id)->first();
        $gender = $user->gender;

        $basic_profile_general_name = 'BASIC';

        if ($gender == 'Male' || $gender == 'Masculino' || $gender == 'mâle' || $gender == 'homme' || $gender == 'Mâle' || $gender == 'Homme' || $gender == 'पुरुष' || $gender == 'male') {
            $gender = 1;
        } else if ($gender == 'Female' || $gender == 'Hembra' || $gender == 'femelle' || $gender == 'femme' || $gender == 'Femelle' || $gender == 'Femme' || $gender == 'महिला' || $gender == 'female') {
            $gender = 2;
        }
        $zip_code = $user->zipcode;
        $dob = $user->dob;
        $age = date_diff(date_create($dob), date_create('today'))->y;
        $get_user_add_data = UserAdditionalData::where('uuid', '=', $user->getUuid())->first();
        //$get_profile_section = ProfileSection::where('general_name','=','BASIC')->first();
        $get_gender_question_code = $this->getGenderQuestionCode();
        $get_age_question_code = $this->getAgeQuestionCode();
        $get_zip_question_code = $this->getZipQuestionCode();
        $code['age'] = $get_age_question_code;
        $code['gender'] = $get_gender_question_code;
        $code['zip'] = $get_zip_question_code;

        foreach ($code  as $key => $value) {
            if ($key == 'age') {
                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => $get_age_question_code,
                    'selected_answer' => [$age]
                ];
            } elseif ($key == 'gender') {
                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => $get_gender_question_code,
                    'selected_answer' => [$gender]
                ];
            } elseif ($key == 'zip') {
                $answersArray[] = [
                    'profile_section_code' => $basic_profile_general_name,
                    'profile_question_code' => $get_zip_question_code,
                    'selected_answer' => [$zip_code]
                ];
            }
        }

        if ($get_user_add_data->user_answers) {
            $new_data = [];

            $userAnswers = collect($get_user_add_data->user_answers);
            $basicProfile = $userAnswers
                ->where('profile_section_code', '=', 'BASIC');
            $newUserAnswers = $userAnswers
                ->where('profile_section_code', '!=', 'BASIC')
                ->toArray();

            if ($basicProfile->isEmpty()) {
                $new_data = $answersArray;
            } else {
                foreach ($basicProfile as $basic_user_answers) {
                    foreach ($answersArray as $answer) {
                        if ($answer['profile_question_code'] == $basic_user_answers['profile_question_code']) {
                            $new_data[] = [
                                'profile_section_code' => $basic_user_answers['profile_section_code'],
                                'profile_question_code' => $basic_user_answers['profile_question_code'],
                                'selected_answer' => $answer['selected_answer'],
                            ];
                        }
                    }
                }
            }
            if (!empty($new_data)) {
                $newUserAnswers = array_merge($newUserAnswers, $new_data);
            }
            $user_Add_data = UserAdditionalData::where('uuid', '=', $user->uuid)
                ->first();
            $user_Add_data->user_answers = $newUserAnswers;
            $user_Add_data->save();
            return true;
        }

        if (empty($get_user_add_data)) {
            $newdata = [
                'uuid' => $user->uuid,
                'u_id' => $user->id,
                'user_answers' => $answersArray,
            ];
            UserAdditionalData::create($newdata);
            return true;
        }

        if (empty($get_user_add_data->user_answers)) {
            $get_user_add_data->push('user_answers', $answersArray);
            $get_user_add_data->save();
            return true;
        }
    }
    private function getGenderQuestionCode()
    {
        $code = 'GLOBAL_GENDER';
        return $code;
    }

    private function getAgeQuestionCode()
    {
        $code = 'GLOBAL_AGE';
        return $code;
    }

    private function getZipQuestionCode()
    {
        $code = 'GLOBAL_ZIP';
        return $code;
    }
}
