<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 09-03-2019
 * Time: 05:39 PM
 */

namespace App\Repositories\Inpanel\Profiler;

//use DB;                                       // To Debug uncomment below line
use App\Models\Profiler\ProfilerQuestions;
use App\Models\Profiler\ProfileSection;


/**
 * This class is handling the create,update for Campaign Data.
 *
 * Class ProfileSectionRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Inpanel\Profiler\ProfileSectionRepository
 */

class ProfileSectionRepository
{

    /**
     * This action is used for getting Profile Sections for the default country and language.
     *
     * @param null $country_code
     * @param null $language_code
     * @return mixed
     */
    public function getPublicProfileSections($country_code = null, $language_code = null)
    {
        // Use default config values if parameters are empty
        $country_code = $country_code ?? config('locale.default_country');
        $language_code = $language_code ?? config('locale.default_language');

        $projectionArray = ProfileSection::getProjectionArray($country_code, $language_code);
        $data =  ProfileSection::active(1)
            ->public()
            ->project($projectionArray)
            //->simplePaginate(10);
            //->sortBy("order")
            ->get();
        

        return $data;
    }

    /**
     * This action is used for getting all the available Profile Section that are active.
     *
     * @return mixed
     */
    public function getAvailableProfilesCount()
    {
        $counts =  ProfileSection::active(1)
            ->public()
            ->count();
        return $counts;
    }

    /**
     * This action is used to get the profile section name that are not answered.
     *
     * @param $profile_codes
     * @param null $country_code
     * @param null $language_code
     * @return mixed
     */
    public function getPublicProfileSectionsExcept($profile_codes, $country_code = null, $language_code = null)
    {
        if(empty($country_code))
            $country_code = config('locale.default_country');

        if(empty($language_code))
            $language_code = config('locale.default_language');

        $projectionArray = ProfileSection::getProjectionArray($country_code, $language_code);

        // To Debug Uncomment below line
        //DB::connection( 'mongodb' )->enableQueryLog(); 
        $data =  ProfileSection::active(1)
            ->public()
            ->whereNotIn('general_name', $profile_codes)
            ->project($projectionArray)
            //->simplePaginate(10);
        //->sortBy("order")
            ->get();

        // To Debug Uncomment below line
        //$queries  = DB::connection('mongodb')->getQueryLog();
        // print_r($queries);
        return $data;
    }

    /**
     * This action is used to get Profile Section by profile section code and country_code and language_code.
     *
     * @param $profileCodes
     * @param $country_code
     * @param $language_code
     * @return mixed
     */
    public function getPublicProfilesByCode( $profileCodes, $country_code, $language_code )
    {
        if(empty($country_code))
            $country_code = config('locale.default_country');

        if(empty($language_code))
            $language_code = config('locale.default_language');

        $projectionArray = ProfileSection::getProjectionArray($country_code, $language_code);
        $profiles = ProfileSection::public()
            ->whereIn('general_name', $profileCodes)
            ->project($projectionArray)
            ->get();
            //->simplePaginate(10); //No Need to Do Pagination here
           
        return $profiles;
    }

    /**
     * This action is used for getting the counts of profile questions for a particular profile sections.
     *
     * @param $profile
     * @return mixed
     */
    public function getProfileQuestionCount($profile)
    {
        $count = ProfilerQuestions::where('profile_section_code', '=', $profile->general_name)->count();
        return $count;
    }

    /**
     * This action is used for getting total questions by country_code, and profile_section_code.
     *
     * @param $profile_code
     * @param $country
     * @param bool $projectionArray
     * @return mixed
     */
    public function getTotalQuestions($profile_code,$country,$projectionArray = false)
    {
        $data = ProfilerQuestions::where('profile_section_code','=',$profile_code)
            ->where('country_code','=',$country)->get();
        return $data;

        /*$data = ProfilerQuestions::where('profile_section_code','=',$profile_code)
            ->where('country_code','=',$country)
            ->project($projectionArray)
            ->get()->toArray();
        return $data;*/
    }

    public function getDetailedProfileSurvey()
    {
        /*$locale = app()->getLocale();
        list($country_code, $language_code) = get_codes_from_locale($locale);
        $profileSectionRepo = new ProfileSectionRepository();
        $profile_sections = $profile_sections = $profileSectionRepo->getPublicProfileSections($country_code, $language_code);
        $allPointsCount = $profile_sections->sum('points');
        $user = auth()->user();
        $filledProfilesCount = 0;
        $filledProfilesCodes = [];
        $userAddRepo = new UserAdditionalDataRepository();
        $user_filled_profiles = $userAddRepo->getFilledProfiles($user);
        $completedProfiles = [];
        if (!empty($user_filled_profiles) && !empty($user_filled_profiles->user_filled_profiles) ) {
            foreach ($user_filled_profiles->user_filled_profiles as $profiles) {
                $current = reset($profiles);
                $filledProfilesCodes[] = $current['code'];
                $filledProfilesCount += $current['points'];
            }
            if ( !empty($filledProfilesCodes) ) {
                $profile_sections = $profileSectionRepo->getPublicProfileSectionsExcept($filledProfilesCodes, $country_code, $language_code);
                $completedProfiles = $profileSectionRepo->getPublicProfilesByCode($filledProfilesCodes, $country_code, $language_code);
            }
        }
        $top_profile = $profile_sections->sortBy('order')->first();
        if($top_profile){
            $points = array_column($profile_sections->toArray(), 'points');
           
            $completion_time = array_column($profile_sections->toArray(), 'completion_time');
            $total_available_points = array_sum($points);
            $total_completion_time = array_sum($completion_time);
            $top_profile->total_points = $total_available_points;
            $top_profile->completion_time = $total_completion_time;
        }
        return $top_profile;*/
        $locale = app()->getLocale();
list($country_code, $language_code) = get_codes_from_locale($locale);

$profileSectionRepo = new ProfileSectionRepository();
$profile_sections = $profileSectionRepo->getPublicProfileSections($country_code, $language_code);

$allPointsCount = $profile_sections->sum('points');

$user = auth()->user();
$filledProfilesCodes = [];
$filledProfilesCount = 0;
$completedProfiles = [];

$userAddRepo = new UserAdditionalDataRepository();
$user_filled_profiles = $userAddRepo->getFilledProfiles($user);

if (!empty($user_filled_profiles) && !empty($user_filled_profiles->user_filled_profiles)) {
    foreach ($user_filled_profiles->user_filled_profiles as $profiles) {
        $current = reset($profiles);
        if (!empty($current['code']) && isset($current['points'])) {
            $filledProfilesCodes[] = $current['code'];
            $filledProfilesCount += $current['points'];
        }
    }

    if (!empty($filledProfilesCodes)) {
        $profile_sections = $profileSectionRepo->getPublicProfileSectionsExcept(
            $filledProfilesCodes,
            $country_code,
            $language_code
        );

        $completedProfiles = $profileSectionRepo->getPublicProfilesByCode(
            $filledProfilesCodes,
            $country_code,
            $language_code
        );
    }
}

$top_profile = $profile_sections->sortBy('order')->first();

if ($top_profile) {
    $points = $profile_sections->pluck('points')->all(); // Laravel Collection
    $completion_time = $profile_sections->pluck('completion_time')->all();

    $top_profile->total_points = array_sum($points);
    $top_profile->completion_time = array_sum($completion_time);
}

return $top_profile;
    }
}
