<?php

namespace App\Http\Controllers\Frontend\Auth;

use Illuminate\Http\Request;
use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Events\Frontend\Auth\UserLoggedIn;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Helpers\Frontend\Auth\Socialite as SocialiteHelper;
use Illuminate\Support\Str;
use App\Helpers\Auth\Auth;
use Artisan;

/**
 * This class is used for handling Social Login and saving login data in User Table.
 *
 * Class SocialLoginController
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Http\Controllers\Frontend\Auth\SocialLoginController
 */
class SocialLoginController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @var SocialiteHelper
     */
    protected $socialiteHelper;

    /**
     * SocialLoginController constructor.
     *
     * @param UserRepository  $userRepository
     * @param SocialiteHelper $socialiteHelper
     */
    public function __construct(UserRepository $userRepository, SocialiteHelper $socialiteHelper)
    {
        $this->userRepository = $userRepository;
        $this->socialiteHelper = $socialiteHelper;
    }

    /**
     * This action is used to redirect the user to social login page as per selected by the User like github,
     * facebook etc and as user give auth to that social part his data will be saved in User Table and also automatically
     * confirm his account.
     *
     * @param Request $request
     * @param $provider
     *
     * @throws GeneralException
     *
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function login(Request $request, $provider)
    {

        if ($request->has('error')) {
            $errorDescription = urldecode($request->get('error_description', 'Login failed.'));
            return redirect()->route(home_route())->withFlashDanger("Login failed: {$errorDescription}");
        }

        // dd('pr1 : ' . config('database.connections.mongodb.host'));

        $request->session()->put('state', Str::random(40));
        if ($request->has('denied') || $request->has('error')) {
            //return redirect()->intended(route(home_route()));
        }
        // There's a high probability something will go wrong
        $user = null;

        // If the provider is not an acceptable third party than kick back
        if (! in_array($provider, $this->socialiteHelper->getAcceptedProviders())) {


            return redirect()->route(home_route())->withFlashDanger(__('auth.socialite.unacceptable', ['provider' => $provider]));
        }

        /*
         * The first time this is hit, request is empty
         * It's redirected to the provider and then back here, where request is populated
         * So it then continues creating the user
         */

        if (! $request->all()) {

            return $this->getAuthorizationFirst($provider);
        }

        // Create the user if this is a new social account or find the one that is already there.
        try {

            $user = $this->userRepository->findOrCreateProvider($this->getProviderUser($provider), $provider);
            //  print_r("hii test again123");die;
            //   echo '<pre>';
            //   print_r($user->social_email);die();

            // auth()->login($user, true);
        } catch (GeneralException $e) {


            return redirect()->route(home_route())->withFlashDanger($e->getMessage());
        }


        if (is_null($user)) {
            return redirect()->route(home_route())->withFlashDanger(__('exceptions.frontend.auth.unknown'));
        }

        // Check to see if they are active.
        if (! $user->isActive()) {
            // throw new GeneralException(__('exceptions.frontend.auth.deactivated'));
        }

        // Account approval is on
        if ($user->isPending()) {

            //throw new GeneralException(__('exceptions.frontend.auth.confirmation.pending'));


        }


        // User has been successfully created or already exists
        //auth()->login($user, true);

        // Set session variable so we know which provider user is logged in as, if ever needed
        session([config('access.socialite_session_name') => $provider]);
        //event(new UserLoggedIn($user));
        auth()->loginUsingId((int) $user->id);
        //session()->put('current_user', auth()->user());
        //auth()->login($user, true);
        // Return to the intended url or default to the class property
        return redirect()->intended(route(home_route()));
    }

    /**
     * @param  $provider
     *
     * @return mixed
     */
    protected function getAuthorizationFirst($provider)
    {


        $socialite = Socialite::driver($provider);

        $scopes = empty(config("services.{$provider}.scopes")) ? false : config("services.{$provider}.scopes");

        $with = empty(config("services.{$provider}.with")) ? false : config("services.{$provider}.with");
        $fields = empty(config("services.{$provider}.fields")) ? false : config("services.{$provider}.fields");
        //print_r($scopes);die;
        if ($scopes) {
            $socialite->scopes($scopes);
        }

        if ($with) {
            $socialite->with($with);
        }

        if ($fields) {
            $socialite->fields($fields);
        }


        return $socialite->redirect();
    }

    /**
     * @param $provider
     *
     * @return mixed
     */
    protected function getProviderUser($provider)
    {
        //return Socialite::driver($provider)->user();

        try {

            // For First Time user
            $socialite = Socialite::driver($provider)->user();
        } catch (InvalidStateException $e) {
            // For already registered user
            $socialite = Socialite::driver($provider)->stateless()->user();
        }


        // $socialite= Socialite::driver($provider)->stateless()->user();


        return $socialite;
    }
}
