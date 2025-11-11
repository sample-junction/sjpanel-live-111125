<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Events\Inpanel\Auth\UserConfirmed;
use App\Helpers\Auth\Auth;
use App\Mail\Frontend\EmailOtp\EmailOtpMail;
use App\Models\Auth\User;
use App\Models\Auth\UserEmailOtp;
use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Repositories\Inpanel\General\GeneralRepository;
use App\Http\Controllers\Controller;
use App\Helpers\Frontend\Auth\Socialite;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Events\Frontend\Auth\UserLoggedOut;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Repositories\Frontend\Auth\UserSessionRepository;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\Campaign\campaign_history;
use Cookie;
// use Illuminate\Support\Facades\Cookie;

/**
 * Class LoginController.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @return string
     */

    protected $generalRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(GeneralRepository $generalRepository)
    {


        // $this->userRepository = $userRepository;
        $this->generalRepository = $generalRepository;
    }

    public function redirectPath()
    {
        //  print(home_route());die;
        return route(home_route());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm(Request $request)
    {
        $uuid = Str::uuid()->toString();
        $ip = request()->ip();
        $DFIQ = config('settings.dfiq.status');
        $geodata = geoip($ip);
        $countries = $this->generalRepository->getActiveCountries();
        $country = $geodata->getAttribute('country');
        $ipcountryCode = $geodata->getAttribute('iso_code');
        $locale = $request->session()->get('locale');
        if ($ipcountryCode != 'US') {
            if (!empty($locale)) {
                $flag = str_replace('_', '-', strtoupper($locale));

               // app()->setLocale(strtolower($locale));

            } else {
                $localeCode = 'en_' . strtolower($ipcountryCode);
                app()->setLocale($localeCode);
                $flag = str_replace('_', '-', strtoupper($localeCode));
            }
        } else {

            //app()->setLocale('en');

            $flag = str_replace('_', '-', strtoupper($locale));
        }
        $AllowCountry=['US','UK','CA','IN','GB'];
        if(!in_array($ipcountryCode,$AllowCountry)){
            return redirect()->route(home_route())->withFlashDanger(__('validation.attributes.frontend.not_allowed_country'));
        }
        $prompt = [];
        if ($request->has('prompt_id')) {
            array_push($prompt, true);
        }

        if ($request->has('code')) {
            session()->put('code_id', $request->get('code'));
        }
        return view('frontend.auth.login')->with('ip', str_replace('.', '-', $ip))
            ->with('uuid', $uuid)
            ->with('prompt', $prompt)
            ->with('dfiq', $DFIQ)
            ->withCountries($countries)
            ->with('country_name', strtoupper($country))
            ->with('country_code', $ipcountryCode)
            ->with('flags', $flag)
            ->withSocialiteLinks((new Socialite)->getSocialLinks());
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return config('access.users.username');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request
     * @param         $user
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws GeneralException
     */
    protected function authenticated(Request $request, $user)
    {
        // echo '<pre>';
        // // sha1('rohanbochkari@gmail.com');
        // print_r($user->roles);
        // die();
        /*
         * Check to see if the users account is confirmed and active
         */

        if ($request->has('remember')) {
            Cookie::queue('email', $request->get('email'), 10);
            Cookie::queue('password', $request->get('password'), 10);
        }

        if (!$user->isConfirmed() && $user->is_social != 1) {


            auth()->logout();

            // If the user is pending (account approval is on)
            if ($user->isPending()) {
                throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'), 0, null, ['confirmation_pending' => true,'user_id' => $user->id]);
            }

            // Otherwise see if they want to resent the confirmation e-mail
            throw new GeneralException(__('exceptions.frontend.auth.confirmation.resend', ['url' => route('frontend.auth.account.confirm.resend', $user->{$user->getUuidName()})]));
        } elseif (! $user->isActive()) {
            auth()->logout();
            throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        event(new UserLoggedIn($user));
        // echo 'user';
        session()->put('current_user', auth()->user());

        session()->put('pop-up-survey', 1);
        session()->put('pop-up-refer', 1);

        //Last Active Time Added By Ramesh//
        session()->put('last_active', time());
        //End Here//
        $user = auth()->user();
        // echo '<pre>';
        // print_r($user->roles->pluck('name')[0]);die();
        $user->two_fact_confirm = 0;
        $user->save();
        // If only allowed one session at a time
        if (config('access.users.single_login')) {
            resolve(UserSessionRepository::class)->clearSessionExceptCurrent($user);
        }
        app()->setLocale($user->locale);
        if ($request->has('prompt')) {
            return redirect()->route('inpanel.profiler.show');
        } else {
            if (session()->has('code_id')) {
                $code = session()->get('code_id');
                $campaign = campaign_history::where('campaign_code', $code)->first();
                if ($campaign) {
                    $campaign->status = 1;
                    $campaign->link_status_date = now()->toDateTimeString();
                    $campaign->save();
                    return redirect($campaign->status_link);
                }
            }
            return redirect()->intended($this->redirectPath());
        }
    }

    /**
     * Log the user out of the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {

        /*
         * Remove the socialite session variable if exists
         */
        if (app('session')->has(config('access.socialite_session_name'))) {
            app('session')->forget(config('access.socialite_session_name'));
        }

        /*
         * Remove any session data from backend
         */
        app()->make(Auth::class)->flushTempSession();

        /*
         * Fire event, Log out user, Redirect
         */
        //\Cookie::queue(\Cookie::forget('Tour'));
        $user = auth()->user();
        $user->two_fact_confirm = 0;
        $user->home_country = '';
        $user->save();
        event(new UserLoggedOut($request->user()));

        /*
         * Laravel specific logic
         */
        $this->guard()->logout();
        $request->session()->invalidate();
        return redirect()->route('frontend.index');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutAs()
    {
        // If for some reason route is getting hit without someone already logged in
        if (! auth()->user()) {
            return redirect()->route('frontend.auth.login');
        }
        // If admin id is set, relogin
        if (session()->has('admin_user_id') && session()->has('temp_user_id')) {
            // Save admin id
            $admin_id = session()->get('admin_user_id');

            app()->make(Auth::class)->flushTempSession();

            // Re-login admin
            auth()->loginUsingId((int) $admin_id);

            // Redirect to backend user page
            //return redirect()->route('admin.auth.user.index');
            return redirect()->route('admin.auth.panelist');
        } else {
            app()->make(Auth::class)->flushTempSession();

            // Otherwise logout and redirect to login
            auth()->logout();

            return redirect()->route('frontend.auth.login');
        }
    }

    public function otpConfirmationForm(Request $request)
    {

        $uuid = Str::uuid()->toString();
        $ip = request()->ip();
        $DFIQ = config('settings.dfiq.status');
        $geodata = geoip(request()->ip());
        $countries = $this->generalRepository->getActiveCountries();
        $country = $geodata->getAttribute('country');
        $ipcountryCode = $geodata->getAttribute('iso_code');

        if ($ipcountryCode != 'US') {
            if (!empty($request->session()->get('locale'))) {
                $flag = str_replace('_', '-', strtoupper($request->session()->get('locale')));
            } else {
                app()->setLocale('EN-' . $ipcountryCode);
                $flag = 'EN-' . $ipcountryCode;
            }
        } else {
            $flag = str_replace('_', '-', strtoupper($request->session()->get('locale')));
        }

        // echo $ipcountryCode;
        // echo '<pre>';
        // print_r($flag);die();
        return view('frontend.auth.google2fa.two_fact_login')->with('ip', str_replace('.', '-', request()->ip()))
            ->with('uuid', $uuid)
            ->with('dfiq', $DFIQ)
            ->withCountries($countries)
            ->with('country_name', strtoupper($country))
            ->with('countryCode', $ipcountryCode)
            ->with('flags', $flag);
        //    ->withSocialiteLinks((new Socialite)->getSocialLinks());

        // return view('frontend.auth.google2fa.two_fact_login');

    }

    public function postOtpConfirmation()
    {
        return redirect()->route('inpanel.dashboard')
            ->withFlashSuccess(__('frontend.messages.success'));
    }

    public function getMode(Request $request)
    {
        $mode = $request->mode;
        if ($mode == 1) {
            return view('frontend.auth.google2fa.two_fact_auth');
        } elseif ($mode == 2) {
            $user = auth()->user();
            $email = $user->email;

            $six_digit_random_number = mt_rand(100000, 999999);
            $encrypt_otp = \Crypt::encrypt($six_digit_random_number);
            if ($encrypt_otp) {
                $insert_data = [
                    'user_id' => $user->id,
                    'otp' => $encrypt_otp,
                ];
                $save_user_email_otp = UserEmailOtp::create($insert_data);
                $email = new EmailOtpMail($user, $six_digit_random_number);
                Mail::send($email);
                return view('frontend.auth.google2fa.email_otp_auth')
                    ->with('email', $user->email);
            }
        } else {
            return false;
        }
    }

    public function postEmailOtpConfirmation(Request $request)
    {
        $otp = $request->input('one_time_password', false);
        if (!$otp) {
            return \Redirect::back()
                ->withDanger(__('frontend.messages.error_2'));
        }
        $user = auth()->user();
        $user_email_otp = UserEmailOtp::where('user_id', '=', $user->id)
            ->orderBy('updated_at', 'DESC')->first();
        // echo '<pre>';
        // print_r($user_email_otp->otp);die();
        $userOtpValue = \Crypt::decrypt($user_email_otp->otp);
        if ($userOtpValue == $otp) {
            $user->two_fact_confirm = 1;
            $user->save();
            $deleteOtp = UserEmailOtp::where('user_id', '=', $user->id)
                ->delete();
            return redirect()->route('inpanel.dashboard')
                ->withFlashSuccess(__('frontend.messages.success'));
        } else {
            return \Redirect::back()
                ->withErrors(__('frontend.messages.error'));
        }
    }

    public function resendOtp()
    {
        $user = auth()->user();
        $email = $user->email;
        $six_digit_random_number = mt_rand(100000, 999999);
        $encrypt_otp = \Crypt::encrypt($six_digit_random_number);
        if ($encrypt_otp) {
            $insert_data = [
                'user_id' => $user->id,
                'otp' => $encrypt_otp,
            ];
            $save_user_email_otp = UserEmailOtp::create($insert_data);
            $email = new EmailOtpMail($user, $six_digit_random_number);
            Mail::send($email);
        }
        return response()->json(['status' => 200]);
    }
    public function moblieConfirmationView()
    {
        return view('frontend.auth.thank-you-app');
    }
}
