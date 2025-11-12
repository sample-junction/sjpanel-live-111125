<<<<<<< HEAD
<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "Sei sicuro di voler eliminare questo utente in modo permanente? Ovunque nell'applicazione che fa riferimento all'id di questo utente molto probabilmente si verificherà un errore. Procedete a vostro rischio. Questo non può essere non fatto.",
                "if_confirmed_off" => "(Se confermato è disattivato)",
                "no_deactivated" => "Non ci sono utenti disattivati.",
                "no_deleted" => "Non ci sono utenti eliminati.",
                "restore_user_confirm" => "Ripristinare questo utente al suo stato originale?"
            ]
        ],
        "dashboard" => [
            "title" => "Cruscotto",
            "welcome" => "benvenuto"
        ],
        "general" => [
            "all_rights_reserved" => "Tutti i diritti riservati.",
            "are_you_sure" => "Sei sicuro di volerlo fare?",
            "boilerplate_link" => "Laravel 5 Boilerplate",
            "continue" => "Continua",
            "member_since" => "Membro da",
            "minutes" => "minuti",
            "search_placeholder" => "Ricerca...",
            "see_all" => [
                "messages" => "Vedi tutti i messaggi",
                "notifications" => "Guarda tutto",
                "tasks" => "Visualizza tutte le attività"
            ],
            "status" => [
                "offline" => "disconnesso",
                "online" => "in linea"
            ],
            "timeout" => "Sei stato disconnesso automaticamente per motivi di sicurezza dal momento che non hai attività in",
            "you_have" => [
                "messages" => "{0} Non hai messaggi | {1} Hai 1 messaggio | [2, Inf] Hai :number di messaggi",
                "notifications" => "{0} Non hai notifiche | {1} Hai 1 notifica | [2, Inf] Hai :number notifiche del numero",
                "tasks" => "{0} Non hai compiti | {1} Hai 1 compito | [2, Inf] Hai :number attività"
            ]
        ],
        "search" => [
            "empty" => "Si prega di inserire un termine di ricerca.",
            "incomplete" => "È necessario scrivere la propria logica di ricerca per questo sistema.",
            "results" => "Risultati della ricerca per :query",
            "title" => "risultati di ricerca"
        ],
        "welcome" => "<p> Questo è il tema CoreUI di <a href=\"https://coreui.io/\" target=\"_blank\"> creativeLabs </a>. Questa è una versione ridotta con solo il necessario stili e script per farlo funzionare. Scarica la versione completa per iniziare ad aggiungere componenti alla tua dashboard. </ p>\n <p> Tutte le funzionalità sono per lo show ad eccezione di <strong> Accesso </ strong> a sinistra. Questo boilerplate viene fornito con una libreria di controllo degli accessi completamente funzionale per gestire utenti e ruoli basati su <a href=\"https://github.com/spatie/laravel-permission\" target=\"_blank\"> spatie / laravel- il permesso </a>. </ p>\n <p> Ricorda che è un work in progress e potrebbero essere bug o altri problemi che non ho riscontrato. Farò del mio meglio per sistemarli mentre li ricevo. </ P>\n <p> Spero che ti piaccia tutto il lavoro che ho dedicato a questo. Visita la pagina <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"_blank\"> GitHub </a> per ulteriori informazioni e segnala qualsiasi <a href = \" https://github.com/rappasoft/Laravel-5-Boilerplate/issues \" target = \" _ blank \"> problemi qui </a>. </ p>\n <p> <strong> Questo progetto è molto impegnativo per tenere il passo con la velocità con cui il ramo principale di Laravel cambia, quindi qualsiasi aiuto è apprezzato. </ strong> </ p>\n <p> - Anthony Rappa </ p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Il tuo account è stato confermato",
            "click_to_confirm" => "Clicca qui per confermare il tuo account:",
            "confirmation" => [
                "copyright" => "Diritto d'autore",
                "details_1" => "Abbiamo completato la configurazione del tuo account SJ Panel.",
                "details_2" => "Basta confermare la tua email per iniziare!",
                "faq" => "FAQ's",
                "greeting" => "Hey",
                "heading" => "Sei pronto per andare!",
                "how_it_works" => "Come funziona",
                "rewards" => "Rewards",
                "unsubscribe" => "Annulla l'iscrizione"
            ],
            "error" => "Ops!",
            "greeting" => "Ciao!",
            "password_cause_of_email" => "Hai ricevuto questa email perché abbiamo ricevuto una richiesta di reimpostazione della password per il tuo account.",
            "password_if_not_requested" => "Se non hai richiesto la reimpostazione della password, segnalalo a help@sjpanel.com",
            "password_reset_subject" => "Resetta la password",
            "regards" => "Saluti,",
            "reset_password" => "Clicca qui per reimpostare la tua password",
            "thank_you_for_using_app" => "Grazie per aver utilizzato la nostra applicazione!",
            "trouble_clicking_button" => "Se riscontri problemi nel fare clic sul pulsante \":action_text\", copia e incolla l'URL sottostante nel tuo browser web:"
        ],
        "contact" => [
            "email_body_title" => "Hai una nuova richiesta di modulo di contatto: Di seguito sono riportati i dettagli:",
            "subject" => "Una nuova :app_name invio del modulo di contatto!"
        ]
    ],
    "frontend" => [
        "disclaimer" => "Hai ricevuto questa mail perché sei registrato con noi come membro del Panel e hai acconsentito a ricevere comunicazioni e-mail per ricevere sondaggi e guadagnare premi. Puoi sempre annullare l'iscrizione alla nostra mailing list, facendo clic su",
        "general" => [
            "joined" => "Iscritto"
        ],
        "test" => "Test",
        "tests" => [
            "based_on" => [
                "permission" => "Autorizzazione basata -",
                "role" => "Basato sul ruolo -"
            ],
            "js_injected_from_controller" => "Javascript iniettato da un controller",
            "using_access_helper" => [
                "array_permissions" => "Utilizzo di Access Helper con array di autorizzazioni Nomi o ID in cui l'utente deve possedere tutto.",
                "array_permissions_not" => "Utilizzo di Access Helper con array di autorizzazioni Nomi o ID in cui l'utente non deve possedere tutto.",
                "array_roles" => "Utilizzo di Access Helper con array di nomi di ruolo o ID in cui l'utente deve possedere tutto.",
                "array_roles_not" => "Utilizzo di Access Helper con array di nomi di ruolo o ID in cui l'utente non deve possedere tutto.",
                "permission_id" => "Utilizzo di Access Helper con ID di autorizzazione",
                "permission_name" => "Utilizzo di Access Helper con nome di autorizzazione",
                "role_id" => "Utilizzo di Access Helper con ID ruolo",
                "role_name" => "Utilizzo di Access Helper con nome ruolo"
            ],
            "using_blade_extensions" => "Utilizzando le estensioni Blade",
            "view_console_it_works" => "Guarda la console, dovresti vedere 'funziona!' che proviene da FrontendController @ index",
            "you_can_see_because" => "Puoi vedere questo perché hai il ruolo di ':role'!",
            "you_can_see_because_permission" => "Puoi vedere questo perché hai il permesso di \":permission\"!"
        ],
        "user" => [
            "change_email_notice" => "Se cambi la tua e-mail, sarai disconnesso finché non confermerai il tuo nuovo indirizzo e-mail.",
            "email_changed_notice" => "È necessario confermare il nuovo indirizzo e-mail prima di poter accedere di nuovo.",
            "password_updated" => "Password aggiornata con successo.",
            "profile_updated" => "Profilo aggiornato con successo."
        ],
        "welcome_to" => "Benvenuto su :place"
    ]
];
=======
<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "Sei sicuro di voler eliminare questo utente in modo permanente? Ovunque nell'applicazione che fa riferimento all'id di questo utente molto probabilmente si verificherà un errore. Procedete a vostro rischio. Questo non può essere non fatto.",
                "if_confirmed_off" => "(Se confermato è disattivato)",
                "no_deactivated" => "Non ci sono utenti disattivati.",
                "no_deleted" => "Non ci sono utenti eliminati.",
                "restore_user_confirm" => "Ripristinare questo utente al suo stato originale?"
            ]
        ],
        "dashboard" => [
            "title" => "Cruscotto",
            "welcome" => "benvenuto"
        ],
        "general" => [
            "all_rights_reserved" => "Tutti i diritti riservati.",
            "are_you_sure" => "Sei sicuro di volerlo fare?",
            "boilerplate_link" => "Laravel 5 Boilerplate",
            "continue" => "Continua",
            "member_since" => "Membro da",
            "minutes" => "minuti",
            "search_placeholder" => "Ricerca...",
            "see_all" => [
                "messages" => "Vedi tutti i messaggi",
                "notifications" => "Guarda tutto",
                "tasks" => "Visualizza tutte le attività"
            ],
            "status" => [
                "offline" => "disconnesso",
                "online" => "in linea"
            ],
            "timeout" => "Sei stato disconnesso automaticamente per motivi di sicurezza dal momento che non hai attività in",
            "you_have" => [
                "messages" => "{0} Non hai messaggi | {1} Hai 1 messaggio | [2, Inf] Hai :number di messaggi",
                "notifications" => "{0} Non hai notifiche | {1} Hai 1 notifica | [2, Inf] Hai :number notifiche del numero",
                "tasks" => "{0} Non hai compiti | {1} Hai 1 compito | [2, Inf] Hai :number attività"
            ]
        ],
        "search" => [
            "empty" => "Si prega di inserire un termine di ricerca.",
            "incomplete" => "È necessario scrivere la propria logica di ricerca per questo sistema.",
            "results" => "Risultati della ricerca per :query",
            "title" => "risultati di ricerca"
        ],
        "welcome" => "<p> Questo è il tema CoreUI di <a href=\"https://coreui.io/\" target=\"_blank\"> creativeLabs </a>. Questa è una versione ridotta con solo il necessario stili e script per farlo funzionare. Scarica la versione completa per iniziare ad aggiungere componenti alla tua dashboard. </ p>\n <p> Tutte le funzionalità sono per lo show ad eccezione di <strong> Accesso </ strong> a sinistra. Questo boilerplate viene fornito con una libreria di controllo degli accessi completamente funzionale per gestire utenti e ruoli basati su <a href=\"https://github.com/spatie/laravel-permission\" target=\"_blank\"> spatie / laravel- il permesso </a>. </ p>\n <p> Ricorda che è un work in progress e potrebbero essere bug o altri problemi che non ho riscontrato. Farò del mio meglio per sistemarli mentre li ricevo. </ P>\n <p> Spero che ti piaccia tutto il lavoro che ho dedicato a questo. Visita la pagina <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"_blank\"> GitHub </a> per ulteriori informazioni e segnala qualsiasi <a href = \" https://github.com/rappasoft/Laravel-5-Boilerplate/issues \" target = \" _ blank \"> problemi qui </a>. </ p>\n <p> <strong> Questo progetto è molto impegnativo per tenere il passo con la velocità con cui il ramo principale di Laravel cambia, quindi qualsiasi aiuto è apprezzato. </ strong> </ p>\n <p> - Anthony Rappa </ p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Il tuo account è stato confermato",
            "click_to_confirm" => "Clicca qui per confermare il tuo account:",
            "confirmation" => [
                "copyright" => "Diritto d'autore",
                "details_1" => "Abbiamo completato la configurazione del tuo account SJ Panel.",
                "details_2" => "Basta confermare la tua email per iniziare!",
                "faq" => "FAQ's",
                "greeting" => "Hey",
                "heading" => "Sei pronto per andare!",
                "how_it_works" => "Come funziona",
                "rewards" => "Rewards",
                "unsubscribe" => "Annulla l'iscrizione"
            ],
            "error" => "Ops!",
            "greeting" => "Ciao!",
            "password_cause_of_email" => "Hai ricevuto questa email perché abbiamo ricevuto una richiesta di reimpostazione della password per il tuo account.",
            "password_if_not_requested" => "Se non hai richiesto la reimpostazione della password, segnalalo a help@sjpanel.com",
            "password_reset_subject" => "Resetta la password",
            "regards" => "Saluti,",
            "reset_password" => "Clicca qui per reimpostare la tua password",
            "thank_you_for_using_app" => "Grazie per aver utilizzato la nostra applicazione!",
            "trouble_clicking_button" => "Se riscontri problemi nel fare clic sul pulsante \":action_text\", copia e incolla l'URL sottostante nel tuo browser web:"
        ],
        "contact" => [
            "email_body_title" => "Hai una nuova richiesta di modulo di contatto: Di seguito sono riportati i dettagli:",
            "subject" => "Una nuova :app_name invio del modulo di contatto!"
        ]
    ],
    "frontend" => [
        "disclaimer" => "Hai ricevuto questa mail perché sei registrato con noi come membro del Panel e hai acconsentito a ricevere comunicazioni e-mail per ricevere sondaggi e guadagnare premi. Puoi sempre annullare l'iscrizione alla nostra mailing list, facendo clic su",
        "general" => [
            "joined" => "Iscritto"
        ],
        "test" => "Test",
        "tests" => [
            "based_on" => [
                "permission" => "Autorizzazione basata -",
                "role" => "Basato sul ruolo -"
            ],
            "js_injected_from_controller" => "Javascript iniettato da un controller",
            "using_access_helper" => [
                "array_permissions" => "Utilizzo di Access Helper con array di autorizzazioni Nomi o ID in cui l'utente deve possedere tutto.",
                "array_permissions_not" => "Utilizzo di Access Helper con array di autorizzazioni Nomi o ID in cui l'utente non deve possedere tutto.",
                "array_roles" => "Utilizzo di Access Helper con array di nomi di ruolo o ID in cui l'utente deve possedere tutto.",
                "array_roles_not" => "Utilizzo di Access Helper con array di nomi di ruolo o ID in cui l'utente non deve possedere tutto.",
                "permission_id" => "Utilizzo di Access Helper con ID di autorizzazione",
                "permission_name" => "Utilizzo di Access Helper con nome di autorizzazione",
                "role_id" => "Utilizzo di Access Helper con ID ruolo",
                "role_name" => "Utilizzo di Access Helper con nome ruolo"
            ],
            "using_blade_extensions" => "Utilizzando le estensioni Blade",
            "view_console_it_works" => "Guarda la console, dovresti vedere 'funziona!' che proviene da FrontendController @ index",
            "you_can_see_because" => "Puoi vedere questo perché hai il ruolo di ':role'!",
            "you_can_see_because_permission" => "Puoi vedere questo perché hai il permesso di \":permission\"!"
        ],
        "user" => [
            "change_email_notice" => "Se cambi la tua e-mail, sarai disconnesso finché non confermerai il tuo nuovo indirizzo e-mail.",
            "email_changed_notice" => "È necessario confermare il nuovo indirizzo e-mail prima di poter accedere di nuovo.",
            "password_updated" => "Password aggiornata con successo.",
            "profile_updated" => "Profilo aggiornato con successo."
        ],
        "welcome_to" => "Benvenuto su :place"
    ]
];
>>>>>>> dev
