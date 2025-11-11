<?php

return [
    "accepted" => ":attribute विशेषता को स्वीकार किया जाना चाहिए।",
    "active_url" => ":attribute विशेषता एक मान्य URL नहीं है।",
    "after" => ":attribute डेट के बाद :date होना चाहिए।",
    "after_or_equal" => "विशेषता :attribute तारीख के बाद या उसके बराबर की :date होना चाहिए।",
    "alpha" => ":attribute विशेषता में केवल अक्षर हो सकते हैं।",
    "alpha_dash" => ":attribute में केवल अक्षर, संख्या, डैश और अंडरस्कोर हो सकते हैं।",
    "alpha_num" => ":attribute में केवल अक्षर और संख्याएँ हो सकती हैं।",
    "array" => ":attribute एक सरणी होनी चाहिए।",
    "attributes" => [
        "session_expired" => "आपका सत्र समाप्त हो गया है। कृपया डैशबोर्ड तक पहुँचने के लिए पुनः लॉग इन करें।",
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "एसोसिएटेड रोल्स",
                    "dependencies" => "निर्भरता",
                    "display_name" => "प्रदर्शित होने वाला नाम",
                    "first_name" => "पहला नाम",
                    "group" => "समूह",
                    "group_sort" => "समूह क्रमबद्ध",
                    "groups" => [
                        "name" => "समूह का नाम"
                    ],
                    "last_name" => "अंतिम नाम",
                    "name" => "नाम",
                    "system" => "प्रणाली"
                ],
                "roles" => [
                    "associated_permissions" => "एसोसिएटेड अनुमतियां",
                    "name" => "नाम",
                    "sort" => "तरह"
                ],
                "users" => [
                    "active" => "सक्रिय",
                    "associated_roles" => "एसोसिएटेड रोल्स",
                    "confirmed" => "की पुष्टि की",
                    "email" => "ईमेल पता",
                    "first_name" => "पहला नाम",
                    "language" => "भाषा",
                    "last_name" => "अंतिम नाम",
                    "name" => "नाम",
                    "other_permissions" => "अन्य अनुमतियाँ",
                    "password" => "पासवर्ड",
                    "password_confirmation" => "पासवर्ड पुष्टि",
                    "send_confirmation_email" => "ई-मेल भेजें",
                    "timezone" => "समय क्षेत्र"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "अवतार स्थान",
            "email" => "ईमेल पता",
            "first_name" => "पहला नाम",
            "middle_name" => "मध्य नाम",
            "language" => "भाषा",
            "last_name" => "अंतिम नाम",
            "message" => "संदेश",
            "name" => "पूरा नाम",
            "new_password" => "नया पासवर्ड",
            "new_password_confirmation" => "नया पासवर्ड पुष्टि",
            "old_password" => "पुराना पासवर्ड",

            "password" => "नया पासवर्ड",

            "password_confirmation" => "पासवर्ड की पुष्टि कीजिये",
            "phone" => "फ़ोन",
            "timezone" => "समय क्षेत्र",
            "password_require" => "पासवर्ड की आवश्यकता:",
            "password_require1" => "न्यूनतम पासवर्ड की लंबाई 8 वर्ण है।",
            "password_require2" => "लैटिन वर्णमाला (A-Z) से कम से कम एक बड़े अक्षर की आवश्यकता है।",
            "password_require3" => "कम से कम एक संख्या आवश्यक है।",
            "password_require4" => "कम से कम एक गैर-अल्फ़ान्यूमेरिक वर्ण आवश्यक है (!@#$%^&*()_+=[]{}|')
            ",

            "email_require" => "ईमेल की जरूरत है",
            "email_valid" => "ईमेल अमान्य है",
            "gender_req" => "कृपया लिंग चुनें",
            "password_req" => "पासवर्ड आवश्यक है",
            "password_valid" => "कृपया वैध पासवर्ड दर्ज करें",
            "password_valid1" => "पासवर्ड में कम से कम 8 अक्षर होने चाहिए",
            "password_valid2" => "पासवर्ड में 20 से अधिक अक्षर नहीं होने चाहिए",
            "confirm_pass1" => "पुष्टि पासवर्ड आवश्यक है",
            "confirm_pass2" => "पासवर्ड मेल नहीं खा रहा है",
            "first_name1" => "प्रथम नाम आवश्यक है",
            "first_name2" => "केवल अक्षर दर्ज करें",
            "last_name1" => "अंतिम नाम आवश्यक है",
            "first_name4" => "बार-बार एक ही अक्षर की अनुमति नहीं है",
            "name_req_1" => "विशेष अक्षरों की अनुमति नहीं है",
            "name_req_2" => "तीन बार दोहराए जाने वाले अक्षरों की अनुमति नहीं है।",
            "name_req_3" => "संख्याओं की अनुमति नहीं है।",
            "zip_code1" => "ज़िप कोड आवश्यक है",
            "is_geopostal" => "ज़िप कोड आपके वर्तमान स्थान से मेल नहीं खाता। कृपया सही ज़िप कोड दर्ज करें।",
            "is_age" => "हमारे पैनल में शामिल होने के लिए न्यूनतम आयु 18 वर्ष है। कृपया न्यूनतम आयु आवश्यकता पूरी होने पर वापस आएँ",

            "is_bot" => "बॉट का पता चला। बॉट के माध्यम से पंजीकरण की अनुमति नहीं है।",
            "is_anonymous" => "वीपीएन का पता चला, वीपीएन के माध्यम से पंजीकरण की अनुमति नहीं है।",
            "is_geotz" => "आप सुरक्षा जांच में असफल हो गए। आपके लिए पंजीकरण की अनुमति नहीं है।",
            "is_tampered" => "आप 'छेड़छाड़ की गई' जांच में असफल हो गए। आपके लिए पंजीकरण की अनुमति नहीं है।",
            "is_event" => "एकाधिक उपकरणों से पंजीकरण की अनुमति नहीं है",
            "toastr_2" => "बशर्ते ईमेल पहले ही पंजीकृत हो चुका हो",
            'password_no_space' => 'पासवर्ड में स्पेस नहीं होना चाहिए।',
            "max_age_limit" => "कृपया वैध आयु दर्ज करें",

        ]
    ],
    "before" => ":attribute तारीख से पहले की :date होनी चाहिए।",
    "before_or_equal" => ":attribute तिथि से पहले या उसके बराबर की :date होना चाहिए।",
    "between" => [
        "array" => ":attribute के बीच होना चाहिए :max और :minआइटम।",
        "file" => "ए :attribute विशेषता के बीच होना चाहिए :min और :max किलोबाइट।",
        "numeric" => "ए :attribute के बीच होना चाहिए :min और :max",
        "string" => ":attribute के बीच होना चाहिए :min और :max वर्ण।"
    ],
    "boolean" => ":attribute फ़ील्ड सही या गलत होना चाहिए।",
    "confirmed" => ":attribute पुष्टि मेल नहीं खाती।",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "सीमा शुल्क संदेश"
        ]
    ],
    "date" => ":attribute मान्य दिनांक नहीं है।",
    "date_equals" => ":attribute दिनांक के बराबर दिनांक होना चाहिए।",
    "date_format" => ":attribute प्रारूप से मेल नहीं खाती :date ।",
    "different" => ":attribute और :other अलग होना चाहिए।",
    "digits" => ":attribute होना चाहिए :digits अंक।",
    "digits_between" => "ए:attribute के बीच होना चाहिए :min और :max अंक।",
    "dimensions" => ":attribute में अमान्य छवि आयाम हैं।",
    "distinct" => ":attribute विशेषता फ़ील्ड में डुप्लिकेट मान है।",
    "email" => ":attribute एक मान्य ईमेल पता होनी चाहिए।",
    "exists" => "चयनित :attribute अमान्य है।",
    "file" => ":attribute एक फ़ाइल होनी चाहिए।",
    "filled" => ":attribute फ़ील्ड का मान होना चाहिए।",
    "gt" => [
        "array" => ":attribute से अधिक होना चाहिए :value आइटम।",
        "file" => ":attribute मान किलोबाइट से अधिक होना चाहिए।",
        "numeric" => ":attribute मान से अधिक होना चाहिए।",
        "string" => ":attribute :value वर्णों से अधिक होना चाहिए।"
    ],
    "gte" => [
        "array" => "ए :attribute के पास होना चाहिए :value आइटम या अधिक।",
        "file" => ":attribute :value किलोबाइट से अधिक या बराबर होना चाहिए।",
        "numeric" => ":attribute :value से अधिक या बराबर होना चाहिए।",
        "string" => ":attribute :value वर्ण से अधिक या बराबर होना चाहिए।"
    ],
    "image" => ":attribute एक छवि होनी चाहिए।",
    "in" => ":attribute विशेषता अमान्य है।",
    "in_array" => ":attribute फ़ील्ड में मौजूद नहीं है :other।",
    "integer" => ":attribute पूर्णांक होना चाहिए।",
    "ip" => ":attribute एक मान्य IP पता होना चाहिए।",
    "ipv4" => ":attribute एक मान्य IPv4 पता होना चाहिए।",
    "ipv6" => ":attributeएक मान्य IPv6 पता होना चाहिए।",
    "json" => ":attribute एक वैध JSON स्ट्रिंग होना चाहिए।",
    "lt" => [
        "array" => ":attribute से कम होना चाहिए :value आइटम।",
        "file" => ":attribute :value किलोबाइट से कम होना चाहिए।",
        "numeric" => ":attribute :value से कम होना चाहिए।",
        "string" => ":attribute मान वर्णों से कम होना चाहिए।"
    ],
    "lte" => [
        "array" => ":attribute :value आइटम से अधिक नहीं होना चाहिए।",
        "file" => "ए :attribute से कम या बराबर होना चाहिए :value किलोबाइट।",
        "numeric" => ":attributeसे कम या बराबर होना चाहिए :value।",
        "string" => ":attribute :value वर्ण से कम या बराबर होना चाहिए।"
    ],
    "max" => [
        "array" => ":attribute :max आइटम से अधिक नहीं हो सकता है।",
        "file" => ":attribute :max किलोबाइट से अधिक नहीं हो सकती है।",
        "numeric" => ":attribute :max से अधिक नहीं हो सकती है।",
        "string" => ":attribute से अधिक नहीं हो सकता है :max वर्ण।"
    ],
    "mimes" => ":attribute प्रकार की एक फ़ाइल होनी चाहिए :values।",
    "mimetypes" => ":attribute प्रकार की एक फ़ाइल होनी चाहिए :values।",
    "min" => [
        "array" => ":attribute में कम से कम :min आइटम होना चाहिए।",
        "file" => ":attribute कम से कम होना चाहिए :min किलोबाइट।",
        "numeric" => "ए :attribute कम से कम :min मिनट होनी चाहिए।",
        "string" => "ए :attribute कम से कम होनी चाहिए :min वर्ण।"
    ],
    "not_in" => "चयनित :attribute अमान्य है।",
    "not_regex" => ":attribute प्रारूप अमान्य है।",
    "numeric" => ":attribute एक संख्या होनी चाहिए।",
    "present" => ":attribute फ़ील्ड मौजूद होना चाहिए।",
    "regex" => ":attribute प्रारूप अमान्य है।",
    "required" => ":attribute फ़ील्ड आवश्यक है।",
    //"required_if" => ":attribute फ़ील्ड आवश्यक है जब :value अन्य है",
    "required_if" => ":attribute फ़ील्ड आवश्यक है।",
    "required_unless" => "जब तक :attribute :values में हैविशेषता फ़ील्ड आवश्यक है।",
    "required_with" => ":valuesमौजूद होने पर विशेषता फ़ील्ड आवश्यक है।",
    "required_with_all" => ":attribute :values मौजूद होने पर विशेषता फ़ील्ड आवश्यक है।",
    "required_without" => ":attribute :valuesके मौजूद न होने पर विशेषता फ़ील्ड की आवश्यकता होती है।",
    "required_without_all" => ":attributeफ़ील्ड की आवश्यकता तब होती है जब कोई भी :values मौजूद नहीं होता है।",
    "same" => ":attribute और :otherमेल खाना चाहिए।",
    "size" => [
        "array" => ":attribute विशेषता में यह होना चाहिए :size आइटम।",
        "file" => "ए :attribute होनी चाहिए :size किलोबाइट।",
        "numeric" => "ए :attributeहोनी चाहिए :size ।",
        "string" => ":attribute होना चाहिए :size वर्ण।"
    ],
    "starts_with" => ":attributeको निम्न में से किसी एक से शुरू करना चाहिए :values",
    "string" => ":attribute एक स्ट्रिंग होनी चाहिए।",
    "timezone" => ":attribute मान्य क्षेत्र होनी चाहिए।",
    "unique" => ":attribute को पहले ही लिया जा चुका है।",
    "uploaded" => ":attribute अपलोड करने में विफल रही।",
    "url" => ":attribute प्रारूप अमान्य है।",
    "uuid" => ":attribute एक मान्य यूयूआईडी होना चाहिए।",
    'mobileAPI' => [
        'firstname' => [
            'required' => 'पहला नाम फ़ील्ड आवश्यक है।',
            'string' => 'पहला नाम मान्य स्ट्रिंग होना चाहिए।',
            'min' => 'पहला नाम कम से कम 3 अक्षरों का होना चाहिए।',
            'max' => 'पहला नाम 100 अक्षरों से अधिक नहीं होना चाहिए।',
        ],
        'lastname' => [
            'required' => 'अंतिम नाम फ़ील्ड आवश्यक है।',
            'string' => 'अंतिम नाम मान्य स्ट्रिंग होना चाहिए।',
            'min' => 'अंतिम नाम कम से कम 3 अक्षरों का होना चाहिए।',
            'max' => 'अंतिम नाम 100 अक्षरों से अधिक नहीं होना चाहिए।',
        ],
        'gender' => [
            'required' => 'लिंग फ़ील्ड आवश्यक है।',
            'in' => 'लिंग केवल पुरुष या महिला होना चाहिए।',
        ],
        'date' => [
            'required' => 'तारीख फ़ील्ड आवश्यक है।',
            'date_format' => 'तारीख का प्रारूप YYYY-MM-DD होना चाहिए।',
        ],
        'zip' => [
            'required' => 'ज़िप कोड फ़ील्ड आवश्यक है।',
            'integer' => 'ज़िप कोड एक मान्य संख्या होनी चाहिए।',
        ],
        'countryName' => [
            'required' => 'देश का नाम फ़ील्ड आवश्यक है।',
            'string' => 'देश का नाम एक मान्य स्ट्रिंग होनी चाहिए।',
        ],
        'email' => [
            'required' => 'ईमेल फ़ील्ड आवश्यक है।',
            'email' => 'ईमेल एक मान्य ईमेल पता होना चाहिए।',
            'unique' => 'यह ईमेल पहले से पंजीकृत है।',
        ],
        'password' => [
            'required' => 'पासवर्ड फ़ील्ड आवश्यक है।',
            'string' => 'पासवर्ड एक मान्य स्ट्रिंग होना चाहिए।',
            'min' => 'पासवर्ड कम से कम 8 अक्षरों का होना चाहिए।',
            'confirmed' => 'पासवर्ड पुष्टिकरण मेल नहीं खा रहा है।',
            'regex' => 'पासवर्ड में कम से कम एक बड़ा अक्षर, एक अंक और एक विशेष अक्षर होना चाहिए।',
        ],
        'otp' => [
            'required' => 'OTP फ़ील्ड आवश्यक है।',
            'numeric' => 'OTP एक मान्य संख्या होनी चाहिए।',
        ],
        'user_id' => [
            'required' => 'यूज़र आईडी फ़ील्ड आवश्यक है।',
            'numeric' => 'यूज़र आईडी एक मान्य संख्या होनी चाहिए।',
        ],
        'device_name'=>[
            "required"=>"डिवाइस नाम फ़ील्ड आवश्यक है।"
        ],
        'age_restriction' => 'आपको :country में पंजीकरण करने के लिए कम से कम :minAge वर्ष का होना चाहिए।',
        'email_exists' => 'यह ईमेल पहले से पंजीकृत है।',
        'email_verification' => 'आपको एक ईमेल भेजा गया है। कृपया अपनी ईमेल की पुष्टि करें ताकि आप सफलतापूर्वक पंजीकरण कर सकें।',
        'userExist' => 'उपयोगकर्ता नहीं मिला',
        'passwordMismatch' => 'पासवर्ड मेल नहीं खाता',


    ],

];
