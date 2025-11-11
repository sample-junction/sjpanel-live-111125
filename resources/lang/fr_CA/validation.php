<?php

return [
    //"accepted" => "Le :attribute_x doit être accepté.",
    "accepted" => "Le consentement doit être accepté.",
    "active_url" => "Le :attribute n'est pas une URL valide.",
    "after" => "Le :attribute doit être une date après :date.",
    "after_or_equal" => "Le :attribute doit être une date postérieure ou égale à :date.",
    "alpha" => "Le :attribute ne peut contenir que des lettres.",
    "alpha_dash" => "Le :attribute ne peut contenir que des lettres, des chiffres, des tirets et des traits de soulignement.",
    "alpha_num" => "Le :attribute ne peut contenir que des lettres et des chiffres.",
    "array" => "Le :attribute doit être un tableau.",
    "attributes" => [
        "session_expired" => "Votre session a expiré. Veuillez vous reconnecter pour accéder au tableau de bord.",
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "Rôles associés",
                    "dependencies" => "Dépendances",
                    "display_name" => "Nom d'affichage",
                    "first_name" => "Prénom",
                    "group" => "Groupe",
                    "group_sort" => "Tri de groupe",
                    "groups" => [
                        "name" => "Nom du groupe"
                    ],
                    "last_name" => "Nom de famille",
                    "name" => "Nom",
                    "system" => "Système"
                ],
                "roles" => [
                    "associated_permissions" => "Autorisations associées",
                    "name" => "Nom",
                    "sort" => "Trier"
                ],
                "users" => [
                    "active" => "Actif",
                    "associated_roles" => "Rôles associés",
                    "confirmed" => "Confirmé",
                    "email" => "Adresse e-mail",
                    "first_name" => "Prénom",
                    "language" => "Langue",
                    "last_name" => "Nom",
                    "name" => "Nom",
                    "other_permissions" => "Autres autorisations",
                    "password" => "Mot de passe",
                    "password_confirmation" => "Confirmation du mot de passe",
                    "send_confirmation_email" => "Envoyer un e-mail de confirmation",
                    "timezone" => "Fuseau horaire"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "Emplacement de l'avatar",
            "email" => "Adresse e-mail",
            "first_name" => "Prénom",
            "middle_name" => "Deuxième prénom",
            "language" => "Langue",
            "last_name" => "Nom",
            "message" => "Message",
            "name" => "Nom complet",
            "new_password" => "Nouveau mot de passe",
            "new_password_confirmation" => "Confirmation du nouveau mot de passe",
            "old_password" => "Ancien mot de passe",
            "password" => "Mot de passe",
            "password_confirmation" => "Confirmer le mot de passe",
            "phone" => "Téléphone",
            "timezone" => "Fuseau horaire",
            "password_require" => "Mot de passe requis :",
            "password_require1" => "La longueur minimale du mot de passe est de 8 caractères.",
            "password_require2" => "Exiger au moins une lettre majuscule du latin albhabet (A-Z).",
            "password_require3" => "Exiger au moins un numéro.",
            "password_require4" => "Exiger au moins un caractère non alphanumérique (!@#$%^&*()_+=[]{}|’).
            ",
            "email_require" => "L'e-mail est requis",
            "email_valid" => "L'e-mail n'est pas valide",
            "gender_req" => "Veuillez sélectionner un sexe",
            "password_req" => "Un mot de passe est requis",
            "password_valid" => "Veuillez saisir un mot de passe valide",
            "password_valid1" => "Le mot de passe doit comporter au moins 8 caractères",
            "password_valid2" => "Le mot de passe ne doit pas contenir plus de 20 caractères",
            "confirm_pass1" => "Confirmer le mot de passe est requis",
            "confirm_pass2" => "Le mot de passe ne correspond pas",
            "first_name1" => "Le prénom est obligatoire",
            "first_name2" => "Entrez uniquement les alphabets",
            "last_name1" => "Le nom de famille est obligatoire",
            "first_name4" => "Les lettres répétées ne sont pas autorisées",
            "name_req_1" => "Caractères spéciaux non autorisés.",
            "name_req_2" => "Caractères répétitifs non autorisés 3 fois.",
            "name_req_3" => "Numéros non autorisés.",
            "zip_code1" => "Le code postal est requis",
            "is_geopostal" => "Le code postal ne correspond pas à votre emplacement actuel. Veuillez saisir le code postal correct.",
            "is_age" => "L'âge minimum pour rejoindre notre panel est de 13 ans. Veuillez revenir lorsque vous aurez atteint l'âge minimum requis",
            "is_bot" => "Bot détecté. L'inscription via Bot n'est pas autorisée.",
            "is_anonymous" => "VPN détecté, l'enregistrement via VPN n'est pas autorisé.",
            "is_geotz" => "Vous avez échoué au contrôle de sécurité. L'inscription n'est pas autorisée pour vous.",
            "is_tampered" => "Vous avez échoué au contrôle tampered. L'inscription n'est pas autorisée pour vous.",
            "is_event" => "L'inscription à partir de plusieurs appareils n'est pas autorisée.",
            "max_age_limit" => "Veuillez saisir un âge valide.",
        ]
    ],
    "before" => "Le :attribute doit être une date antérieure à :date.",
    "before_or_equal" => "Le :attribute doit être une date antérieure ou égale à :date.",
    "entre" => [
        "array" => "Le :attribute doit avoir entre :min et :max éléments.",
        "file" => "Le :attribute doit être compris entre :min et :max kilobytes.",
        "numeric" => "Le :attribute doit être compris entre :min et :max.",
        "string" => "Le :attribute doit être compris entre les caractères :min et :max."
    ],
    "boolean" => "Le champ :attribute doit être vrai ou faux.",
    "confirmed" => "La confirmation :attribute ne correspond pas.",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "message-personnalisé"
        ]
    ],
    "date" => "Le :attribut n'est pas une date valide.",
    "date_equals" => "Le :attribute doit être une date égale à :date.",
    "date_format" => "Le :attribute ne correspond pas au format :format.",
    "different" => "Les :attribute et :other doivent être différents.",
    "digits" => "Le :attribute doit être :digits chiffres.",
    "digits_between" => "Le :attribute doit être compris entre :min et :max chiffres.",
    "dimensions" => "Le :attribut a des dimensions d'image non valides.",
    "distinct" => "Le champ :attribute a une valeur en double.",
    "email" => "Le :attribute doit être une adresse email valide.",
    "exists" => "L'attribut :attribut sélectionné n'est pas valide.",
    "file" => "Le :attribute doit être un fichier.",
    "filled" => "Le champ :attribute doit avoir une valeur.",
    "gt" => [
        "array" => "Le :attribute doit avoir plus de :value éléments.",
        "file" => "Le :attribute doit être supérieur à :value kilobytes.",
        "numeric" => "Le :attribute doit être supérieur à :value.",
        "string" => "Le :attribute doit être supérieur aux caractères :value."
    ],
    "gte" => [
        "array" => "Le :attribute doit avoir des éléments :value ou plus.",
        "file" => "Le :attribute doit être supérieur ou égal à :value kilobytes.",
        "numeric" => "Le :attribute doit être supérieur ou égal à :value.",
        "string" => "Le :attribute doit être supérieur ou égal aux caractères :value."
    ],
    "image" => "Le :attribut doit être une image.",
    "in" => "L'attribut :attribut sélectionné n'est pas valide.",
    "in_array" => "Le champ :attribute n'existe pas dans :other.",
    "integer" => "Le :attribute doit être un entier.",
    "ip" => "Le :attribute doit être une adresse IP valide.",
    "ipv4" => "Le :attribute doit être une adresse IPv4 valide.",
    "ipv6" => "Le :attribute doit être une adresse IPv6 valide.",
    "json" => "Le :attribute doit être une chaîne JSON valide.",
    "lt" => [
        "array" => "Le :attribute doit contenir moins d'éléments :value.",
        "file" => "Le :attribute doit être inférieur à :value kilobytes.",
        "numeric" => "Le :attribute doit être inférieur à :value.",
        "string" => "Le :attribute doit être inférieur à :value caractères."
    ],
    "lte" => [
        "array" => "Le :attribute ne doit pas contenir plus de :value éléments.",
        "file" => "Le :attribute doit être inférieur ou égal à :value kilobytes.",
        "numeric" => "Le :attribute doit être inférieur ou égal à :value.",
        "string" => "Le :attribute doit être inférieur ou égal aux caractères :value."
    ],
    "max" => [
        "array" => "Le :attribute ne peut pas contenir plus de :max éléments.",
        "file" => "Le :attribute ne peut pas être supérieur à :max kilobytes.",
        "numeric" => "Le :attribute ne peut pas être supérieur à :max.",
        "string" => "Le :attribute ne peut pas contenir plus de :max caractères."
    ],
    "mimes" => "Le :attribute doit être un fichier de type :values.",
    "mimetypes" => "Le :attribute doit être un fichier de type : :values.",
    "min" => [
        "array" => "Le :attribute doit avoir au moins :min éléments.",
        "file" => "Le :attribute doit faire au moins :min kilobytes.",
        "numeric" => "Le :attribute doit être au moins :min.",
        "string" => "Le :attribute doit contenir au moins :min caractères."
    ],
    "not_in" => "L'attribut :attribut sélectionné n'est pas valide.",
    "not_regex" => "Le format :attribute n'est pas valide.",
    "numeric" => "Le :attribute doit être un nombre.",
    "present" => "Le champ :attribute doit être présent.",
    "regex" => "Le format :attribute n'est pas valide.",
    "required" => "Le champ :attribute est obligatoire.",
    //"required_if" => "Le champ :attribute est obligatoire lorsque :other est :value.",
    "required_if" => "Le champ :attribute est obligatoire.",
    "required_unless" => "Le champ :attribute est obligatoire sauf si :other est dans :values.",
    "required_with" => "Le champ :attribute est obligatoire lorsque :values ​​est présent.",
    "required_with_all" => "Le champ :attribute est obligatoire lorsque les :values ​​sont présentes.",
    "required_without" => "Le champ :attribute est obligatoire lorsque :values ​​n'est pas présent.",
    "required_without_all" => "Le champ :attribute est obligatoire lorsqu'aucune des :values ​​n'est présente.",
    "same" => "Les :attribute et :other doivent correspondre.",
    "size" => [
        "array" => "Le :attribute doit contenir des éléments :size.",
        "file" => "Le :attribute doit être :size kilobytes.",
        "numeric" => "Le :attribute doit être :size.",
        "string" => "Le :attribute doit contenir des caractères :size."
    ],
    "starts_with" => "Le :attribute doit commencer par l'un des éléments suivants : :values",
    "string" => "Le :attribute doit être une chaîne.",
    "timezone" => "Le :attribute doit être une zone valide.",
    "unique" => "Le :attribute a déjà été pris.",
    "uploaded" => "Le :attribute n'a pas pu être téléchargé.",
    "url" => "Le format :attribute n'est pas valide.",
    "uuid" => "Le :attribute doit être un UUID valide.",
    'mobileAPI' => [
        'firstname' => [
            'required' => 'Le champ prénom est requis.',
            'string' => 'Le prénom doit être une chaîne de caractères valide.',
            'min' => 'Le prénom doit contenir au moins 3 caractères.',
            'max' => 'Le prénom ne doit pas dépasser 100 caractères.',
        ],
        'lastname' => [
            'required' => 'Le champ nom de famille est requis.',
            'string' => 'Le nom de famille doit être une chaîne de caractères valide.',
            'min' => 'Le nom de famille doit contenir au moins 3 caractères.',
            'max' => 'Le nom de famille ne doit pas dépasser 100 caractères.',
        ],
        'gender' => [
            'required' => 'Le champ sexe est requis.',
            'in' => 'Le sexe doit être soit homme soit femme.',
        ],
        'date' => [
            'required' => 'Le champ date est requis.',
            'date_format' => 'Le format de la date doit être YYYY-MM-DD.',
        ],
        'zip' => [
            'required' => 'Le champ code postal est requis.',
            'integer' => 'Le code postal doit être un nombre valide.',
        ],
        'countryName' => [
            'required' => 'Le champ nom du pays est requis.',
            'string' => 'Le nom du pays doit être une chaîne de caractères valide.',
        ],
        'email' => [
            'required' => 'Le champ courriel est requis.',
            'email' => 'Le courriel doit être une adresse électronique valide.',
            'unique' => 'Ce courriel est déjà enregistré.',
        ],
        'password' => [
            'required' => 'Le champ mot de passe est requis.',
            'string' => 'Le mot de passe doit être une chaîne de caractères valide.',
            'min' => 'Le mot de passe doit contenir au moins 8 caractères.',
            'confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'regex' => 'Le mot de passe doit contenir au moins une lettre majuscule, un chiffre et un caractère spécial.',
        ],
        'otp' => [
            'required' => 'Le champ OTP est requis.',
            'numeric' => 'L’OTP doit être un nombre valide.',
        ],
        'user_id' => [
            'required' => 'Le champ ID utilisateur est requis.',
            'numeric' => 'L’ID utilisateur doit être un nombre valide.',
        ],
        'device_name' => [
            'required' => 'Le champ device_name est requis.',
        ],    

        'age_restriction' => 'Vous devez avoir au moins :minAge ans pour vous inscrire dans :country.',
        'email_exists' => 'Ce courriel est déjà enregistré.',
        'email_verification' => 'Un courriel vous a été envoyé. Veuillez confirmer votre courriel pour compléter votre inscription.',
        'userExist' => 'Utilisateur non trouvé',
        'passwordMismatch' => 'Le mot de passe ne correspond pas',
    ],

];
