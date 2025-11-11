<?php

return [
    "accepted" => "L'attribut :attribute doit être accepté.",
    "active_url" => "L'attribut :attribute n'est pas une URL valide.",
    "after" => "L'attribut :attribute doit être une date après :date.",
    "after_or_equal" => "L'attribut :attribute doit être une date après ou égale à :date.",
    "alpha" => "L'attribut :attributene peut contenir que des lettres.",
    "alpha_dash" => "L'attribut :attribute ne peut contenir que des lettres, des chiffres, des tirets et des traits de soulignement.",
    "alpha_num" => "L'attribut :attribute ne peut contenir que des lettres et des chiffres.",
    "array" => "L'attribut :attribute doit être un tableau.",
    "attributes" => [
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "Rôles associés",
                    "dependencies" => "Les dépendances",
                    "display_name" => "Afficher un nom",
                    "first_name" => "Prénom",
                    "group" => "Groupe",
                    "group_sort" => "Tri du groupe",
                    "groups" => [
                        "name" => "Nom de groupe"
                    ],
                    "last_name" => "Nom de famille",
                    "name" => "prénom",
                    "system" => "Système"
                ],
                "roles" => [
                    "associated_permissions" => "Autorisations associées",
                    "name" => "prénom",
                    "sort" => "Trier"
                ],
                "users" => [
                    "active" => "actif",
                    "associated_roles" => "Rôles associés",
                    "confirmed" => "Confirmé",
                    "email" => "Adresse électronique",
                    "first_name" => "Prénom",
                    "language" => "La langue",
                    "last_name" => "Nom de famille",
                    "name" => "prénom",
                    "other_permissions" => "Autres autorisations",
                    "password" => "Mot de passe",
                    "password_confirmation" => "Confirmation mot de passe",
                    "send_confirmation_email" => "Envoyer un e-mail de confirmation",
                    "timezone" => "Fuseau horaire"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "Localisation de l'avatar",
            "email" => "Adresse électronique",
            "first_name" => "Prénom",
            "middle_name" => "Deuxième nom",
            "language" => "La langue",
            "last_name" => "Nom de famille",
            "message" => "Message",
            "name" => "Nom complet",
            "new_password" => "nouveau mot de passe",
            "new_password_confirmation" => "Confirmation du nouveau mot de passe",
            "old_password" => "ancien mot de passe",
            "password" => "Mot de passe",
            "password_confirmation" => "Confirmation mot de passe",
            "phone" => "Téléphone",
            "timezone" => "Fuseau horaire",
           "password_require" => "Exigence de mot de passe :",
            "password_require1" => "La longueur minimale du mot de passe est de 8 caractères.",
            "password_require2" => "Nécessite au moins une lettre majuscule du latin albhabet (A-Z).",
            "password_require3" => "Exigez au moins un numéro.",
            "password_require4" => "Exiger au moins un caractère non alphanumérique (!@#$%^&*()_+=[]{}|')
            ",
        ]
    ],
    "before" => "L'attribut :attribute doit être une date antérieure à :date.",
    "before_or_equal" => "L'attribut :attribute doit être une date antérieure ou égale à :date.",
    "between" => [
        "array" => "L'attribut :attribute doit avoir entre :min et :max items.",
        "file" => "L'attribut :attribute doit être compris entre :min et :max kilo-octets.",
        "numeric" => "L'attribut :attribute doit être compris entre :min et :max.",
        "string" => "L'attribut :attribute doit être compris entre :min et :max caractères."
    ],
    "boolean" => "Le champ d'attribut:attribute doit être vrai ou faux.2",
    "confirmed" => "La confirmation :attribute ne correspond pas.",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "message personnalisé"
        ]
    ],
    "date" => "L'attribut :attribute n'est pas une date valide.",
    "date_equals" => ":attribute doit être une date égale à :date.",
    "date_format" => ":attribute ne correspond pas au format :format.",
    "different" => "L'attribut:attributeet :other doivent être différents.",
    "digits" => "L'attribut :attribute doit être :digits digits.",
    "digits_between" => "L'attribut :attribute doit être compris entre :min et :max digits.",
    "dimensions" => ":attribute a des dimensions d'image non valides.",
    "distinct" => "Le champ :attribute a une valeur en double.",
    "email" => ":attribute doit être une adresse email valide.",
    "exists" => "sélectionné :attribute n'est pas valide.",
    "file" => ":attribute doit être un fichier.",
    "filled" => "Le champ :attribute doit avoir une valeur.",
    "gt" => [
        "array" => ":attribute doit avoir plus de :value de.",
        "file" => ":attribute doit être supérieur à :value kilo-octets.",
        "numeric" => ":attribute doit être supérieur à :value .",
        "string" => ":attribute doit être supérieur à :value caractères de valeur."
    ],
    "gte" => [
        "array" => ":attribute doit :valueéléments de valeur ou plus.",
        "file" => ":attribute doit être supérieur ou égal à :value en kilo-octets.",
        "numeric" => ":attribute doit être supérieur ou égal à :value.",
        "string" => ":attribute doit être supérieur ou égal à :value caractères de valeur."
    ],
    "image" => ":attribute doit être une image.",
    "in" => "sélectionné :attribute n'est pas valide.",
    "in_array" => "Le champ :attributen'existe pas dans :other.",
    "integer" => ":attribute doit être un entier.",
    "ip" => ":attribute doit être une adresse IP valide.",
    "ipv4" => ":attribute doit être une adresse IPv4 valide.",
    "ipv6" => ":attribute doit être une adresse IPv6 valide.",
    "json" => ":attribute doit être une chaîne JSON valide.",
    "lt" => [
        "array" => ":attribute doit avoir moins de :value de .",
        "file" => ":attribute doit être inférieur à :value kilo-octets.",
        "numeric" => ":attribute doit être inférieur à :value .",
        "string" => ":attribute doit être inférieur à :value caractères de valeur."
    ],
    "lte" => [
        "array" => ":attribute ne doit pas avoir plus de :value éléments de valeur.",
        "file" => ":attribute doit être inférieur ou égal à :value kilo-octets.",
        "numeric" => ":attribute doit être inférieur ou égal à :value.",
        "string" => ":attribute doit être inférieur ou égal à :value caractères de valeur."
    ],
    "max" => [
        "array" => ":attribute ne peut avoir plus de :max articles.",
        "file" => ":attribute ne peut pas être supérieur à :max kilo-octets.",
        "numeric" => ":attribute ne peut pas être supérieur à :max.",
        "string" => ":attribute ne peut pas être supérieur à :max caractères."
    ],
    "mimes" => ":attribute doit être un fichier de type :values .",
    "mimetypes" => ":attribute doit être un fichier de type: :values .",
    "min" => [
        "array" => ":attribute doit avoir au moins :min items.",
        "file" => ":attribute doit être au moins :min kilo-octets.",
        "numeric" => ":attribute doit être au moins :min.",
        "string" => ":attribute doit être au moins :min caractères."
    ],
    "not_in" => ":attribute sélectionnén'est pas valide.",
    "not_regex" => "Le format :attribute est invalide.",
    "numeric" => ":attribute doit être un nombre.",
    "present" => "Le champ :attribute doit être présent.",
    "regex" => "Le format :attribute est invalide.",
    "required" => "Le champ :attribute est requis.",
    "required_if" => "Le champ :attribute est requis lorsque :value autre est.",
    "required_unless" => "Le champ :attribute est obligatoire sauf si :value autre est dans.",
    "required_with" => "Le champ :attribute est requis lorsque :values ​​est présent.",
    "required_with_all" => "Le champ :attribute est requis lorsque :values des valeurs sont présentes.",
    "required_without" => "Le champ :attribute est requis lorsque :values ​​n'est pas présent.",
    "required_without_all" => "Le champ :attributeest requis lorsqu'aucune des :values suivantes n'est présente.",
    "same" => ":attribute et :other doivent correspondre.",
    "size" => [
        "array" => ":attribute doit contenir :size les éléments de taille.",
        "file" => ":attribute doit être :size taille kilo-octets.",
        "numeric" => ":attribute doit être :size taille.",
        "string" => ":attribute deve essere :size caratteri."
    ],
    "starts_with" => ":attribute deve iniziare con uno dei seguenti : : values",
    "string" => ":attribute deve essere una stringa.",
    "timezone" => ":attribute deve essere una zona valida.",
    "unique" => ":attribute è già stato preso.",
    "uploaded" => ":attribute impossibile caricare.",
    "url" => "Il formato :attribute non è valido.",
    "uuid" => ":attribute deve essere un UUID valido."
];
