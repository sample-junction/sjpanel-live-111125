<?php

namespace App\Models\Auth\Traits\Method;

use App\Events\Inpanel\Auth\UserAchievementUpdate;
use App\Models\Profiler\ProfilerQuestions;
use App\Models\Profiler\ProfileSection;
use App\Repositories\Inpanel\Profiler\ProfileSectionRepository;
use App\Repositories\Inpanel\Profiler\UserAdditionalDataRepository;

/**
 * Trait UserMethod.
 */
trait UserMethod
{
    /**
     * @return mixed
     */
    public function canChangeEmail()
    {
        return config('access.users.change_email');
    }

    /**
     * @return bool
     */
    public function canChangePassword()
    {
        return ! app('session')->has(config('access.socialite_session_name'));
    }

    /**
     * @param bool $size
     *
     * @return bool|\Illuminate\Contracts\Routing\UrlGenerator|mixed|string
     * @throws \Illuminate\Container\EntryNotFoundException
     */
    public function getPicture($size = false)
    {
        switch ($this->avatar_type) {
            case 'gravatar':
                if (! $size) {
                    $size = config('gravatar.default.size');
                }

                return gravatar()->get($this->email, ['size' => $size]);

            case 'storage':
                return url('storage/'.$this->avatar_location);
        }

        $social_avatar = $this->providers()->where('provider', $this->avatar_type)->first();
        if ($social_avatar && strlen($social_avatar->avatar)) {
            return $social_avatar->avatar;
        }

        return false;
    }

    /**
     * @param $provider
     *
     * @return bool
     */
    public function hasProvider($provider)
    {
        foreach ($this->providers as $p) {
            if ($p->provider == $provider) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return mixed
     */
    public function isAdmin()
    {
        return ($this->hasRole(config('access.users.admin_role')) || $this->hasRole(config('access.users.super_admin_role')))?true:false;
    }
    
     /**
     * @return mixed
     */
    public function isManager()
    {
        return ($this->hasRole('manager'))?true:false;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->active;
    }

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @return bool
     */
    public function isPending()
    {
        return config('access.users.requires_approval') && ! $this->confirmed;
    }

    public function getUserBasicFields(){
        return [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'timezone' => 'Timezone',
            'gender' => 'Gender',
            'dob' => 'Date of Birth',
            'zipcode' => 'Zipcode / Postcode',
            'locale' => 'Locale',
            'country_code' => 'country_code',
        ];
    }

    public function syncUserFilledProfiles($user, $profile, $forceComplete = false)
    {
        $profile = ProfileSection::find($profile->_id);

        $profileSection = new ProfileSectionRepository();
        $profileQuestionsCount =  $profileSection->getProfileQuestionCount($profile);
        $profile_data[$profile->_id] = $profileQuestionsCount;
        $user_id = $user->id;


        //UserFilledProfile::where(['user_id' => $user_id, 'profile_section_id' => $profile_id])->delete();

        $userAddRepo = new UserAdditionalDataRepository();
        $userAnswers = $userAddRepo->getUserAnswersSpecificProfile($user, $profile->general_name);

        $userAnswersCount = 0;
        if (!empty($userAnswers) && !empty($userAnswers->user_answers)) {
            $userAnswersCount = count($userAnswers->user_answers);
        }
        if(!$forceComplete){
            if($profileQuestionsCount == $userAnswersCount){
                $filled_data[$profile->general_name] = ['code' => $profile->general_name, 'points' => $profile->points];
                $userAddRepo->updateUserFilledProfile($user, $filled_data);
                $userAddRepo->giveDetailedProfilePoint($user,$profile);
                event(new UserAchievementUpdate($user));
            }
        }else{
            $filled_data[$profile->general_name] = ['code' => $profile->general_name, 'points' => $profile->points];
            $userAddRepo->updateUserFilledProfile($user, $filled_data);
            $userAddRepo->giveDetailedProfilePoint($user,$profile);
            event(new UserAchievementUpdate($user));
            /*$userAddRepo->sumOfAllPoints($user);*/
            //$user->give_profile_filled($profile);
        }

    }



}
