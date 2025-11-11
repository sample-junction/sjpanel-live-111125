<?php
return [
    'RECAPTCHA_SITE_KEY' => env('INVISIBLE_RECAPTCHA_SITEKEY', '6Lcqcp0UAAAAABYZtVo4ayjR_WEwt_UMcKLpuy76'),
    'RECAPTCHA_SECRET_KEY' => env('INVISIBLE_RECAPTCHA_SECRETKEY', '6Lcqcp0UAAAAANmlUp9Oi_8iYYEolxdB0DNOmX2w'),
    'APACE' => [
        'API_URL' => env('APACE_API_URL', 'http://apace_new.local'),
        'API_KEY' => env('APACE_API_KEY', '5F4943277A063EF26D25D7BBC57298FFB2029915'),
    ],
    'EMAIL_QUALITY_SCORE' => env('IP_QUALITY_SCORE', 'zYC1jnxggPR7OxLZhhYWZl9YSYqAZQYk'),
    'EMAIL_QUALITY_URL' => env('IP_QUALITY_URL', 'https://ipqualityscore.com/api/json/email'),
    /**
     * Added by RAS (17-01-2024) for SJPL198
     */
    'EMAIL_QUALITY_SCORE_TOKENS' => [
        'eaPUhM5WpxvoNCsB75gMaLhCS2SNfgpu',
        '83I4IhOJq5DrEGl9zCHakWMv1FTMfbzs',
        'sgbHcK1yarTAl7UGY3qHDpor73F5SaAi',
        'sAJBTqymbi5o95VrSuh3SW1lLf8En3OG',
        'GqxHGFffC9nc8Q8BSPbz4z0P6D8htyno',
    ],

    /**
     * Add code by Vikash Yadav (29-12-2022)
     */
    'redemption_status' => [
        'redeem_request'  => 'Redemption Requested',
        'redeem_approved' => '<b style="color:green;">Redemption Approved</b>',
        'redeem_notified' => 'Redemption Process Started',
        'redeem_sent'     => 'Voucher sent by Rybbon on your email',
        'redeem_coupon'   => 'Coupon Redeemed',

    ],
    'redirectsurveydashboard' => [
        'set_time'  => 25,   //Set time in seconds    
    ],
    'dfiq' => [
        'status'  => 1,   //Set DFIQ 1 => ON,0=>OFF    
    ],
    'redeemRequestCondition' => [
        'check_multiply'  => 1000,   //check for redeem request multiply condition     
    ],
    'dummyNames_1' => [
        'Ank** Gu***',
        'Tra** Tra***',
        'Lau** Ree***',
        
    ],
    'dummyNames_2' => [
        'Ankit *****',
        'Tracy *****',
        'Laura *****',
        'Steven *****',
        'Jason  *****',
        'Shelby *****',
        'Patricia *****',
        'Janice  *****',
        'Mendifer *****',
       
    ],
    'dummyNames_3' => [
        'Patri*** Cornel******',
        'Jan*** Schw******',
        'Men***** Hub***',
       
    ],
    'dummyID_1' => [
        '2306******01',
        '2402******01',
        '2402******02',
       
        
    ],
    'dummyID_2' => [
        '230606090001',
        '240203340001',
        '240206100002',
        '240207250008',
        '240207450005',
        '240305010009',
        '240311150001',
        '240322490004',
        '240510360010',

    ],
    'dummyID_3' => [
        '2403******01',
        '2403******04',
        '2403******10',
       
    ],
    'dummyState_2' => [
        'Pioneer, CA',
        'Grandview, MO',
        'Rayne, LA',
        'Gorham, ME',
        'Indianapolis, IN',
        'Phoenix, AZ',
        'Salisbury, MD',
        'Mcconnelsville, OH',
        'Grove City, OH',

    ],

    'dummyID_3' => [
        '2403******01',
        '2403******04',
        '2403******10',
       
    ],
    'dummyState_2' => [
        'Pioneer, CA',
        'Grandview, MO',
        'Rayne, LA',
        'Gorham, ME',
        'Indianapolis, IN',
        'Phoenix, AZ',
        'Salisbury, MD',
        'Mcconnelsville, OH',
        'Grove City, OH',
        
    ],

    'dummyAmount_1' => [
        '$15',
        '$25',
        '$30',

        
    ],

    'dummyState_2' => [
        'Pioneer, CA',
        'Grandview, MO',
        'Rayne, LA',
        'Gorham, ME',
        'Indianapolis, IN',
        'Phoenix, AZ',
        'Salisbury, MD',
        'Mcconnelsville, OH',
        'Grove City, OH',

        
    ],

    'dummyAmount_2' => [
        '$15',
        '$25',
        '$30',
        '$11',
        '$23',
        '$26',
        '$11',
        '$30',
        '$6',
        
    ],
    'dummyAmount_3' => [
        '$11',
        '$30',
        '$6',
      
        
    ],
    'centralize_server_image' => 'https://app.sjpanel.com/'
];
