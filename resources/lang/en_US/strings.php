<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "Are you sure you want to delete this user permanently? Anywhere in the application that references this user's id will most likely error. Proceed at your own risk. This can not be un-done.",
                "if_confirmed_off" => "(If confirmed is off)",
                "no_deactivated" => "There are no deactivated users.",
                "no_deleted" => "There are no deleted users.",
                "restore_user_confirm" => "Restore this user to its original state?"
            ]
        ],
        "dashboard" => [
            "title" => "Dashboard",
            "welcome" => "Welcome",
            "default_heading" => "Dashboard report show with default for last :dashboard_days days"
        ],
        "general" => [
            "all_rights_reserved" => "All Rights Reserved.",
            "are_you_sure" => "Are you sure you want to do this?",
            "boilerplate_link" => "SJPanel",
            "continue" => "Continue",
            "member_since" => "Member since",
            "minutes" => "minutes",
            "search_placeholder" => "Search...",
            "see_all" => [
                "messages" => "See all messages",
                "notifications" => "View all",
                "tasks" => "View all tasks"
            ],
            "status" => [
                "offline" => "Offline",
                "online" => "Online"
            ],
            "timeout" => "You were automatically logged out for security reasons since you had no activity in",
            "you_have" => [
                "messages" => "{0} You don't have messages|{1} You have 1 message|[2,Inf] You have :number messages",
                "notifications" => "{0} You don't have notifications|{1} You have 1 notification|[2,Inf] You have :number notifications",
                "tasks" => "{0} You don't have tasks|{1} You have 1 task|[2,Inf] You have :number tasks"
            ]
        ],
        "search" => [
            "empty" => "Please enter a search term.",
            "incomplete" => "You must write your own search logic for this system.",
            "results" => "Search Results for :query",
            "title" => "Search Results"
        ],
        "welcome" => "<p>This is the CoreUI theme by <a href=\"https://coreui.io/\" target=\"_blank\">creativeLabs</a>. This is a stripped down version with only the necessary styles and scripts to get it running. Download the full version to start adding components to your dashboard.</p>\n <p>All the functionality is for show with the exception of the <strong>Access</strong> to the left. This boilerplate comes with a fully functional access control library to manage users & roles powered by <a href=\"https://github.com/spatie/laravel-permission\" target=\"_blank\">spatie/laravel-permission</a>.</p>\n <p>Keep in mind it is a work in progress and their may be bugs or other issues I have not come across. I will do my best to fix them as I receive them.</p>\n <p>Hope you enjoy all of the work I have put into this. Please visit the <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"_blank\">GitHub</a> page for more information and report any <a href=\"https://github.com/rappasoft/Laravel-5-Boilerplate/issues\" target=\"_blank\">issues here</a>.</p>\n <p><strong>This project is very demanding to keep up with given the rate at which the master Laravel branch changes, so any help is appreciated.</strong></p>\n <p>- Anthony Rappa</p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Your account has been confirmed.",
            "click_to_confirm" => "Click here to confirm your account:",
            "confirmation" => [
                "copyright" => "Copyright",
                "copyrightcompany" => "Sample Junction Canada Inc",
                // "link_content1" => "You are receiving this email because you are a registered member of SJ Panel where we reward you through incentives for taking part in online surveys. If you do not wish to receive any future email from SJ Panel, please Unsubscribe to de-activate your account. As soon as you unsubscribe from SJ Panel, your account will be deleted within 72 hours and you will stop receiving emails from SJ Panel. In case you need any technical support, please write to our team at",
                // "mail_content" => "To receive our emails in your inbox & avoid spam, please add",
               // "link_content" => "to your safe sender list.",
                "link" => "donotreply@sjpanel.com",
                "link1" => "support@sjpanel.com",
                "all_right" => 'All rights reserved.',
                "com_details_1" => "Your SJ Panel account is now active! Confirm your account by clicking the button below to gain full access to SJ Panel's features and earn ",
                // "com_details_1" => "Your SJ Panel account is still not active. Confirm your account by clicking the button below to gain full access to SJ Panel's features and earn ",
                "tmp_1_details_sub1" => "Thanks for joining SJ Panel. ",
                "tmp_1_details_sub2" => "Our data shows that you have not confirmed your registration yet. Please confirm your registration by confirming your email ID.",
                "tmp_1_details_2" => "In addition, we are offering <b>Welcome Back</b> reward up to ",
                "tmp_1_details_3" => "After confirming your email ID, simply log in with your SJ Panel account details and fulfil the following tasks : ",
                "tmp_1_details_4" => "1.	Complete your profiling surveys and earn $3 gift coupon",
                "tmp_1_details_5" => "2.	Complete at least 1 live survey and earn $2 gift coupon",
                "tmp_1_details_6" => "If you complete both the tasks, you will be eligible for <b>additional $5 gift coupon</b> apart from your regular survey points.",
                "tmp_1_confirm_button" => "Confirm your email ID",
                "tmp_1_details_7" => '<i>Note: Please visit “Surveys” page for more exciting surveys and chance to earn maximum rewards. For better survey experience, kindly make sure you have updated all your detailed profile. </i>',
                "tmp_2_details_sub2" => "Our data shows that you have not completed your profiling surveys. We send you surveys according to your profile. It’s very important that you fill all the details accordingly for better survey experience and maximum rewards. ",
                "tmp_2_details_3" => "Simply log in with your SJ Panel account details and fulfil the following tasks.",
                "tmp_2_details_4" => "1.	Complete your profiling surveys and earn additional $3 gift coupon",
                "tmp_2_details_5" => "2.	Complete at least 2 live surveys and earn additional $2 gift coupon",
                "tmp_2_confirm_button" => "Login Now",
                "tmp_2_details_7" => '<i>Note: Please visit “Surveys” page for more exciting surveys and chance to earn maximum rewards. For better survey experience, kindly make sure you have updated all your detailed profile. </i>',
                "tmp_3_details_sub2" => "Our data shows that you have completed all your profiling surveys but still not have completed a single survey so far. ",
                "tmp_3_details_2" => "As a valued panellists, we are offering <b>Welcome Back</b> reward up to ",
                "tmp_3_details_4" => "1.	Complete at least 2 live surveys and earn $3 gift coupon",
                "tmp_3_details_5" => "2.	Refer to at least 5 People and earn $2 gift coupon",
                "tmp_3_details_7" => '<i>Note: Please visit “Surveys” page for more exciting surveys and chance to earn maximum rewards. For additional and maximum reward, kindly make sure your referrals join our panel and complete a survey.</i>',

                "com_details_3" => "We noticed that you have joined SJ Panel but still have not completed the registration process. Please complete the registration process of your SJ Panel account by simply clicking the button below. so that you can start taking surveys and earn maximum rewards.",
                "com_details_3a" => "By doing so, you'll unlock access to a world of exciting surveys where your opinion truly matters, and you'll earn a fantastic $1.4 (1400 Points) just for getting started!",
                "com_details_4"=>"points.",
                "doi_reminder" => "Reminder:",
                "doi_success"=>"Successful",
                "doi_fail"=>"No Record Found",

                "contact_detail" => "If you did not send any request kindly send a mail to",
                "com_details_2" => " Points:",
                //"details_2" => "If the link is not working then copy and paste it in your browser and hit enter. If it still does not work please write to support@sjpanel.com",
                "details_2" =>"Just confirm your email to get started!",
                "details_3"=>"“Not everyone needs to be in Defence services or NGOs to serve one's country.
                You may do it by just giving HONEST and UNBIASED opinion on surveys to enable the businesses make better products and services for the world.”",
                "delete_details_1" => "We received request from you to deactivate account. All your data with us will be deleted.",
                "userinfo_delete_details_1" => "We have received a request from you to delete your personal information  stored with us. If you genuinely requested for deletion of your personal information, please click the button below as your final confirmation else please report this to our support team at support@sjpanel.com.",
                "userinfo_delete_details_3" => "We have recently received a request from you to delete your personal information that is stored with us. Ensuring the security and privacy of your data is of utmost importance to us, and we are committed to fulfilling your request promptly.",
                "userinfo_delete_details_4" => "To finalize the deletion of your personal information, please click the",
                 "dele" => "Delete",
                 "userinfo_delete_details_6"=> "button below:",
                "userinfo_delete_details_5" => "If you did not make this request or have any concerns about this action, please do not hesitate to report it to our dedicated support team at",
                "userinfo_delete_details_7" => "We are here to assist you and address any questions or issues you may have.",
                "delete_details_2" => "If you genuinely requested to deactivate your account, please click the button below as your final confirmation else please report to our support team at support@sjpanel.com.",
                "delete_details_3" => "We hope this message finds you well. We wanted to inform you that we have received a deactivation request for your SJ Panel account.",
                "delete_details_4" => "If you indeed requested the deactivation of your account, please click the button below to provide your final confirmation:",
                "delete_details_5" => "If this deactivation request was not initiated by you, or if you have any concerns, please do not hesitate to report it to our dedicated support team at support@sjpanel.com. We are here to assist you and ensure the security of your account.",
                "userinfo_delete_details_2" => "If you did not request to delete your personal information click here.",
                "confirm_button" => "Confirm",
                "faq" => "FAQ's",
                "greetings" => "Hi",
                "dear" => "Dear",
                "heading" => "You're ready to go!",
                "how_it_works" => "How it works",
                "rewards" => "Start The Survey",
                "safeguards" => "Safeguards",
                "cookie" => "Cookie Policy",
                "unsubscribe" => "Unsubscribe",
                "footer" => "Happy Survey Taking!",
                "footer_1" => "To receive our emails in your inbox & avoid spam, please add ",
                "contact"=>"Contact",
                "deactivate_content_1" => "We hope this message finds you well. We wanted to inform you that we have received a deactivation request for your SJ Panel account.",
                "deactivate_content_2" => "If you indeed requested the deactivation of your account, please click the button below to provide your final confirmation:",
                "deactivate_content_3" => "If this deactivation request was not initiated by you, or if you have any concerns, please do not hesitate to report it to our dedicated support team at ",
                "deactivate_content_4" => "We are here to assist you and ensure the security of your account.",
                "person_delete" => "We are writing to inform you that your request to delete your personal information, which was stored with us, has been successfully processed. As per your request, we have permanently removed all of your personal data from our records, and your account has also been deleted.",
                "person_delete1" => "Should you decide to rejoin SJ Panel in the future, we kindly request that you create a new login, and we will be delighted to welcome you back as a member.",
                "person_delete2" => "If you have any questions or require further assistance, please do not hesitate to reach out to us at ",
                "person_delete3" =>" We are here to help.",
                "Minutes" => "Minutes",
                "Enter"=> "Enter"

            ],
            "error" => "Whoops!",
            "greeting" => "Hello!",
            "password_cause_of_email" => "You are receiving this email because we received a password reset request for your account.",
            "password_cause_of_email_new" => "We received a request from you to reset your password. To proceed click here.",
            "password_cause_of_email_new1" => "We have received a password reset request from you. To proceed, please click the link below:",
            "password_cause_of_email_new2" => "If you did not initiate this request, please contact our support team at",             
             "password_cause_of_email_new4"=> "immediately.",
            "password_cause_of_email_new3" => "Thank you for choosing SJ Panel!",
            "password_if_not_requested" => "If you did not request a password reset, please report at help@sjpanel.com",
            "password_if_not_requested_new" => "If you did not send any request kindly send a mail to",
            "password_reset_subjects" => "Password Reset Request",
            "regards" => "Regards,",
            "reset_password" => "Click here to reset your password",
            "thank_you_for_using_app" => "Thank you for using our application!",
            "trouble_clicking_button" => "If you’re having trouble clicking the \":action_text\" button, copy and paste the URL below into your web browser:"
        ],
        "contact" => [
            "email_body_title" => "You have a new contact form request: Below are the details:",
            "subject" => "A new :app_name contact form submission!"
        ],
        "fraud_mail" => [
            "greeting" => "Dear",
            "greeting_title" => "Greetings from SJ Panel!",
            "body_details" => "Our client has found your responses for survey number :survey_number unacceptable and suspicious.",
            "body_details_1" => "We request you to go through our",
            "body_details_2" => "clause number 4 & 5 in order to know the consequences of being marked as a fraud in our panel.",
            "body_details_3" =>"If you have any questions or concerns over this, please feel free to reach us through email at support@samplejunction.com.",
            "list_details" => "Attempting the survey which is currently not available",
            "list_details_1" => "Attempting the survey from unregistered email",
            "list_details_2" => "Attempting the survey from a country not matching your profile",
            "list_details_3" => "Attempting the survey from invalid survey link",
            "list_details_4" => "Attempting the survey more than once",
            "list_details_5" => "Trying or competing a survey through unfair means",
            "subject" => "A new :app_name contact form submission!",
            "subject_fraud"=>'Fraudulent activity observed with your account',
            "subject_backlist"=>'Attention:Your account has been permanently suspended.',
            "subject_welcome"=>'Welcome to SJ Panel!',
            
        ],
        "blacklist_mail" => [
            "body_details" => "Unfortunately, We have to permanently suspend your account with us for your responses being marked as fraudulent :fraudulent_count times.",
            "body_details_1" => "Your account was involved in activities which are against our panel quality standards. As the consequence, neither you will be able to participate in any survey nor you will be able to claim any incentive. All your incentives will be forfeited as per our",
            "body_details_2" => "and you will not be able to claim it.",
            "body_details_3" =>"If you have any questions or concerns over this, please feel free to reach us at support@samplejunction.com.",
        ]
    ],
    "frontend" => [
        "disclaimer" => "You are receiving this email because you are a registered member of SJ Panel where we reward you through incentives for taking part in online surveys. If you do not wish to receive any future email from SJ Panel, please Unsubscribe to de-activate your account. As soon as you unsubscribe from SJ Panel, your account will be deleted within 72 hours and you will stop receiving emails from SJ Panel. In case you need any technical support, please write to our team at",
        "disclaimer_1" => "SJ Panel Team",
        "general" => [
            "joined" => "Joined"
        ],
        "test" => "Test",
        "tests" => [
            "based_on" => [
                "permission" => "Permission Based -",
                "role" => "Role Based -"
            ],
            "js_injected_from_controller" => "Javascript Injected from a Controller",
            "using_access_helper" => [
                "array_permissions" => "Using Access Helper with Array of Permission Names or ID's where the user does have to possess all.",
                "array_permissions_not" => "Using Access Helper with Array of Permission Names or ID's where the user does not have to possess all.",
                "array_roles" => "Using Access Helper with Array of Role Names or ID's where the user does have to possess all.",
                "array_roles_not" => "Using Access Helper with Array of Role Names or ID's where the user does not have to possess all.",
                "permission_id" => "Using Access Helper with Permission ID",
                "permission_name" => "Using Access Helper with Permission Name",
                "role_id" => "Using Access Helper with Role ID",
                "role_name" => "Using Access Helper with Role Name"
            ],
            "using_blade_extensions" => "Using Blade Extensions",
            "view_console_it_works" => "View console, you should see 'it works!' which is coming from FrontendController@index",
            "you_can_see_because" => "You can see this because you have the role of ':role'!",
            "you_can_see_because_permission" => "You can see this because you have the permission of ':permission'!"
        ],
        "user" => [
            "change_email_notice" => "If you change your e-mail you will be logged out until you confirm your new e-mail address.",
            "email_changed_notice" => "You must confirm your new e-mail address before you can log in again.",
            "password_updated" => "Password successfully updated.",
            "profile_updated" => "Profile successfully updated.",
            "password_updated_message" => "Password changed successfully please login with your updated password.",
        ],
        "welcome_to" => "Welcome to :place"
    ]
];
