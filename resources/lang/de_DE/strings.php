<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "Möchten Sie diesen Benutzer wirklich dauerhaft löschen? Überall in der Anwendung, die auf diese Benutzer-ID verweist, wird höchstwahrscheinlich ein Fehler angezeigt. Fahren Sie auf eigenes Risiko fort. Das kann nicht rückgängig gemacht werden.",
                "if_confirmed_off" => "(Wenn bestätigt ist aus)",
                "no_deactivated" => "Es sind keine deaktivierten Benutzer vorhanden.",
                "no_deleted" => "Es gibt keine gelöschten Benutzer.",
                "restore_user_confirm" => "Diesen Benutzer in seinen ursprünglichen Zustand zurückversetzen?"
            ]
        ],
        "dashboard" => [
            "title" => "Instrumententafel",
            "welcome" => "Herzlich willkommen"
        ],
        "general" => [
            "all_rights_reserved" => "Alle Rechte vorbehalten.",
            "are_you_sure" => "Möchten Sie das wirklich tun?",
            "boilerplate_link" => "Laravel 5 Kochplatte",
            "continue" => "Fortsetzen",
            "member_since" => "Mitglied seit",
            "minutes" => "Protokoll",
            "search_placeholder" => "Suche...",
            "see_all" => [
                "messages" => "Alle Nachrichten anzeigen",
                "notifications" => "Alle ansehen",
                "tasks" => "Alle Aufgaben anzeigen"
            ],
            "status" => [
                "offline" => "Offline",
                "online" => "Online"
            ],
            "timeout" => "Sie wurden aus Sicherheitsgründen automatisch abgemeldet, da Sie keine Aktivität hatten",
            "you_have" => [
                "messages" => "{0} Sie haben keine Nachrichten | {1} Sie haben 1 Nachricht | [2, Inf] Sie haben :number Anzahl Nachrichten",
                "notifications" => "{0} Sie haben keine Benachrichtigungen | {1} Sie haben 1 Benachrichtigung | [2, Inf] Sie haben :number Nummernbenachrichtigungen",
                "tasks" => "{0} Sie haben keine Aufgaben | {1} Sie haben 1 Aufgabe | [2, Inf] Sie haben :number Anzahl Aufgaben"
            ]
        ],
        "search" => [
            "empty" => "Bitte geben Sie einen Suchbegriff ein.",
            "incomplete" => "Sie müssen Ihre eigene Suchlogik für dieses System schreiben.",
            "results" => "Suchergebnisse für :query",
            "title" => "Suchergebnisse"
        ],
        "welcome" => "<p> Dies ist das CoreUI-Theme von <a href=\"https://coreui.io/\" target=\"_blank\"> creativeLabs </a>. Dies ist eine abgespeckte Version mit nur dem notwendigen Laden Sie die Vollversion herunter, um Komponenten zum Dashboard hinzuzufügen. </ p>\n <p> Alle Funktionen sind nur für die Anzeige mit Ausnahme des Links <strong> Zugriff </ strong> verfügbar. Diese Boilerplate wird mit einer voll funktionsfähigen Zugriffssteuerungsbibliothek für die Verwaltung von Benutzern und Rollen geliefert, die von <a href=\"https://github.com/spatie/laravel-permission\" target=\"_blank\"> spatie / laravel- Erlaubnis </a>. </ p>\n <p> Denken Sie daran, dass es sich um eine laufende Arbeit handelt, die möglicherweise Bugs oder andere Probleme enthält, die ich bisher noch nicht gesehen habe. Ich werde mein Bestes tun, um sie zu reparieren, sobald ich sie erhalte. </ P>\n <p> Ich hoffe, Sie genießen all die Arbeit, die ich in diese Arbeit gesteckt habe. Bitte besuchen Sie die Seite <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"_blank\"> GitHub </a>, um weitere Informationen zu erhalten, und melden Sie alle <a href = \" https://github.com/rappasoft/Laravel-5-Boilerplate/issues \" target = \" _ blank \"> gibt hier </a> aus. </ p>\n <p> <strong> Bei diesem Projekt ist es sehr anspruchsvoll, mit der Geschwindigkeit, mit der sich der Hauptzweig Laravel ändert, Schritt zu halten, sodass jede Hilfe geschätzt wird. </ strong> </ p>\n <p> - Anthony Rappa </ p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Ihr Konto wurde bestätigt.",
            "click_to_confirm" => "Klicken Sie hier, um Ihr Konto zu bestätigen:",
            "confirmation" => [
                "copyright" => "Urheberrechte ©",
                "details_1" => "Die Einrichtung Ihres SJ-Panel-Kontos ist abgeschlossen.",
                "details_2" => "Bestätigen Sie einfach Ihre E-Mail, um loszulegen!",
                "faq" => "FAQ's",
                "greeting" => "Hallo",
                "heading" => "Du bist bereit zu gehen!",
                "how_it_works" => "Wie es funktioniert",
                "rewards" => "Belohnt",
                "unsubscribe" => "Abmelden"
            ],
            "error" => "Hoppla!",
            "greeting" => "Hallo!",
            "password_cause_of_email" => "Sie erhalten diese E-Mail, weil wir für Ihr Konto eine Anfrage zum Zurücksetzen des Passworts erhalten haben.",
            "password_if_not_requested" => "Wenn Sie kein Zurücksetzen des Passworts beantragt haben, melden Sie sich bitte unter help@sjpanel.com",
            "password_reset_subject" => "Passwort zurücksetzen",
            "regards" => "Grüße,",
            "reset_password" => "Klicken Sie hier, um Ihr Passwort zurückzusetzen",
            "thank_you_for_using_app" => "Vielen Dank, dass Sie unsere Anwendung verwenden!",
            "trouble_clicking_button" => "Wenn Sie Probleme beim Klicken auf die Schaltfläche \":action_text\" haben, kopieren Sie die unten stehende URL und fügen Sie sie in Ihren Webbrowser ein:"
        ],
        "contact" => [
            "email_body_title" => "Sie haben eine neue Anfrage zum Kontaktformular: Nachfolgend die Details:",
            "subject" => "Eine neue :app_name Kontaktformulareinreichung!"
        ]
    ],
    "frontend" => [
        "disclaimer" => "Sie haben diese E-Mail erhalten, weil Sie als Panel-Mitglied bei uns registriert sind und sich damit einverstanden erklärt haben, E-Mail-Kommunikation für den Erhalt von Umfragen und Prämien zu erhalten. Sie können sich jederzeit von unserer Mailingliste abmelden, indem Sie auf klicken",
        "general" => [
            "joined" => "Beigetreten"
        ],
        "test" => "Prüfung",
        "tests" => [
            "based_on" => [
                "permission" => "Permission Based -",
                "role" => "Rollenbasiert -"
            ],
            "js_injected_from_controller" => "Javascript von einem Controller injiziert",
            "using_access_helper" => [
                "array_permissions" => "Verwenden der Zugriffshilfe mit einem Array von Berechtigungsnamen oder IDs, bei denen der Benutzer alle besitzen muss.",
                "array_permissions_not" => "Verwenden der Zugriffshilfe mit einem Array von Berechtigungsnamen oder IDs, bei denen der Benutzer nicht alle besitzen muss.",
                "array_roles" => "Verwenden der Zugriffshilfe mit einem Array von Rollennamen oder IDs, bei denen der Benutzer alle besitzen muss.",
                "array_roles_not" => "Verwenden der Zugriffshilfe mit einem Array von Rollennamen oder IDs, bei denen der Benutzer nicht alle besitzen muss.",
                "permission_id" => "Verwenden der Zugriffshilfe mit Berechtigungs-ID",
                "permission_name" => "Verwenden der Zugriffshilfe mit dem Berechtigungsnamen",
                "role_id" => "Verwenden von Access Helper mit Rollen-ID",
                "role_name" => "Verwenden von Access Helper mit Rollennamen"
            ],
            "using_blade_extensions" => "Blade-Erweiterungen verwenden",
            "view_console_it_works" => "Ansichtskonsole, Sie sollten \"es funktioniert!\" was von FrontendController @ Index kommt",
            "you_can_see_because" => "Sie können dies sehen, weil Sie die Rolle \":role\" haben!",
            "you_can_see_because_permission" => "Sie können dies sehen, weil Sie die Erlaubnis ':permission' haben!"
        ],
        "user" => [
            "change_email_notice" => "Wenn Sie Ihre E-Mail-Adresse ändern, werden Sie abgemeldet, bis Sie Ihre neue E-Mail-Adresse bestätigen.",
            "email_changed_notice" => "Sie müssen Ihre neue E-Mail-Adresse bestätigen, bevor Sie sich erneut anmelden können.",
            "password_updated" => "Passwort erfolgreich aktualisiert",
            "profile_updated" => "Profil erfolgreich aktualisiert"
        ],
        "welcome_to" => "Willkommen bei :place"
    ]
];
