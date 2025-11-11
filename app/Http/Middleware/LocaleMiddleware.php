<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;

/**
 * Class LocaleMiddleware.
 */
class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /*
         * Locale is enabled and allowed to be changed
         */
       
        if (config('locale.status')) {

            if(!empty($request->lang)){

                session()->put('swap_locale', $request->lang);
            }
            if($request->user() && !session()->has('swap_locale')){

                session()->put('locale', $request->user()->locale);
            } elseif ($request->user() && session()->has('swap_locale')) {
                session()->put('locale', session()->get('swap_locale'));
            }elseif (!$request->user() && session()->has('swap_locale')){
                session()->put('locale', session()->get('swap_locale'));
            } else {
                $geoip = geoip(request()->ip());
                 $countryCode = $geoip->getAttribute('iso_code');
              
                
                switch ($countryCode) {
                    case 'FR':
                        $ipcountryCode = 'fr_'.$countryCode;
                        break;
                    case 'ES':
                        $ipcountryCode = 'es_'.$countryCode;
                        break;
                    case 'DE':
                        $ipcountryCode = 'de_'.$countryCode;
                        break;
                    case 'IT':
                        $ipcountryCode = 'it_'.$countryCode;
                        break;
                    case 'GB':
                        $ipcountryCode = 'en_UK';
                        break;
                    default:
                        $ipcountryCode = 'en_'.$countryCode;
                        break;
                }
                
                //session()->put('locale', 'en_US');
                session()->put('locale', $ipcountryCode);
            }
            if (session()->has('locale') && in_array(session()->get('locale'), array_keys(config('locale.languages')))) {

                /*
                 * Set the Laravel locale
                 */

                app()->setLocale(session()->get('locale'));

                /*
                 * setLocale for php. Enables ->formatLocalized() with localized values for dates
                 */
                setlocale(LC_TIME, config('locale.languages')[session()->get('locale')][1]);

                /*
                 * setLocale to use Carbon source locales. Enables diffForHumans() localized
                 */
                 $current_locale = explode('_',config('locale.languages')[session()->get('locale')][0]);

                 $current_lang = $current_locale[0];

                
                Carbon::setLocale($current_lang);
                /*
                 * Set the session variable for whether or not the app is using RTL support
                 * for the current language being selected
                 * For use in the blade directive in BladeServiceProvider
                 */
               
                if (config('locale.languages')[session()->get('locale')][2]) {
                     
                    session(['lang-rtl' => true]);
                } else {
                    
                     
                    session()->forget('lang-rtl');
                }
            }
        }
        return $next($request);
    }
}
