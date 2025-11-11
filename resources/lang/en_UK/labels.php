<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "create" => "Create Role",
                "edit" => "Edit Role",
                "management" => "Role Management",
                "table" => [
                    "number_of_users" => "Number of Users",
                    "permissions" => "Permissions",
                    "role" => "Role",
                    "sort" => "Sort",
                    "total" => "role total|roles total"
                ]
            ],
            "users" => [
                "active" => "Active Users",
                "all_permissions" => "All Permissions",
                "change_password" => "Change Password",
                "change_password_for" => "Change Password for :user",
                "create" => "Create User",
                "deactivated" => "Deactivated Users",
                "deleted" => "Deleted Users",
                "edit" => "Edit User",
                "management" => "User Management",
                "no_permissions" => "No Permissions",
                "no_roles" => "No Roles to set.",
                "permissions" => "Permissions",
                "total_panelists" => "Total panelists",
                "table" => [
                    "confirmed" => "Confirmed",
                    "doi" => "DOI",
                    "country" => "Country",
                    "created" => "Created",
                    "email" => "E-mail",
                    "first_name" => "First Name",
                    "id" => "ID",
                    "last_name" => "Last Name",
                    "last_updated" => "Last Updated",
                    "name" => "Name",
                    "no_deactivated" => "No Deactivated Users",
                    "no_deleted" => "No Deleted Users",
                    "other_permissions" => "Other Permissions",
                    "permissions" => "Permissions",
                    "roles" => "Roles",
                    "social" => "Social",
                    "total" => "user total|users total",
                    "uuid" =>"UUID",
                    "panelistid" =>"Panelist Id",
                    "age" =>"Age",
                    "gender" =>"Gender",
                    "fraud_count" => "Fraud Count",
                    "project_code" => "Project Code",
                    "action" => "Action",
                    "reset" => "Reset",
                    "bulk_search" => "Bulk Search",
                    "export_profiles" => "Export Profiles",
                    "bulk_mark" => "Bulk Mark Fraud",
                    "search" => "Search",
                    "search_type" => "Search Type",
                    "select_type" => "Select Search Type",
                    "user_ids" => "Userids",
                    "apply" => "Apply",
                    "add_fraud" => "Add Fraud",
                    "project_code" => " Fraud Project Code",
                    "reason" => "Reason",
                    "enter_reason" => "Enter Reason",
                    "bulk_upload" => "Bulk Upload Excel(Only CSV)",
                    "sample_excel" => "Download Sample Excel",
                    "upload_excel" => "Upload Excel (Only CSV)",
                    "upload" => "Upload",
                    "fraud" => "Fraud",
                    "export_profile" => "Export Profile",
                    "country_code" => "Country Code",
                    "export" => "Export",
                    //modified by obhi
                    "locale"=>"Language",
                    "Latest_update"=>"Latest Update (profile, Social, Password Changed)",
                    "Last_login"=>"Last Login",
                    "last_survey_taken"=>"Last Survey Taken",
                    "Doi_reminder"=>"Remind DOI",
                    "fisrt_name"=>"First Name",
                    "last_name"=>"Last Name",
                    "recent_activity"=>"Recent Activity",
                    "profile_filled"=>"Profile filled",
                    "no_of_profile_filled"=>"Number Of Profile Filled",
                    "total_no_of_survey_attempted"=>"Total No Of Survey Attempted",
                    "last_survey_complete_on"=>"Last survey completion date",
                    "last_survey_status"=>"Last Survey Status",
                    "total_no_of_survey_complete"=>"Total Number of Survey Completed",
                    "joining_date"=>"Joining Date",
                    "latest_update_activity"=>"Latest Updated Activity (profile, Social, Password Changed)",
                    "recent_activity_date"=>"Recent Activity Date And Time",
                    "channel"=>"Survey Taken Channel Name",
                    //modified by obhi
                    "zipcode"=>"Zipcode",
                    "city_state"=>"City & State",
                    "unsubscribed"=>"Unsubscribed",
                    "deactivated"=>"Deactivated",
                    "SOI"=>"SOI",
                    "DOI"=>"DOI",
                   
                ],
                "tabs" => [
                    "content" => [
                        "overview" => [
                            "avatar" => "Avatar",
                            "confirmed" => "Confirmed",
                            "created_at" => "Created At",
                            "deleted_at" => "Deleted At",
                            "email" => "E-mail",
                            "first_name" => "First Name",
                            "last_login_at" => "Last Login At",
                            "last_login_ip" => "Last Login IP",
                            "last_name" => "Last Name",
                            "last_updated" => "Last Updated",
                            "name" => "Name",
                            "status" => "Status",
                            "timezone" => "Timezone"
                        ]
                    ],
                    "titles" => [
                        "history" => "History",
                        "overview" => "Overview"
                    ]
                ],
                "view" => "View User"
            ],
            "reports" => [
                "active" => "Active Users",
                "all_permissions" => "All Permissions",
                "deleted" => "Deleted Users",
                "edit" => "Edit User",
                "management" => "User Management",
                "no_permissions" => "No Permissions",
                "no_roles" => "No Roles to set.",
                "permissions" => "Permissions",
                "table" => [
                    "total_earned" => "Total Earned(SJ Panel Points)",
                    "total_invite_sent" => "Total Invite Sent",
                    "total_click_start" => "Total Click/Start",
                    "response_rate" => "Response Rate(%)",
                    "project_code" => "Project Code",
                    "status" => "Status",
                    "uuid" =>"UUID",
                    "panelistid" =>"PanellistId",
                    "age" =>"Age(In Years)",
                    "gender" =>"Gender"
                ],
                "titles" => [
                    "response_rate_title" => "Panellist Response Rate",
                    "active_panelists" => "Active Panellist",
                    "rejection" => "Rejection",
                    "incentive_distribution" => "Incentive Distribution",
                    "survey" => "Survey Status Report",
                    "panelist_management" => "Panelist Master",
                    "monthly_award" => "Monthly Award Data",
                    "survey_details" => "Survey Details",
                    "new_survey_report" => "Survey Report"
                ],
            ],
            "setting" => [
                
                "management" => "Setting Management",
                "table" => [
                    "total_earned" => "Total Earned(SJ Panel Points)",
                    "total_invite_sent" => "Total Invite Sent",
                    "total_click_start" => "Total Click/Start",
                    "response_rate" => "Response Rate(%)",
                    "project_code" => "Project Code",
                    "status" => "Status",
                    "uuid" =>"UUID",
                    "panelistid" =>"PanellistId",
                    "age" =>"Age(In Years)",
                    "gender" =>"Gender"
                ],
                "titles" => [
                    "active_fraud_title" => "Active Fraud Setting",
                    "point_system_title" => "Point System Setting"
                ],
            ],
        ],
        "affiliate" => [
            "campaign" => "Campaign",
            "campaign_data" => "Campaign Data",
            "list" => "List"
        ]
    ],
    "frontend" => [
        "auth" => [
            "disclaimer_checkbox" => "By clicking on this checkbox you understand and agree to our",
            "login_box_title" => "Login",
            "login_button" => "Login",
            "login_with" => "Login with :social_media",
            "signup_with" => "Sign up with :social_media",
            "register_box_title" => "Register",
            "register_button" => "Register",
            "checkbox_register" => "I accept the",
            "remember_me" => "Remember Me"
        ],
        "contact" => [
            "box_title" => "Contact Us",
            "button" => "Send Information"
        ],
        "passwords" => [
            "expired_password_box_title" => "Your password has expired.",
            "forgot_password" => "Forgot Your Password?",
            "reset_password_box_title" => "Reset Password",
            "reset_password_button" => "Reset Password",
            "send_password_reset_link_button" => "Send Password Reset Link",
            "sub_label" => "You can reset your password here.",
            "update_password_button" => "Update Password"
        ],
        "user" => [
            "passwords" => [
                "change" => "Change Password"
            ],
            "profile" => [
                "avatar" => "Avatar",
                "created_at" => "Created At",
                "edit_information" => "Edit Information",
                "email" => "E-mail",
                "first_name" => "First Name",
                "last_name" => "Last Name",
                "last_updated" => "Last Updated",
                "name" => "Name",
                "update_information" => "Update Information"
            ]
        ]
    ],
    "general" => [
        "actions" => "Actions",
        "active" => "Active",
        "all" => "All",
        "buttons" => [
            "save" => "Save",
            "update" => "Update"
        ],
        "copyright" => "Copyright",
        "custom" => "Custom",
        "hide" => "Hide",
        "inactive" => "Inactive",
        "more" => "Actions",
        "no" => "No",
        "none" => "None",
        "show" => "Show",
        "toggle_navigation" => "Toggle Navigation",
        "yes" => "Yes"
    ]
];
