<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Support\Facades\Log;
/**
 * Class AppServiceProvider.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Sets third party service providers that are only needed on local/testing environments
         */
        if ($this->app->environment() != 'production') {
            /**
             * Loader for registering facades.
             */
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();

            /*
             * Load third party local aliases
             */
            $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
            /*
         * Application locale defaults for various components
         *
         * These will be overridden by LocaleMiddleware if the session local is set
         */

        /*
         * setLocale for php. Enables ->formatLocalized() with localized values for dates
         */
        setlocale(LC_TIME, config('app.locale_php'));

        /*
         * setLocale to use Carbon source locales. Enables diffForHumans() localized
         */
        Carbon::setLocale(config('app.locale'));

        /*
         * Set the session variable for whether or not the app is using RTL support
         * For use in the blade directive in BladeServiceProvider
         */
        if (! app()->runningInConsole()) {
           /* dd(config('locale.languages')[config('app.locale')][2]);*/
            if (isset(config('locale.languages')[config('app.locale')]) && config('locale.languages')[config('app.locale')][2]) {
                session(['lang-rtl' => true]);
            } else {
                session()->forget('lang-rtl');
            }
        }

        // Force SSL in production
        if ($this->app->environment() == 'production') {
            //URL::forceScheme('https');
        }

        // Set the default string length for Laravel5.4
        // https://laravel-news.com/laravel-5-4-key-too-long-error
        Schema::defaultStringLength(191);
        $date=date('Y-m-d');
       // $count=DB::table('users')->where(DB::raw("DATE_FORMAT(users.created_at, '%Y-%m-%d')"),$date)->count();
        $count=DB::table('users')->where('confirmed',1)->WhereNull('deleted_at')->count();
       // $message=DB::table('support_chats')->where(DB::raw("DATE_FORMAT(support_chats.created_at, '%Y-%m-%d')"),$date)->count();
        $message=DB::table('panellist_supports')->where('status',0)->count();
       // $redeemcount=DB::table('request_redeems')->where(DB::raw("DATE_FORMAT(request_redeems.created_at, '%Y-%m-%d')"),$date)->count();
         $redeem=DB::table('request_redeems')->where('status','pending')->count();
        View::share('count',$count);
        View::share('message',$message);
        View::share('redeemcount',$redeem);
        // Set the default template for Pagination to use the included Bootstrap 4 template
        \Illuminate\Pagination\AbstractPaginator::defaultView('pagination::bootstrap-4');
        \Illuminate\Pagination\AbstractPaginator::defaultSimpleView('pagination::simple-bootstrap-4');

            /*Mail::macro('setConfig', function (string $key, string $domain) {

            $transport = $this->getSwiftMailer()->getTransport();
            $transport->setKey($key);
            $transport->setDomain($domain);

            return $this;
        });*/
    }
}
