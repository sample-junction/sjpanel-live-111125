<?php

return [
    "accepted" => "The :attribute must be accepted.",
    "active_url" => "The :attribute is not a valid URL.",
    "after" => "The :attribute must be a date after :date.",
    "after_or_equal" => "The :attribute must be a date after or equal to :date.",
    "alpha" => "The :attribute may only contain letters.",
    "alpha_dash" => "The :attribute may only contain letters, numbers, dashes and underscores.",
    "alpha_num" => "The :attribute may only contain letters and numbers.",
    "array" => "The :attribute must be an array.",
    "attributes" => [
        "session_expired" => "Your session has expired. Please log in again to access the dashboard.",
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "Associated Roles",
                    "dependencies" => "Dependencies",
                    "display_name" => "Display Name",
                    "first_name" => "First Name",
                    "group" => "Group",
                    "group_sort" => "Group Sort",
                    "groups" => [
                        "name" => "Group Name"
                    ],
                    "last_name" => "Last Name",
                    "name" => "Name",
                    "system" => "System"
                ],
                "roles" => [
                    "associated_permissions" => "Associated Permissions",
                    "name" => "Name",
                    "sort" => "Sort"
                ],
                "users" => [
                    "active" => "Active",
                    "associated_roles" => "Associated Roles",
                    "confirmed" => "Confirmed",
                    "email" => "E-mail Address",
                    "first_name" => "First Name",
                    "language" => "Language",
                    "last_name" => "Last Name",
                    "name" => "Name",
                    "other_permissions" => "Other Permissions",
                    "password" => "Password",
                    "password_confirmation" => "Confirm Password",
                    "send_confirmation_email" => "Send Confirmation E-mail",
                    "timezone" => "Timezone"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "Avatar Location",
            "email" => "E-mail Address",
            "first_name" => "First Name",
            "middle_name" => "Middle Name",
            "language" => "Language",
            "last_name" => "Last Name",
            "message" => "Message",
            "name" => "Full Name",
            "new_password" => "New Password",
            "new_password_confirmation" => "New Password Confirmation",
            "old_password" => "Old Password",
            "password" => "Password",
            "password_confirmation" => "Confirm Password",
            "phone" => "Phone",
            "timezone" => "Timezone",
            "first_name1" => "First Name is required",
            "first_name2" => "Enter only alphabets",
            "last_name1" => "Last Name is required",
            "is_age" => "Minimum age to join our panel is 18 years. Kindly come back when you meet the minimum age requirement",
            "max_age_limit" => "Please enter a valid age.",
        ]
    ],
    "before" => "The :attribute must be a date before :date.",
    "before_or_equal" => "The :attribute must be a date before or equal to :date.",
    "between" => [
        "array" => "The :attribute must have between :min and :max items.",
        "file" => "The :attribute must be between :min and :max kilobytes.",
        "numeric" => "The :attribute must be between :min and :max.",
        "string" => "The :attribute must be between :min and :max characters."
    ],
    "boolean" => "The :attribute field must be true or false.",
    "confirmed" => "The :attribute confirmation does not match.",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "custom-message"
        ]
    ],
    "date" => "The :attribute is not a valid date.",
    "date_equals" => "The :attribute must be a date equal to :date.",
    "date_format" => "The :attribute does not match the format :format.",
    "different" => "The :attribute and :other must be different.",
    "digits" => "The :attribute must be :digits digits.",
    "digits_between" => "The :attribute must be between :min and :max digits.",
    "dimensions" => "The :attribute has invalid image dimensions.",
    "distinct" => "The :attribute field has a duplicate value.",
    "email" => "The :attribute must be a valid email address.",
    "exists" => "The selected :attribute is invalid.",
    "file" => "The :attribute must be a file.",
    "filled" => "The :attribute field must have a value.",
    "gt" => [
        "array" => "The :attribute must have more than :value items.",
        "file" => "The :attribute must be greater than :value kilobytes.",
        "numeric" => "The :attribute must be greater than :value.",
        "string" => "The :attribute must be greater than :value characters."
    ],
    "gte" => [
        "array" => "The :attribute must have :value items or more.",
        "file" => "The :attribute must be greater than or equal :value kilobytes.",
        "numeric" => "The :attribute must be greater than or equal :value.",
        "string" => "The :attribute must be greater than or equal :value characters."
    ],
    "image" => "The :attribute must be an image.",
    "in" => "The selected :attribute is invalid.",
    "in_array" => "The :attribute field does not exist in :other.",
    "integer" => "The :attribute must be an integer.",
    "ip" => "The :attribute must be a valid IP address.",
    "ipv4" => "The :attribute must be a valid IPv4 address.",
    "ipv6" => "The :attribute must be a valid IPv6 address.",
    "json" => "The :attribute must be a valid JSON string.",
    "lt" => [
        "array" => "The :attribute must have less than :value items.",
        "file" => "The :attribute must be less than :value kilobytes.",
        "numeric" => "The :attribute must be less than :value.",
        "string" => "The :attribute must be less than :value characters."
    ],
    "lte" => [
        "array" => "The :attribute must not have more than :value items.",
        "file" => "The :attribute must be less than or equal :value kilobytes.",
        "numeric" => "The :attribute must be less than or equal :value.",
        "string" => "The :attribute must be less than or equal :value characters."
    ],
    "max" => [
        "array" => "The :attribute may not have more than :max items.",
        "file" => "The :attribute may not be greater than :max kilobytes.",
        "numeric" => "The :attribute may not be greater than :max.",
        "string" => "The :attribute may not be greater than :max characters."
    ],
    "mimes" => "The :attribute must be a file of type: :values.",
    "mimetypes" => "The :attribute must be a file of type: :values.",
    "min" => [
        "array" => "The :attribute must have at least :min items.",
        "file" => "The :attribute must be at least :min kilobytes.",
        "numeric" => "The :attribute must be at least :min.",
        "string" => "The :attribute must be at least :min characters."
    ],
    "not_in" => "The selected :attribute is invalid.",
    "not_regex" => "The :attribute format is invalid.",
    "numeric" => "The :attribute must be a number.",
    "present" => "The :attribute field must be present.",
    "regex" => "The :attribute format is invalid.",
    "required" => "The :attribute field is required.",
    "required_if" => "The :attribute field is required when :other is :value.",
    "required_unless" => "The :attribute field is required unless :other is in :values.",
    "required_with" => "The :attribute field is required when :values is present.",
    "required_with_all" => "The :attribute field is required when :values are present.",
    "required_without" => "The :attribute field is required when :values is not present.",
    "required_without_all" => "The :attribute field is required when none of :values are present.",
    "same" => "The :attribute and :other must match.",
    "size" => [
        "array" => "The :attribute must contain :size items.",
        "file" => "The :attribute must be :size kilobytes.",
        "numeric" => "The :attribute must be :size.",
        "string" => "The :attribute must be :size characters."
    ],
    "starts_with" => "The :attribute must start with one of the following: :values",
    "string" => "The :attribute must be a string.",
    "timezone" => "The :attribute must be a valid zone.",
    "unique" => "The :attribute has already been taken.",
    "uploaded" => "The :attribute failed to upload.",
    "url" => "The :attribute format is invalid.",
    "uuid" => "The :attribute must be a valid UUID.",
    'mobileAPI' => [
        'firstname' => [
            'required' => 'The first name field is required.',
            'string' => 'The first name must be a valid string.',
            'min' => 'The first name must be at least 3 characters long.',
            'max' => 'The first name must not exceed 100 characters.',
        ],
        'lastname' => [
            'required' => 'The last name field is required.',
            'string' => 'The last name must be a valid string.',
            'min' => 'The last name must be at least 3 characters long.',
            'max' => 'The last name must not exceed 100 characters.',
        ],
        'gender' => [
            'required' => 'The gender field is required.',
            'in' => 'The gender must be either male or female.',
        ],
        'date' => [
            'required' => 'The date field is required.',
            'date_format' => 'The date format must be YYYY-MM-DD.',
        ],
        'zip' => [
            'required' => 'The zip code field is required.',
            'integer' => 'The zip code must be a valid number.',
        ],
        'email' => [
            'required' => 'The email field is required.',
            'email' => 'The email must be a valid email address.',
            'unique' => 'This email is already registered.',
        ],
        'password' => [
            'required' => 'The password field is required.',
            'string' => 'The password must be a valid string.',
            'min' => 'The password must be at least 8 characters long.',
            'confirmed' => 'The password confirmation does not match.',
            'regex' => 'The password must contain at least one uppercase letter, one number, and one special character.',
        ],
        'age_restriction' => 'You must be at least :minAge years old to register in :country.',
        'email_exists' => 'This email is already registered.',
        'email_verification' => 'An email has been sent to you. Please confirm your email to complete your registration.',
    ],
];
