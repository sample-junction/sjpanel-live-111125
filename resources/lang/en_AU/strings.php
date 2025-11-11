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
            "welcome" => "Welcome"
        ],
        "general" => [
            "all_rights_reserved" => "All Rights Reserved.",
            "are_you_sure" => "Are you sure you want to do this?",
            "boilerplate_link" => "Laravel 5 Boilerplate",
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
            "click_to_confirm" => "Just confirm your email to get started!",
            "confirmation" => [
                "copyright" => "Copyright",
                "details_1" => "We've finished setting up your SJ Panel account.",
                "details_2" => "Just confirm your email to get started!",
                "faq" => "FAQ's",
                "greeting" => "Hey",
                "heading" => "You're ready to go!",
                "how_it_works" => "How it works",
                "rewards" => "Rewards",
                "unsubscribe" => "Unsubscribe",
                "com_details_3" => "We noticed that you have joined SJ Panel but still have not completed the registration process. Please complete the registration process of your SJ Panel account by simply clicking the button below. so that you can start taking surveys and earn maximum rewards.",
                "com_details_3a" => "By doing so, you'll unlock access to a world of exciting surveys where your opinion truly matters, and you'll earn a fantastic $2.3 (1400 Points) just for getting started!", 
                "com_details_4"=>"points.",
                "doi_reminder" => "Reminder:",
                "doi_success"=>"Successful",
                "doi_fail"=>"No Record Found"

            ],
            "error" => "Whoops!",
            "greeting" => "Hey!",
            "password_cause_of_email" => "You are receiving this email because we received a password reset request for your account.",
            "password_if_not_requested" => "If you did not request a password reset, please report at help@sjpanel.com",
            "password_reset_subject" => "Reset Password",
            "regards" => "Regards,",
            "reset_password" => "Click here to reset your password",
            "thank_you_for_using_app" => "Thank you for using our application!",
            "trouble_clicking_button" => "If you’re having trouble clicking the \":action_text\" button, copy and paste the URL below into your web browser:"
        ],
        "contact" => [
            "email_body_title" => "You have a new contact form request: Below are the details:",
            "subject" => "A new :app_name contact form submission!"
        ]
    ],
    "frontend" => [
        "disclaimer" => "You have received this mail because you are registered with us as a Panel member and have consented to received email communication for receiving surveys and earn rewards. You can always unsubscribe from our mailing list, by clicking on",
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
            "profile_updated" => "Profile successfully updated."
        ],
        "welcome_to" => "Welcome to :place"
    ]
];
