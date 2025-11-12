<<<<<<< HEAD
<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "already_exists" => "Questo ruolo esiste già. Si prega di scegliere un nome diverso.",
                "cant_delete_admin" => "Non è possibile eliminare il ruolo di amministratore.",
                "create_error" => "Si è verificato un problema durante la creazione di questo ruolo. Per favore riprova.",
                "delete_error" => "Si è verificato un problema durante l'eliminazione di questo ruolo. Per favore riprova.",
                "has_users" => "Non è possibile eliminare un ruolo con utenti associati.",
                "needs_permission" => "Devi selezionare almeno una autorizzazione per questo ruolo.",
                "not_found" => "Quel ruolo non esiste.",
                "update_error" => "Si è verificato un problema durante l'aggiornamento di questo ruolo. Per favore riprova."
            ],
            "users" => [
                "already_confirmed" => "Questo utente è già confermato.",
                "cant_confirm" => "Si è verificato un problema durante la conferma dell'account utente.",
                "cant_deactivate_self" => "Non puoi farlo per te.",
                "cant_delete_admin" => "Non è possibile eliminare il super amministratore.",
                "cant_delete_own_session" => "Non è possibile cancellare la propria sessione.",
                "cant_delete_self" => "Non puoi cancellarti.",
                "cant_restore" => "Questo utente non è cancellato quindi non può essere ripristinato.",
                "cant_unconfirm_admin" => "Non è possibile annullare la conferma del super amministratore.",
                "cant_unconfirm_self" => "Non puoi annullare la conferma.",
                "create_error" => "Si è verificato un problema durante la creazione di questo utente. Per favore riprova.",
                "delete_error" => "Si è verificato un problema durante l'eliminazione di questo utente. Per favore riprova.",
                "delete_first" => "Questo utente deve essere cancellato prima di poter essere distrutto in modo permanente.",
                "email_error" => "Quell'indirizzo email appartiene a un altro utente.",
                "mark_error" => "Si è verificato un problema durante l'aggiornamento di questo utente. Per favore riprova.",
                "not_confirmed" => "Questo utente non è confermato.",
                "not_found" => "Quell'utente non esiste.",
                "restore_error" => "Si è verificato un problema nel ripristino di questo utente. Per favore riprova.",
                "role_needed" => "Devi scegliere almeno un ruolo.",
                "role_needed_create" => "È necessario scegliere in leasing un ruolo.",
                "session_wrong_driver" => "Il tuo driver di sessione deve essere impostato sul database per utilizzare questa funzione.",
                "social_delete_error" => "Si è verificato un problema durante la rimozione dell'account social da parte dell'utente.",
                "update_error" => "Si è verificato un problema durante l'aggiornamento di questo utente. Per favore riprova.",
                "update_password_error" => "Si è verificato un problema durante la modifica della password di questo utente. Per favore riprova."
            ]
        ]
    ],
    "frontend" => [
        "auth" => [
            "confirmation" => [
                "already_confirmed" => "Il tuo account è già confermato.",
                "confirm" => "Conferma il tuo account!",
                "created_confirm" => "Il tuo account è stato creato con successo. Ti abbiamo inviato una e-mail per confermare il tuo account.",
                "created_pending" => "Il tuo account è stato creato correttamente ed è in attesa di approvazione. Una e-mail verrà inviata quando il tuo account sarà approvato.",
                "mismatch" => "Il tuo codice di conferma non corrisponde.",
                "not_found" => "Questo codice di conferma non esiste.",
                "pending" => "Il tuo account è attualmente in attesa di approvazione.",
                "resend" => "Il tuo account non è confermato. Fai clic sul link di conferma nella tua e-mail o <a href=\":url\"> fai clic qui </a> per inviare nuovamente l'e-mail di conferma.",
                "resent" => "Una nuova e-mail di conferma è stata inviata all'indirizzo registrato.",
                "success" => "Il tuo account è stato confermato con successo!"
            ],
            "deactivated" => "Il tuo account è stato disattivato.",
            "email_taken" => "Questo indirizzo e-mail è già stato preso.",
            "password" => [
                "change_mismatch" => "Questa non è la tua vecchia password.",
                "reset_problem" => "Si è verificato un problema durante il ripristino della password. Si prega di inviare nuovamente l'e-mail di reimpostazione della password."
            ],
            "registration_disabled" => "La registrazione è attualmente chiusa."
        ]
    ]
];
=======
<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "already_exists" => "Questo ruolo esiste già. Si prega di scegliere un nome diverso.",
                "cant_delete_admin" => "Non è possibile eliminare il ruolo di amministratore.",
                "create_error" => "Si è verificato un problema durante la creazione di questo ruolo. Per favore riprova.",
                "delete_error" => "Si è verificato un problema durante l'eliminazione di questo ruolo. Per favore riprova.",
                "has_users" => "Non è possibile eliminare un ruolo con utenti associati.",
                "needs_permission" => "Devi selezionare almeno una autorizzazione per questo ruolo.",
                "not_found" => "Quel ruolo non esiste.",
                "update_error" => "Si è verificato un problema durante l'aggiornamento di questo ruolo. Per favore riprova."
            ],
            "users" => [
                "already_confirmed" => "Questo utente è già confermato.",
                "cant_confirm" => "Si è verificato un problema durante la conferma dell'account utente.",
                "cant_deactivate_self" => "Non puoi farlo per te.",
                "cant_delete_admin" => "Non è possibile eliminare il super amministratore.",
                "cant_delete_own_session" => "Non è possibile cancellare la propria sessione.",
                "cant_delete_self" => "Non puoi cancellarti.",
                "cant_restore" => "Questo utente non è cancellato quindi non può essere ripristinato.",
                "cant_unconfirm_admin" => "Non è possibile annullare la conferma del super amministratore.",
                "cant_unconfirm_self" => "Non puoi annullare la conferma.",
                "create_error" => "Si è verificato un problema durante la creazione di questo utente. Per favore riprova.",
                "delete_error" => "Si è verificato un problema durante l'eliminazione di questo utente. Per favore riprova.",
                "delete_first" => "Questo utente deve essere cancellato prima di poter essere distrutto in modo permanente.",
                "email_error" => "Quell'indirizzo email appartiene a un altro utente.",
                "mark_error" => "Si è verificato un problema durante l'aggiornamento di questo utente. Per favore riprova.",
                "not_confirmed" => "Questo utente non è confermato.",
                "not_found" => "Quell'utente non esiste.",
                "restore_error" => "Si è verificato un problema nel ripristino di questo utente. Per favore riprova.",
                "role_needed" => "Devi scegliere almeno un ruolo.",
                "role_needed_create" => "È necessario scegliere in leasing un ruolo.",
                "session_wrong_driver" => "Il tuo driver di sessione deve essere impostato sul database per utilizzare questa funzione.",
                "social_delete_error" => "Si è verificato un problema durante la rimozione dell'account social da parte dell'utente.",
                "update_error" => "Si è verificato un problema durante l'aggiornamento di questo utente. Per favore riprova.",
                "update_password_error" => "Si è verificato un problema durante la modifica della password di questo utente. Per favore riprova."
            ]
        ]
    ],
    "frontend" => [
        "auth" => [
            "confirmation" => [
                "already_confirmed" => "Il tuo account è già confermato.",
                "confirm" => "Conferma il tuo account!",
                "created_confirm" => "Il tuo account è stato creato con successo. Ti abbiamo inviato una e-mail per confermare il tuo account.",
                "created_pending" => "Il tuo account è stato creato correttamente ed è in attesa di approvazione. Una e-mail verrà inviata quando il tuo account sarà approvato.",
                "mismatch" => "Il tuo codice di conferma non corrisponde.",
                "not_found" => "Questo codice di conferma non esiste.",
                "pending" => "Il tuo account è attualmente in attesa di approvazione.",
                "resend" => "Il tuo account non è confermato. Fai clic sul link di conferma nella tua e-mail o <a href=\":url\"> fai clic qui </a> per inviare nuovamente l'e-mail di conferma.",
                "resent" => "Una nuova e-mail di conferma è stata inviata all'indirizzo registrato.",
                "success" => "Il tuo account è stato confermato con successo!"
            ],
            "deactivated" => "Il tuo account è stato disattivato.",
            "email_taken" => "Questo indirizzo e-mail è già stato preso.",
            "password" => [
                "change_mismatch" => "Questa non è la tua vecchia password.",
                "reset_problem" => "Si è verificato un problema durante il ripristino della password. Si prega di inviare nuovamente l'e-mail di reimpostazione della password."
            ],
            "registration_disabled" => "La registrazione è attualmente chiusa."
        ]
    ]
];
>>>>>>> dev
