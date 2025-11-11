<?php

return [
    "accepted" => "Das Attribut :attribute muss akzeptiert werden.",
    "active_url" => "Das Attribut :attribute ist keine gültige URL.",
    "after" => "Das Attribut :attribute muss ein Datum nach dem Datum sein. :date",
    "after_or_equal" => "Das Attribut :attribute muss ein Datum nach oder gleich :date sein.",
    "alpha" => "Das Attribut :attribute darf nur Buchstaben enthalten.",
    "alpha_dash" => "Das Attribut :attribute darf nur Buchstaben, Zahlen, Bindestriche und Unterstriche enthalten.",
    "alpha_num" => "Das Attribut :attribute darf nur Buchstaben und Zahlen enthalten.",
    "array" => "Das :attribute muss ein Array sein.",
    "attributes" => [
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "Zugehörige Rollen",
                    "dependencies" => "Abhängigkeiten",
                    "display_name" => "Anzeigename",
                    "first_name" => "Vorname",
                    "group" => "Gruppe",
                    "group_sort" => "Gruppensortierung",
                    "groups" => [
                        "name" => "Gruppenname"
                    ],
                    "last_name" => "Nachname",
                    "name" => "Name",
                    "system" => "System"
                ],
                "roles" => [
                    "associated_permissions" => "Zugehörige Berechtigungen",
                    "name" => "Name",
                    "sort" => "Sortieren"
                ],
                "users" => [
                    "active" => "Aktiv",
                    "associated_roles" => "Zugehörige Rollen",
                    "confirmed" => "Bestätigt",
                    "email" => "E-Mail-Addresse",
                    "first_name" => "Vorname",
                    "language" => "Sprache",
                    "last_name" => "Nachname",
                    "name" => "Name",
                    "other_permissions" => "Andere Berechtigungen",
                    "password" => "Passwort",
                    "password_confirmation" => "Passwort Bestätigung",
                    "send_confirmation_email" => "Bestätigungs-E-Mail senden",
                    "timezone" => "Zeitzone"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "Avatar-Standort",
            "email" => "E-Mail-Addresse",
            "first_name" => "Vorname",
            "middle_name" => "Zweiter Vorname",
            "language" => "Sprache",
            "last_name" => "Nachname",
            "message" => "Botschaft",
            "name" => "Vollständiger Name",
            "new_password" => "Neues Kennwort",
            "new_password_confirmation" => "Neues Passwort bestätigen",
            "old_password" => "Altes Passwort",
            "password" => "Passwort",
            "password_confirmation" => "Passwort Bestätigung",
            "phone" => "Telefon",
            "timezone" => "Zeitzone",
            "password_require" => "Wachtwoordvereiste:",
            "password_require1" => "De minimale wachtwoordlengte is 8 tekens.",
            "password_require2" => "Vereist minstens één hoofdletter van het Latijnse albhabet (A-Z).",
            "password_require3" => "Vereist ten minste één nummer.",
            "password_require4" => "Ten minste één niet-alfanumeriek teken vereisen (!@#$%^&*()_+=[]{}|')
            ",
        ]
    ],
    "before" => "Das :attribute muss ein Datum vor dem :date sein.",
    "before_or_equal" => "Das :attributemuss ein Datum vor oder gleich :date Datum sein.",
    "between" => [
        "array" => "Das :attribute muss zwischen :min und :max Elementen liegen.",
        "file" => "Das Attribut :attribute muss zwischen :min und :max Kilobytes liegen.",
        "numeric" => "Das :attribute muss zwischen :min und :max liegen.",
        "string" => "Das :attribute muss zwischen :min und :max Zeichen liegen."
    ],
    "boolean" => "Das :attribute muss wahr oder falsch sein.",
    "confirmed" => "Die :attribute Attributbestätigung stimmt nicht überein.",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "benutzerdefinierte Nachricht"
        ]
    ],
    "date" => "Das:attribute ist kein gültiges Datum.",
    "date_equals" => "Das :attribute muss ein Datum sein, das dem Datum entspricht.",
    "date_format" => "Das :attribute stimmt nicht mit dem Format Format überein.",
    "different" => "Das:attribute und :other Andere müssen unterschiedlich sein.",
    "digits" => "Das:attribute muss aus Ziffern bestehen :digits",
    "digits_between" => "Das :attribute muss zwischen :min und :max Ziffern liegen.",
    "dimensions" => "Das :attribute hat ungültige Bildabmessungen.",
    "distinct" => "Das :attribute hat einen doppelten Wert.",
    "email" => "Das :attribute muss eine gültige E-Mail-Adresse sein.",
    "exists" => "Das ausgewählte :attribute ist ungültig.",
    "file" => "Das :attribute muss eine Datei sein.",
    "filled" => "Das :attribute muss einen Wert haben.",
    "gt" => [
        "array" => "Das :attribute muss mehr als :value enthalten.",
        "file" => "Das :attribute muss größer sein als :value Kilobytes.",
        "numeric" => "Das :attribute muss größer sein als :value .",
        "string" => "Das :attribute muss größer sein als :value Wertzeichen."
    ],
    "gte" => [
        "array" => "Das :attribute muss Folgendes enthalten :value Wertelemente oder mehr.",
        "file" => "Das :attribute muss größer oder gleich sein :value Wert Kilobytes.",
        "numeric" => "Das :attribute muss größer oder gleich sein :value.",
        "string" => "Das :attribute muss größer oder gleich sein :valueWertzeichen."
    ],
    "image" => "Das :attribute muss ein Bild sein.",
    "in" => "Das ausgewählte :attribute ist ungültig.",
    "in_array" => "Das :attribute existiert nicht in :other.",
    "integer" => "Das :attribute muss eine ganze Zahl sein.",
    "ip" => "Das :attribute muss eine gültige IP-Adresse sein.",
    "ipv4" => "Das :attribute muss eine gültige IPv4-Adresse sein.",
    "ipv6" => "Das :attribute muss eine gültige IPv6-Adresse sein.",
    "json" => "Das :attribute muss eine gültige JSON-Zeichenfolge sein.",
    "lt" => [
        "array" => "Das :attribute muss weniger :value Wertelemente haben.",
        "file" => "Das :attribute muss kleiner sein als :value Kilobytes.",
        "numeric" => "Das :attribute muss kleiner als :value sein.",
        "string" => "Das :attribute muss aus weniger als :value Wertzeichen bestehen."
    ],
    "lte" => [
        "array" => "Das :attribute darf nicht mehr als :valueWertelemente enthalten.",
        "file" => "Das :attribute muss kleiner oder gleich sein :value Kilobytes.",
        "numeric" => "Das :attribute muss kleiner oder gleich sein :value.",
        "string" => "Das :attribute muss kleiner oder gleich sein :value Wertzeichen."
    ],
    "max" => [
        "array" => "Das :attribute darf nicht mehr als :max Elemente haben.",
        "file" => "Das :attribute darf nicht größer sein als :max Kilobytes.",
        "numeric" => "Das :attribute darf nicht größer sein als :max.",
        "string" => "Das :attribute darf nicht größer sein als :max Zeichen."
    ],
    "mimes" => "Das :attribute muss eine Datei des Typs: :valuesWerte sein.",
    "mimetypes" => "Das :attribute muss eine Datei des Typs: :values sein.",
    "min" => [
        "array" => "Das :attribute muss mindestens Folgendes enthalten :min . Elemente.",
        "file" => "Das :attribute muss mindestens Folgendes umfassen :min Kilobytes.",
        "numeric" => "Das :attribute muss mindestens betragen :min.",
        "string" => "Das :attribute muss mindestens aus :min Zeichen bestehen."
    ],
    "not_in" => "Das ausgewählte :attribute ist ungültig.",
    "not_regex" => "Das Attributformat :attribute ist ungültig.",
    "numeric" => "Das :attribute muss eine Zahl sein.",
    "present" => "Das Attributfeld :attribute muss vorhanden sein.",
    "regex" => "Das Attributformat :attribute ist ungültig.",
    "required" => "Das :attribute ist erforderlich.",
    "required_if" => "Das :attribute ist erforderlich, wenn: other is :value ist.",
    "required_unless" => "Das Attributfeld :attribute ist erforderlich, es sei denn :value other ist in .",
    "required_with" => "Das :attribute ist erforderlich, wenn :values Werte vorhanden ist.",
    "required_with_all" => "Das :attribute ist erforderlich, wenn :values Werte vorhanden sind.",
    "required_without" => "Das :attribute ist erforderlich, wenn :valuesWerte nicht vorhanden sind.",
    "required_without_all" => "Das :attribute ist erforderlich, wenn :valueskeine Werte vorhanden sind.",
    "same" => "Das :attribute -Attribut und :other Andere müssen übereinstimmen.",
    "size" => [
        "array" => "Das :attribute muss :size Elemente der Größe enthalten.",
        "file" => "Das :attribute :size muss die Größe Kilobytes haben.",
        "numeric" => "Das :attribute :size muss die Größe haben.",
        "string" => "Das :attribute muss Folgendes :size Zeichengröße."
    ],
    "starts_with" => "Das :attribute muss mit einem der folgenden Werte beginnen: :values",
    "string" => "Das :attribute muss eine Zeichenfolge sein.",
    "timezone" => "Das :attribute muss eine gültige Zone sein.",
    "unique" => "Das attribute: wurde bereits übernommen.",
    "uploaded" => "Das :attribute konnte nicht hochgeladen werden.",
    "url" => "Das :attribute ist ungültig.",
    "uuid" => "Das :attribute muss eine gültige UUID sein."
];
