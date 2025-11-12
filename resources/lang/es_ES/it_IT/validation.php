<<<<<<< HEAD
<?php

return [
    "accepted" => "L'attributo :attribute deve essere accettato.",
    "active_url" => "L'attributo :attribute non è un URL valido.",
    "after" => "L'attributo :attribute deve essere una data successiva alla :data.",
    "after_or_equal" => "L'attributo :attribute deve essere una data successiva o uguale a :data.",
    "alpha" => "L'attributo :attribute può contenere solo lettere.",
    "alpha_dash" => "L'attributo :attribute può contenere solo lettere, numeri, trattini e caratteri di sottolineatura.",
    "alpha_num" => "L'attributo :attribute può contenere solo lettere e numeri.",
    "array" => "L'attributo :attribute deve essere un array.",
    "attributes" => [
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "Ruoli associati",
                    "dependencies" => "dipendenze",
                    "display_name" => "Nome da visualizzare",
                    "first_name" => "Nome di battesimo",
                    "group" => "Gruppo",
                    "group_sort" => "Raggruppa ordinamento",
                    "groups" => [
                        "name" => "Nome del gruppo"
                    ],
                    "last_name" => "Cognome",
                    "name" => "Nome",
                    "system" => "Sistema"
                ],
                "roles" => [
                    "associated_permissions" => "Autorizzazioni associate",
                    "name" => "Nome",
                    "sort" => "Ordinare"
                ],
                "users" => [
                    "active" => "Attivo",
                    "associated_roles" => "Ruoli associati",
                    "confirmed" => "Confermato",
                    "email" => "Indirizzo email",
                    "first_name" => "Nome di battesimo",
                    "language" => "linguaggio",
                    "last_name" => "Cognome",
                    "name" => "Nome",
                    "other_permissions" => "Altre autorizzazioni",
                    "password" => "Parola d'ordine",
                    "password_confirmation" => "Conferma password",
                    "send_confirmation_email" => "Invia e-mail di conferma",
                    "timezone" => "Fuso orario"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "Posizione Avatar",
            "email" => "Indirizzo email",
            "first_name" => "Nome di battesimo",
            "middle_name" => "Secondo nome",
            "language" => "linguaggio",
            "last_name" => "Cognome",
            "message" => "Messaggio",
            "name" => "Nome e cognome",
            "new_password" => "nuova password",
            "new_password_confirmation" => "Nuova password di conferma",
            "old_password" => "vecchia password",
            "password" => "Parola d'ordine",
            "password_confirmation" => "Conferma password",
            "phone" => "Telefono",
            "timezone" => "Fuso orario",
            "password_require" => "Requisito password:",
            "password_require1" => "La lunghezza minima della password è di 8 caratteri.",
            "password_require2" => "Richiede almeno una lettera maiuscola dell'albhabet latino (A-Z).",
            "password_require3" => "Richiedi almeno un numero.",
            "password_require4" => "Richiedi almeno un carattere non alfanumerico (!@#$%^&*()_+=[]{}|')
            ",
        ]
    ],
    "before" => "L'attributo :attribute deve essere una data precedente :data.",
    "before_or_equal" => "L'attributo :attribute deve essere una data precedente o uguale a :date .",
    "between" => [
        "array" => "L'attributo :attribute deve avere tra :min e :max elementi.",
        "file" => "L'attributo:attribute deve essere compreso tra :min e :max kilobyte.",
        "numeric" => "L'attributo :attribute deve essere compreso tra :min e :max.",
        "string" => "L'attributo :attribute deve essere compreso tra :min e :max caratteri."
    ],
    "boolean" => "Il campo :attribute deve essere vero o falso.",
    "confirmed" => "La :attribute conferma di attributo non corrisponde.",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "custom-messaggio"
        ]
    ],
    "date" => "L'attributo :attribute non è una data valida.",
    "date_equals" => ":attribute deve essere una data uguale a :date.",
    "date_format" => "L'attributo :attribute non corrisponde al formato :format.",
    "different" => ":attribute e l'altro :other devono essere diversi.",
    "digits" => "L'attributo :attribute deve essere :digits cifre.",
    "digits_between" => "L'attributo :attribute deve essere compreso tra :min e :max massime.",
    "dimensions" => ":attribute ha dimensioni di immagine non valide.",
    "distinct" => "Il campo :attribute ha un valore duplicato.",
    "email" => ":attribute deve essere un indirizzo email valido.",
    "exists" => ":attribute selezionato non è valido.",
    "file" => ":attribute deve essere un file.",
    "filled" => "Il campo:attribute deve avere un :value .",
    "gt" => [
        "array" => ":attribute deve avere più di :value.",
        "file" => ":attribute deve essere maggiore di :value kilobyte.",
        "numeric" => ":attribute deve essere maggiore di :value .",
        "string" => ":attribute deve essere maggiore di :value caratteri."
    ],
    "gte" => [
        "array" => ":attribute deve:value elementi valore o altro.",
        "file" => ":attribute deve essere maggiore o uguale :value kilobyte.",
        "numeric" => ":attribute deve essere maggiore o uguale :val;ue.",
        "string" => ":attribute deve essere maggiore o uguale :value caratteri."
    ],
    "image" => ":attribute deve essere un'immagine.",
    "in" => ":attribute selezionato non è valido.",
    "in_array" => "Il campo :attribute non esiste in :other.",
    "integer" => ":attribute deve essere un numero intero.",
    "ip" => ":attribute deve essere un indirizzo IP valido.",
    "ipv4" => ":attribute deve essere un indirizzo IPv4 valido.",
    "ipv6" => ":attribute deve essere un indirizzo IPv6 valido.",
    "json" => ":attribute deve essere una stringa JSON valida.",
    "lt" => [
        "array" => ":attribute deve avere meno di: elementi valore.",
        "file" => ":attribute deve essere inferiore a :value kilobyte.",
        "numeric" => ":attribute deve essere inferiore a :value .",
        "string" => ":attribute deve essere inferiore a :value caratteri."
    ],
    "lte" => [
        "array" => ":attribute non deve avere più di :value elementi valore.",
        "file" => ":attribute deve essere minore o uguale :value kilobyte.",
        "numeric" => ":attribute deve essere minore o uguale :value.",
        "string" => ":attribute deve essere minore o uguale :value caratteri."
    ],
    "max" => [
        "array" => ":attribute non può avere più di :max articoli .",
        "file" => ":attribute non può essere maggiore di :max kilobyte.",
        "numeric" => ":attribute non può essere maggiore di :max.",
        "string" => ":attribute non può essere maggiore di :max caratteri ."
    ],
    "mimes" => ":attribute deve essere un file di tipo :values .2",
    "mimetypes" => ":attribute deve essere un file di tipo: :values.",
    "min" => [
        "array" => ":attribute deve avere almeno :min elementi .",
        "file" => ":attribute deve essere almeno :min kilobyte.",
        "numeric" => ":attribute deve essere almeno :min.",
        "string" => ":attribute deve essere almeno :min caratteri."
    ],
    "not_in" => ":attribute selezionato non è valido.",
    "not_regex" => "Il formato :attribute non è valido.",
    "numeric" => ":attribute deve essere un numero.",
    "present" => "Il campo :attribute deve essere presente.",
    "regex" => "Il formato :attribute non è valido.",
    "required" => "Il campo:attribute è obbligatorio.",
    "required_if" => "Il campo :attribute è obbligatorio quando :value altro è .",
    "required_unless" => "Il campo :attribute è obbligatorio a meno che :value altro sia in.",
    "required_with" => "Il campo :attribute è obbligatorio quando :values i valori sono presenti.",
    "required_with_all" => "Il campo :attribute è obbligatorio quando :values i valori sono presenti.",
    "required_without" => "Il campo :attribute è obbligatorio quando :values i valori non sono presenti.",
    "required_without_all" => "Il campo :attribute è richiesto quando nessuno dei :values sono presenti.",
    "same" => ":attribute e :other l'altro deve corrispondere.",
    "size" => [
        "array" => ":attribute deve contenere :size dimensioni.",
        "file" => ":attribute deve essere :size dimensione kilobyte.",
        "numeric" => ":attribute deve essere :size.",
        "string" => ":attribute deve essere :size caratteri."
    ],
    "starts_with" => ":attribute deve iniziare con uno dei seguenti: :values",
    "string" => ":attribute deve essere una stringa.",
    "timezone" => ":attribute deve essere una zona valida.",
    "unique" => ":attribute è già stato preso.",
    "uploaded" => ":attribute impossibile caricare.",
    "url" => "Il formato :attribute non è valido.",
    "uuid" => ":attribute deve essere un UUID valido."
];
=======
<?php

return [
    "accepted" => "L'attributo :attribute deve essere accettato.",
    "active_url" => "L'attributo :attribute non è un URL valido.",
    "after" => "L'attributo :attribute deve essere una data successiva alla :data.",
    "after_or_equal" => "L'attributo :attribute deve essere una data successiva o uguale a :data.",
    "alpha" => "L'attributo :attribute può contenere solo lettere.",
    "alpha_dash" => "L'attributo :attribute può contenere solo lettere, numeri, trattini e caratteri di sottolineatura.",
    "alpha_num" => "L'attributo :attribute può contenere solo lettere e numeri.",
    "array" => "L'attributo :attribute deve essere un array.",
    "attributes" => [
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "Ruoli associati",
                    "dependencies" => "dipendenze",
                    "display_name" => "Nome da visualizzare",
                    "first_name" => "Nome di battesimo",
                    "group" => "Gruppo",
                    "group_sort" => "Raggruppa ordinamento",
                    "groups" => [
                        "name" => "Nome del gruppo"
                    ],
                    "last_name" => "Cognome",
                    "name" => "Nome",
                    "system" => "Sistema"
                ],
                "roles" => [
                    "associated_permissions" => "Autorizzazioni associate",
                    "name" => "Nome",
                    "sort" => "Ordinare"
                ],
                "users" => [
                    "active" => "Attivo",
                    "associated_roles" => "Ruoli associati",
                    "confirmed" => "Confermato",
                    "email" => "Indirizzo email",
                    "first_name" => "Nome di battesimo",
                    "language" => "linguaggio",
                    "last_name" => "Cognome",
                    "name" => "Nome",
                    "other_permissions" => "Altre autorizzazioni",
                    "password" => "Parola d'ordine",
                    "password_confirmation" => "Conferma password",
                    "send_confirmation_email" => "Invia e-mail di conferma",
                    "timezone" => "Fuso orario"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "Posizione Avatar",
            "email" => "Indirizzo email",
            "first_name" => "Nome di battesimo",
            "middle_name" => "Secondo nome",
            "language" => "linguaggio",
            "last_name" => "Cognome",
            "message" => "Messaggio",
            "name" => "Nome e cognome",
            "new_password" => "nuova password",
            "new_password_confirmation" => "Nuova password di conferma",
            "old_password" => "vecchia password",
            "password" => "Parola d'ordine",
            "password_confirmation" => "Conferma password",
            "phone" => "Telefono",
            "timezone" => "Fuso orario",
            "password_require" => "Requisito password:",
            "password_require1" => "La lunghezza minima della password è di 8 caratteri.",
            "password_require2" => "Richiede almeno una lettera maiuscola dell'albhabet latino (A-Z).",
            "password_require3" => "Richiedi almeno un numero.",
            "password_require4" => "Richiedi almeno un carattere non alfanumerico (!@#$%^&*()_+=[]{}|')
            ",
        ]
    ],
    "before" => "L'attributo :attribute deve essere una data precedente :data.",
    "before_or_equal" => "L'attributo :attribute deve essere una data precedente o uguale a :date .",
    "between" => [
        "array" => "L'attributo :attribute deve avere tra :min e :max elementi.",
        "file" => "L'attributo:attribute deve essere compreso tra :min e :max kilobyte.",
        "numeric" => "L'attributo :attribute deve essere compreso tra :min e :max.",
        "string" => "L'attributo :attribute deve essere compreso tra :min e :max caratteri."
    ],
    "boolean" => "Il campo :attribute deve essere vero o falso.",
    "confirmed" => "La :attribute conferma di attributo non corrisponde.",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "custom-messaggio"
        ]
    ],
    "date" => "L'attributo :attribute non è una data valida.",
    "date_equals" => ":attribute deve essere una data uguale a :date.",
    "date_format" => "L'attributo :attribute non corrisponde al formato :format.",
    "different" => ":attribute e l'altro :other devono essere diversi.",
    "digits" => "L'attributo :attribute deve essere :digits cifre.",
    "digits_between" => "L'attributo :attribute deve essere compreso tra :min e :max massime.",
    "dimensions" => ":attribute ha dimensioni di immagine non valide.",
    "distinct" => "Il campo :attribute ha un valore duplicato.",
    "email" => ":attribute deve essere un indirizzo email valido.",
    "exists" => ":attribute selezionato non è valido.",
    "file" => ":attribute deve essere un file.",
    "filled" => "Il campo:attribute deve avere un :value .",
    "gt" => [
        "array" => ":attribute deve avere più di :value.",
        "file" => ":attribute deve essere maggiore di :value kilobyte.",
        "numeric" => ":attribute deve essere maggiore di :value .",
        "string" => ":attribute deve essere maggiore di :value caratteri."
    ],
    "gte" => [
        "array" => ":attribute deve:value elementi valore o altro.",
        "file" => ":attribute deve essere maggiore o uguale :value kilobyte.",
        "numeric" => ":attribute deve essere maggiore o uguale :val;ue.",
        "string" => ":attribute deve essere maggiore o uguale :value caratteri."
    ],
    "image" => ":attribute deve essere un'immagine.",
    "in" => ":attribute selezionato non è valido.",
    "in_array" => "Il campo :attribute non esiste in :other.",
    "integer" => ":attribute deve essere un numero intero.",
    "ip" => ":attribute deve essere un indirizzo IP valido.",
    "ipv4" => ":attribute deve essere un indirizzo IPv4 valido.",
    "ipv6" => ":attribute deve essere un indirizzo IPv6 valido.",
    "json" => ":attribute deve essere una stringa JSON valida.",
    "lt" => [
        "array" => ":attribute deve avere meno di: elementi valore.",
        "file" => ":attribute deve essere inferiore a :value kilobyte.",
        "numeric" => ":attribute deve essere inferiore a :value .",
        "string" => ":attribute deve essere inferiore a :value caratteri."
    ],
    "lte" => [
        "array" => ":attribute non deve avere più di :value elementi valore.",
        "file" => ":attribute deve essere minore o uguale :value kilobyte.",
        "numeric" => ":attribute deve essere minore o uguale :value.",
        "string" => ":attribute deve essere minore o uguale :value caratteri."
    ],
    "max" => [
        "array" => ":attribute non può avere più di :max articoli .",
        "file" => ":attribute non può essere maggiore di :max kilobyte.",
        "numeric" => ":attribute non può essere maggiore di :max.",
        "string" => ":attribute non può essere maggiore di :max caratteri ."
    ],
    "mimes" => ":attribute deve essere un file di tipo :values .2",
    "mimetypes" => ":attribute deve essere un file di tipo: :values.",
    "min" => [
        "array" => ":attribute deve avere almeno :min elementi .",
        "file" => ":attribute deve essere almeno :min kilobyte.",
        "numeric" => ":attribute deve essere almeno :min.",
        "string" => ":attribute deve essere almeno :min caratteri."
    ],
    "not_in" => ":attribute selezionato non è valido.",
    "not_regex" => "Il formato :attribute non è valido.",
    "numeric" => ":attribute deve essere un numero.",
    "present" => "Il campo :attribute deve essere presente.",
    "regex" => "Il formato :attribute non è valido.",
    "required" => "Il campo:attribute è obbligatorio.",
    "required_if" => "Il campo :attribute è obbligatorio quando :value altro è .",
    "required_unless" => "Il campo :attribute è obbligatorio a meno che :value altro sia in.",
    "required_with" => "Il campo :attribute è obbligatorio quando :values i valori sono presenti.",
    "required_with_all" => "Il campo :attribute è obbligatorio quando :values i valori sono presenti.",
    "required_without" => "Il campo :attribute è obbligatorio quando :values i valori non sono presenti.",
    "required_without_all" => "Il campo :attribute è richiesto quando nessuno dei :values sono presenti.",
    "same" => ":attribute e :other l'altro deve corrispondere.",
    "size" => [
        "array" => ":attribute deve contenere :size dimensioni.",
        "file" => ":attribute deve essere :size dimensione kilobyte.",
        "numeric" => ":attribute deve essere :size.",
        "string" => ":attribute deve essere :size caratteri."
    ],
    "starts_with" => ":attribute deve iniziare con uno dei seguenti: :values",
    "string" => ":attribute deve essere una stringa.",
    "timezone" => ":attribute deve essere una zona valida.",
    "unique" => ":attribute è già stato preso.",
    "uploaded" => ":attribute impossibile caricare.",
    "url" => "Il formato :attribute non è valido.",
    "uuid" => ":attribute deve essere un UUID valido."
];
>>>>>>> dev
