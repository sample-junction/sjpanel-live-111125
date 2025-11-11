<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 4/4/2019
 * Time: 10:04 PM
 */

namespace App\Helpers\Inpanel\Auth;


class Socialite
{
    public function getSocialLinks()
    {
        $socialite_enable = [];
        $socialite_links = '';
        if (config('services.bitbucket.active')) {
            $socialite_enable[] = "<a href='".route('frontend.auth.social.login', 'bitbucket')."' class='btn btn-sm btn-outline-info m-1'><i class='fab fa-bitbucket'></i>  ".__('labels.frontend.auth.login_with', ['social_media' => 'BitBucket']).'</a>';
        }
        return $socialite_links;
    }

    /**
     * List of the accepted third party provider types to login with.
     *
     * @return array
     */
    public function getAcceptedProviders()
    {
        return [
            'github',
            'facebook',
        ];
    }
}
