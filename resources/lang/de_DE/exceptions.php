<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "already_exists" => "Diese Rolle existiert bereits. Bitte wählen Sie einen anderen Namen.",
                "cant_delete_admin" => "Sie können die Administratorrolle nicht löschen.",
                "create_error" => "Beim Erstellen dieser Rolle ist ein Problem aufgetreten. Bitte versuche es erneut.",
                "delete_error" => "Beim Löschen dieser Rolle ist ein Problem aufgetreten. Bitte versuche es erneut.",
                "has_users" => "Sie können keine Rolle mit verknüpften Benutzern löschen.",
                "needs_permission" => "Sie müssen mindestens eine Berechtigung für diese Rolle auswählen.",
                "not_found" => "Diese Rolle existiert nicht.",
                "update_error" => "Beim Aktualisieren dieser Rolle ist ein Problem aufgetreten. Bitte versuche es erneut."
            ],
            "users" => [
                "already_confirmed" => "Dieser Benutzer ist bereits bestätigt.",
                "cant_confirm" => "Beim Bestätigen des Benutzerkontos ist ein Problem aufgetreten.",
                "cant_deactivate_self" => "Das kannst du dir nicht antun.",
                "cant_delete_admin" => "Sie können den Superadministrator nicht löschen.",
                "cant_delete_own_session" => "Sie können Ihre eigene Sitzung nicht löschen.",
                "cant_delete_self" => "Sie können sich nicht löschen.",
                "cant_restore" => "Dieser Benutzer wird nicht gelöscht und kann daher nicht wiederhergestellt werden.",
                "cant_unconfirm_admin" => "Sie können den Super-Administrator nicht rückgängig machen.",
                "cant_unconfirm_self" => "Sie können sich nicht rückgängig machen.",
                "create_error" => "Beim Erstellen dieses Benutzers ist ein Problem aufgetreten. Bitte versuche es erneut.",
                "delete_error" => "Beim Löschen dieses Benutzers ist ein Problem aufgetreten. Bitte versuche es erneut.",
                "delete_first" => "Dieser Benutzer muss zuerst gelöscht werden, bevor er endgültig zerstört werden kann.",
                "email_error" => "Diese E-Mail-Adresse gehört einem anderen Benutzer.",
                "mark_error" => "Beim Aktualisieren dieses Benutzers ist ein Fehler aufgetreten. Bitte versuche es erneut.",
                "not_confirmed" => "Dieser Benutzer wird nicht bestätigt.",
                "not_found" => "Dieser Benutzer existiert nicht.",
                "restore_error" => "Beim Wiederherstellen dieses Benutzers ist ein Problem aufgetreten. Bitte versuche es erneut.",
                "role_needed" => "Sie müssen mindestens eine Rolle auswählen.",
                "role_needed_create" => "Sie müssen mindestens eine Rolle auswählen.",
                "session_wrong_driver" => "Ihr Sitzungstreiber muss auf Datenbank eingestellt sein, um diese Funktion verwenden zu können.",
                "social_delete_error" => "Beim Entfernen des sozialen Kontos vom Benutzer ist ein Problem aufgetreten.",
                "update_error" => "Beim Aktualisieren dieses Benutzers ist ein Fehler aufgetreten. Bitte versuche es erneut.",
                "update_password_error" => "Beim Ändern dieses Benutzerkennworts ist ein Problem aufgetreten. Bitte versuche es erneut."
            ]
        ]
    ],
    "frontend" => [
        "auth" => [
            "confirmation" => [
                "already_confirmed" => "Dein Account ist bereits bestätigt.",
                "confirm" => "Bestätigen Sie ihr Konto!",
                "created_confirm" => "Ihr Konto wurde erfolgreich erstellt. Wir haben Ihnen eine E-Mail zur Bestätigung Ihres Kontos gesendet.",
                "created_pending" => "Ihr Konto wurde erfolgreich erstellt und muss noch genehmigt werden. Eine E-Mail wird gesendet, wenn Ihr Konto genehmigt wird.",
                "mismatch" => "Ihr Bestätigungscode stimmt nicht überein.",
                "not_found" => "Dieser Bestätigungscode existiert nicht.",
                "pending" => "Ihr Konto ist derzeit noch nicht freigegeben.",
                "resend" => "Ihr Konto wird nicht bestätigt. Klicken Sie in Ihrer E-Mail auf den Bestätigungslink oder <a href=\":url\"> klicken Sie hier </a>, um die Bestätigungs-E-Mail erneut zu senden.",
                "resent" => "Eine neue Bestätigungs-E-Mail wurde an die angegebene Adresse gesendet.",
                "success" => "Ihr Konto wurde erfolgreich bestätigt."
            ],
            "deactivated" => "Dein Konto wurde deaktiviert.",
            "email_taken" => "Diese E-Mail-Adresse ist bereits vergeben.",
            "password" => [
                "change_mismatch" => "Das ist nicht dein altes Passwort.",
                "reset_problem" => "Beim Zurücksetzen Ihres Passworts ist ein Problem aufgetreten. Bitte senden Sie die E-Mail zum Zurücksetzen des Passworts erneut."
            ],
            "registration_disabled" => "Die Registrierung ist derzeit geschlossen."
        ]
    ]
];
