<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    'mailgun_privacy' => [
        'domain' => env('MAILGUN_PRIVACY_DOMAIN'),
        'secret' => env('MAILGUN_PRIVACY_SECRET'),
        'endpoint' => env('MAILGUN_PRIVACY_ENDPOINT', 'api.mailgun.net'), 
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\Auth\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
        'webhook' => [
            'secret' => env('STRIPE_WEBHOOK_SECRET'),
            'tolerance' => env('STRIPE_WEBHOOK_TOLERANCE', 300),
        ],
    ],

    /*
     * Socialite Credentials
     * Redirect URL's need to be the same as specified on each network you set up this application on
     * as well as conform to the route:
     * http://localhost/public/login/SERVICE
     * Where service can github, facebook, twitter, google, linkedin, or bitbucket
     * Docs: https://github.com/laravel/socialite
     * Make sure 'scopes' and 'with' are arrays, if their are none, use empty arrays []
     */
    'bitbucket' => [
        'active'        => env('BITBUCKET_ACTIVE'),
        'client_id'     => env('BITBUCKET_CLIENT_ID'),
        'client_secret' => env('BITBUCKET_CLIENT_SECRET'),
        'redirect'      => env('BITBUCKET_REDIRECT'),
        'scopes'        => [],
        'with'          => [],
    ],

    'facebook' => [
        'active'        => env('FACEBOOK_ACTIVE'),
        'client_id'     => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),

        //vineet facbook credientials
        //'client_id'     => "1222744891614408",
        //'client_secret' => "743d72e6b14a3f95ef51c2f3cab52b0f",
        'redirect'      => env('FACEBOOK_REDIRECT'),
        'scopes'        => [],
        'with'          => [],
        'fields'        => [],
        
    ],

    'github' => [
        'active'        => env('GITHUB_ACTIVE'),
        'client_id'     => env('GITHUB_CLIENT_ID'),
        'client_secret' => env('GITHUB_CLIENT_SECRET'),
        'redirect'      => env('GITHUB_REDIRECT'),
        'scopes'        => [],
        'with'          => [],
    ],

    'google' => [
        'active'        => env('GOOGLE_ACTIVE'),
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        // 'client_id'     => "703530263342-csh0v5s2oaqgtut2t411qddmsm3fj1om.apps.googleusercontent.com",
        // 'client_secret' => "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",
        'redirect'      => env('GOOGLE_REDIRECT'),

        /*
         * Only allows google to grab email address
         * Default scopes array also has: 'https://www.googleapis.com/auth/plus.login'
         * https://medium.com/@njovin/fixing-laravel-socialite-s-google-permissions-2b0ef8c18205
         */
       'scopes' => [

            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile',
        ],
        'fields'        => [],
        'with' => ['prompt' => 'consent', 'access_type' => 'offline', 'include_granted_scopes' => 'true'],
    ],

    'linkedin' => [
        'active'        => env('LINKEDIN_ACTIVE'),
        'client_id'     => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect'      => env('LINKEDIN_REDIRECT'),
        'scopes'        => [],
		'with'          => [],
		'fields'        => [],
    ],

    'twitter' => [
        'active'        => env('TWITTER_ACTIVE'),
        'client_id'     => env('TWITTER_CLIENT_ID'),
        'client_secret' => env('TWITTER_CLIENT_SECRET'),
        'redirect'      => env('TWITTER_REDIRECT'),
        'scopes'        => [],
        'with'          => [],
    ],

];
