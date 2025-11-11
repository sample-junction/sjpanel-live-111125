<?php

use App\Helpers\General\Timezone;
use App\Helpers\General\HtmlHelper;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Client;
use Illuminate\Validation\ValidationException;
use App\Services\RewardService;
use Carbon\Carbon;

/*
 * Global helpers file with misc functions.
 */
if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (! function_exists('timezone')) {
    /**
     * Access the timezone helper.
     */
    function timezone()
    {
        return resolve(Timezone::class);
    }
}

if (! function_exists('include_route_files')) {

    /**
     * Loops through a folder and requires all PHP files
     * Searches sub-directories as well.
     *
     * @param $folder
     */
    function include_route_files($folder)
    {
        try {
            $rdi = new recursiveDirectoryIterator($folder);
            $it = new recursiveIteratorIterator($rdi);

            while ($it->valid()) {
                if (! $it->isDot() && $it->isFile() && $it->isReadable() && $it->current()->getExtension() === 'php') {
                    require $it->key();
                }

                $it->next();
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

if (! function_exists('home_route')) {

    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        //echo"Ramesh";

        // print(auth()->user()->can('view backend'));die;
        if (auth()->check()) {
            if (auth()->user()->can('view backend')) {
               

                //return 'admin.dashboard';
                return 'admin.auth.support.history';

            } else {

                return 'inpanel.dashboard';

            }
        }
       
        return 'frontend.index';
    }

}

if (! function_exists('style')) {

    /**
     * @param       $url
     * @param array $attributes
     * @param null  $secure
     *
     * @return mixed
     */
    function style($url, $attributes = [], $secure = null)
    {
        return resolve(HtmlHelper::class)->style($url, $attributes, $secure);
    }
}

if (! function_exists('script')) {

    /**
     * @param       $url
     * @param array $attributes
     * @param null  $secure
     *
     * @return mixed
     */
    function script($url, $attributes = [], $secure = null)
    {
        return resolve(HtmlHelper::class)->script($url, $attributes, $secure);
    }
}

if (! function_exists('form_cancel')) {

    /**
     * @param        $cancel_to
     * @param        $title
     * @param string $classes
     *
     * @return mixed
     */
    function form_cancel($cancel_to, $title, $classes = 'btn btn-danger btn-sm')
    {
        return resolve(HtmlHelper::class)->formCancel($cancel_to, $title, $classes);
    }
}

if (! function_exists('form_submit')) {

    /**
     * @param        $title
     * @param string $classes
     *
     * @return mixed
     */
    function form_submit($title, $classes = 'btn btn-success btn-sm pull-right')
    {
        return resolve(HtmlHelper::class)->formSubmit($title, $classes);
    }
}

if (! function_exists('camelcase_to_word')) {

    /**
     * @param $str
     *
     * @return string
     */
    function camelcase_to_word($str)
    {
        return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
    }
}

if (! function_exists('get_codes_from_locale')) {

    /**
     * @param $str
     *
     * @return string
     */
    function get_codes_from_locale( $locale ): Array
    {

        $locales = explode('_', str_replace('-','_',strtoupper($locale)));
       
        //$locales = explode('-', strtoupper($locale));
        if (!empty($locales[0])) {
            return [$locales[1], $locales[0]];
        }
        return [
            config('locale.default_country'),
            config('locale.default_language')
        ];
    }
}


if (! function_exists('check_supplied_postcode')) {

    /**
     * @return string
     */
    function check_supplied_postcode_old($postcode, $country_code)
    {
        $apiKey = 'dc31da0d4fed1110d9bfac24efc2b7f3';
        $api_user_id = 349;
        $client = new Client(['base_uri' => 'http://ezcmd.com/','verify' => false ]);
        try{
            $response = $client->request('GET', "apps/api_geo_postal_codes/nearby_locations_by_zip_code/$apiKey/$api_user_id?zip_code=$postcode&country_code=$country_code&unit=Miles&within=5",[
            ]);
            if( $response->getStatusCode() == 200 ){
                $output = json_decode($response->getBody()->getContents());
                if($output->success && count($output->search_results) > 0 ){
                    
                    /*
                    * Validation with Zip Code and Geolocation Starts
                    * Description:- Check if zip code came under user's current geolocation or under 5miles of
                    * zip code's location
                    */
                    $info = json_decode(json_encode($output->search_results), true);
                    $geoip = geoip(request()->ip());
                    $ipcountryCode = $geoip->getAttribute('iso_code');
                    $lat = $geoip->getAttribute('lat');
                    $lon = $geoip->getAttribute('lon');
                    echo "$lat  ==  $lon <br>";
                    $latcheck = (in_array($lat, array_column($info, 'lat'))) ? 1 : 0 ;
                    $loncheck = (in_array($lon, array_column($info, 'lon'))) ? 1 : 0 ;

                    echo "$latcheck  ==  $loncheck <br>";
                    die;
                    if(($latcheck && $loncheck)  ){  //|| $geoip!='127.0.0.1'
                        return true;
                    } else {
                        return false;
                    }
                    /* Validation with Zip Code and Geolocation Ends */
                    return true;
                }
            }
        } catch(ServerException $e) {
            dd($e->getResponse()->getBody()->getContents());
        }

        return false;
    }


    function check_supplied_postcode($postcode, $country_code)
    {
        //$apiKey = 'dc31da0d4fed1110d9bfac24efc2b7f3';
        //$api_user_id = 349;
        $apiKey ='db7446c25ecbdd1d8a2c6bdcd8fc8da6';
        $api_user_id = 1040;
        $client = new Client(['base_uri' => 'http://ezcmd.com/','verify' => false ]);
        //echo request()->ip();

        if($country_code=='US'){
       // $ip='77.111.246.19';
          $ip=request()->ip();
        
          $geoip = geoip($ip);
        }else{
            $geoip = geoip(request()->ip());
        }
       
        $ipcountryCode = $geoip->getAttribute('iso_code');
        $lat = $geoip->getAttribute('lat');
        $lon = $geoip->getAttribute('lon');
       //echo "$lat  ==  $lon <br>";
       //exit;
        $response = $client->request('GET', "apps/api_geo_postal_codes/nearby_locations_by_zip_code/$apiKey/$api_user_id?zip_code=$postcode&country_code=$ipcountryCode&unit=Miles&within=60",[
        ]);
        //echo '<pre>';
        
        
        if( $response->getStatusCode() == 200 ){
            $output = json_decode($response->getBody()->getContents());
            //print_r($output);
            //exit;
            if($output->success){
                try{
                    $response = $client->request('GET', "apps/api_geo_postal_codes/nearby_locations_by_zip_code/$apiKey/$api_user_id?zip_code=$postcode&country_code=$country_code&unit=Miles&within=60",[]);

                    if( $response->getStatusCode() == 200 ){
                        $info = json_decode($response->getBody()->getContents());
                        if($info->success && count($info->search_results) > 0 ){
                            /*
                            * Validation with Zip Code and Geolocation Starts
                            * Description:- Check if zip code came under user's current geolocation or under 5miles of
                            * zip code's location
                            */
                            
                            $info = json_decode(json_encode($info->search_results[0]), true);
                            // print_r($info);
                            // echo "$lat  ==  $lon <br>";
                            /*$latcheck = (in_array($lat, array_column($info, 'lat'))) ? 1 : 0 ;
                            $loncheck = (in_array($lon, array_column($info, 'lon'))) ? 1 : 0 ;*/

                            $coords = $info['coords'];
                            $zipDistance = $client->request('GET', "apps/api_ezip_locator/distance/$apiKey/$api_user_id?source_coords=$lat,$lon&dest_coords=$coords&type=miles",[]);

                            if( $zipDistance->getStatusCode() == 200 ){
                                $Distanceinfo = json_decode($zipDistance->getBody()->getContents());
                                
                                if($Distanceinfo->success && $Distanceinfo->distance_info->calculated_distance > 50 )
                                {
                                    throw ValidationException::withMessages([
                                        $ipcountryCode => [trans('auth.zipCodeLocationFraud')],
                                    ]);
                                }else{
                                    return true;    
                                }                                
                            }
                            /* Validation with Zip Code and Geolocation Ends */
                        }
                    }
                    return false;
                }
                catch(ServerException $e) {
                    dd($e->getResponse()->getBody()->getContents());
                }
            }
            else{
                throw ValidationException::withMessages([
                    $ipcountryCode => [trans('auth.zipCodeLocationFraud')],
                ]);
            }
        }
        return false;
    }

    if (!function_exists('getLoggedInUserRewardData')) {
        function getLoggedInUserRewardData()
        {
            $rewardService = app(RewardService::class); 
            return $rewardService->getUserReward();
        }
    }

    // added by himanshu 03-10-2025
    if (!function_exists('getWinningDataForLoggedInUser')) {
        function getWinningDataForLoggedInUser()
        {
            $user = auth()->user();
            $award_date = Carbon::now()->subMonthNoOverflow()->format('Y-m');
            $rewardService = app(RewardService::class);

            $winnerData = $rewardService->isWinnerPanellist($user->panellist_id, $award_date);
            if($winnerData && !empty($winnerData->dollar_amount) && empty($winnerData->redemption_status)){
                return $winnerData;
            }
            return false;
        }
    }
    // end here
}
