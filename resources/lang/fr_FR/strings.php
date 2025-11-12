<<<<<<< HEAD
<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "Êtes-vous sûr de vouloir supprimer cet utilisateur de manière permanente? Toute erreur dans l'application faisant référence à l'ID de cet utilisateur Procédez à vos risques et périls. Ça ne peut pas être annulé.",
                "if_confirmed_off" => "(Si confirmé est éteint)",
                "no_deactivated" => "Il n'y a pas d'utilisateurs désactivés.",
                "no_deleted" => "Il n'y a pas d'utilisateurs supprimés.",
                "restore_user_confirm" => "Restaurer cet utilisateur à son état d'origine?"
            ]
        ],
        "dashboard" => [
            "title" => "Tableau de bord",
            "welcome" => "Bienvenue"
        ],
        "general" => [
            "all_rights_reserved" => "Tous les droits sont réservés.",
            "are_you_sure" => "Es-tu sûr de vouloir faire ça?",
            "boilerplate_link" => "Plaque de cuisson Laravel 5",
            "continue" => "Continuer",
            "member_since" => "Membre depuis",
            "minutes" => "minutes",
            "search_placeholder" => "Chercher...",
            "see_all" => [
                "messages" => "Voir tous les messages",
                "notifications" => "Voir tout",
                "tasks" => "Voir toutes les tâches"
            ],
            "status" => [
                "offline" => "Hors ligne",
                "online" => "En ligne"
            ],
            "timeout" => "Vous avez été automatiquement déconnecté pour des raisons de sécurité, car vous n’avez exercé aucune activité dans",
            "you_have" => [
                "messages" => "{0} Non hai messaggi | {1} Hai 1 messaggio | [2, Inf] Hai :number di messaggi",
                "notifications" => "{0} Vous n'avez pas de notifications | {1} Vous avez 1 notification | [2, Inf] Vous avez :number notifications de numéro",
                "tasks" => "{0} Vous n'avez pas de tâches | {1} vous avez 1 tâche | [2, Inf] Vous avez :number de tâches"
            ]
        ],
        "search" => [
            "empty" => "Veuillez saisir un terme de recherche.",
            "incomplete" => "Vous devez écrire votre propre logique de recherche pour ce système.",
            "results" => "Résultats de recherche pour :query",
            "title" => "Résultats de la recherche"
        ],
        "welcome" => "<p> C’est le thème CoreUI créé par <a href=\"https://coreui.io/\"============================================================================================================= Téléchargez la version complète pour commencer à ajouter des composants à votre tableau de bord. </ p>\n <p> Toutes les fonctionnalités sont destinées à l'affichage, à l'exception de <strong> Accès </ strong> à gauche. Cette plate-forme est livrée avec une bibliothèque de contrôle d’accès entièrement fonctionnelle pour gérer les utilisateurs et les rôles grâce au <a href=\"https://github.com/spatie/laravel-permission\" target=\"blank\"> spatie / laravel- permission </a>. </ p>\n <p> N'oubliez pas qu'il s'agit d'un travail en cours et qu'il peut s'agir de bugs ou d'autres problèmes que je n'ai pas rencontrés. Je ferai de mon mieux pour les réparer au fur et à mesure que je les recevrai. </ P>\n <p> J'espère que vous apprécierez tout le travail que j'ai mis dans ce domaine. Veuillez visiter la <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"blank\"> page GitHub </a> page pour plus d'informations et signaler tout <a href =. \" https://github.com/rappasoft/Laravel-5-Boilerplate/issues \" target = \" _ blank \"> est ici </a>. </ p>\n <p> <strong> Ce projet est très difficile à suivre compte tenu du rythme auquel la branche principale de Laravel change, toute aide est donc appréciée. </ strong> </ p>\n <p> - Anthony Rappa </ p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Votre compte a été confirmé.",
            "click_to_confirm" => "Cliquez ici pour confirmer votre compte:",
            "confirmation" => [
                "copyright" => "droits d'auteur",
                "details_1" => "Nous avons terminé la configuration de votre compte SJ Panel.",
                "details_2" => "Il suffit de confirmer votre email pour commencer!",
                "faq" => "FAQ's",
                "greeting" => "Hey",
                "heading" => "Vous êtes prêt à partir!",
                "how_it_works" => "Comment ça marche",
                "rewards" => "Récompenses",
                "unsubscribe" => "Se désabonner"
            ],
            "error" => "Oups!",
            "greeting" => "salut!",
            "password_cause_of_email" => "Vous recevez cet email car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.",
            "password_if_not_requested" => "Si vous n'avez pas demandé de réinitialisation de mot de passe, veuillez le signaler à help@sjpanel.com",
            "password_reset_subject" => "réinitialiser le mot de passe",
            "regards" => "Cordialement,",
            "reset_password" => "Cliquez ici pour réinitialiser votre mot de passe",
            "thank_you_for_using_app" => "Merci d'utiliser notre application!",
            "trouble_clicking_button" => "Si vous ne parvenez pas à cliquer sur le bouton \":action_text\", copiez et collez l’URL ci-dessous dans votre navigateur Web:"
        ],
        "contact" => [
            "email_body_title" => "Vous avez une nouvelle demande de formulaire de contact: Voici les détails:",
            "subject" => "Une nouvelle soumission de formulaire de contact :app_name!"
        ]
    ],
    "frontend" => [
        "disclaimer" => "Vous avez reçu ce courrier parce que vous êtes enregistré avec nous en tant que membre du Panel et avez accepté de recevoir un courrier électronique pour recevoir des sondages et gagner des récompenses. Vous pouvez toujours vous désinscrire de notre liste de diffusion en cliquant sur",
        "general" => [
            "joined" => "Rejoint"
        ],
        "test" => "Tester",
        "tests" => [
            "based_on" => [
                "permission" => "Basé sur les autorisations -",
                "role" => "Basé sur les rôles -"
            ],
            "js_injected_from_controller" => "Javascript injecté depuis un contrôleur",
            "using_access_helper" => [
                "array_permissions" => "Utilisation d'Access Helper avec un tableau de noms de permission ou d'identifiants où l'utilisateur doit tout posséder.",
                "array_permissions_not" => "Utilisation d'Access Helper avec un tableau de noms de permission ou d'identifiants pour lesquels l'utilisateur ne doit pas nécessairement tout posséder.",
                "array_roles" => "Utiliser Access Helper avec un tableau de noms de rôles ou d’ID où l’utilisateur doit tout posséder.",
                "array_roles_not" => "Utiliser Access Helper avec un tableau de noms de rôles ou d’ID où l’utilisateur n’est pas obligé de tout posséder.",
                "permission_id" => "Utilisation de Access Helper avec un identifiant de permission",
                "permission_name" => "Utiliser Access Helper avec le nom de permission",
                "role_id" => "Utilisation d'Access Helper avec l'ID de rôle",
                "role_name" => "Utilisation d'Access Helper avec un nom de rôle"
            ],
            "using_blade_extensions" => "Utilisation des extensions de lame",
            "view_console_it_works" => "Voir la console, vous devriez voir 'ça marche!' qui vient de FrontendController @ index",
            "you_can_see_because" => "Vous pouvez voir cela parce que vous avez le rôle de ':rôle'!",
            "you_can_see_because_permission" => "Vous pouvez voir cela parce que vous avez la permission de ':permission'!"
        ],
        "user" => [
            "change_email_notice" => "Si vous modifiez votre adresse électronique, vous serez déconnecté jusqu'à ce que vous confirmiez votre nouvelle adresse électronique.",
            "email_changed_notice" => "Vous devez confirmer votre nouvelle adresse e-mail avant de pouvoir vous reconnecter.",
            "password_updated" => "Mot de passe mis à jour avec succès.",
            "profile_updated" => "Profil mis à jour avec succès."
        ],
        "welcome_to" => "Bienvenue sur :place"
    ]
];
=======
<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "Êtes-vous sûr de vouloir supprimer cet utilisateur de manière permanente? Toute erreur dans l'application faisant référence à l'ID de cet utilisateur Procédez à vos risques et périls. Ça ne peut pas être annulé.",
                "if_confirmed_off" => "(Si confirmé est éteint)",
                "no_deactivated" => "Il n'y a pas d'utilisateurs désactivés.",
                "no_deleted" => "Il n'y a pas d'utilisateurs supprimés.",
                "restore_user_confirm" => "Restaurer cet utilisateur à son état d'origine?"
            ]
        ],
        "dashboard" => [
            "title" => "Tableau de bord",
            "welcome" => "Bienvenue"
        ],
        "general" => [
            "all_rights_reserved" => "Tous les droits sont réservés.",
            "are_you_sure" => "Es-tu sûr de vouloir faire ça?",
            "boilerplate_link" => "Plaque de cuisson Laravel 5",
            "continue" => "Continuer",
            "member_since" => "Membre depuis",
            "minutes" => "minutes",
            "search_placeholder" => "Chercher...",
            "see_all" => [
                "messages" => "Voir tous les messages",
                "notifications" => "Voir tout",
                "tasks" => "Voir toutes les tâches"
            ],
            "status" => [
                "offline" => "Hors ligne",
                "online" => "En ligne"
            ],
            "timeout" => "Vous avez été automatiquement déconnecté pour des raisons de sécurité, car vous n’avez exercé aucune activité dans",
            "you_have" => [
                "messages" => "{0} Non hai messaggi | {1} Hai 1 messaggio | [2, Inf] Hai :number di messaggi",
                "notifications" => "{0} Vous n'avez pas de notifications | {1} Vous avez 1 notification | [2, Inf] Vous avez :number notifications de numéro",
                "tasks" => "{0} Vous n'avez pas de tâches | {1} vous avez 1 tâche | [2, Inf] Vous avez :number de tâches"
            ]
        ],
        "search" => [
            "empty" => "Veuillez saisir un terme de recherche.",
            "incomplete" => "Vous devez écrire votre propre logique de recherche pour ce système.",
            "results" => "Résultats de recherche pour :query",
            "title" => "Résultats de la recherche"
        ],
        "welcome" => "<p> C’est le thème CoreUI créé par <a href=\"https://coreui.io/\"============================================================================================================= Téléchargez la version complète pour commencer à ajouter des composants à votre tableau de bord. </ p>\n <p> Toutes les fonctionnalités sont destinées à l'affichage, à l'exception de <strong> Accès </ strong> à gauche. Cette plate-forme est livrée avec une bibliothèque de contrôle d’accès entièrement fonctionnelle pour gérer les utilisateurs et les rôles grâce au <a href=\"https://github.com/spatie/laravel-permission\" target=\"blank\"> spatie / laravel- permission </a>. </ p>\n <p> N'oubliez pas qu'il s'agit d'un travail en cours et qu'il peut s'agir de bugs ou d'autres problèmes que je n'ai pas rencontrés. Je ferai de mon mieux pour les réparer au fur et à mesure que je les recevrai. </ P>\n <p> J'espère que vous apprécierez tout le travail que j'ai mis dans ce domaine. Veuillez visiter la <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"blank\"> page GitHub </a> page pour plus d'informations et signaler tout <a href =. \" https://github.com/rappasoft/Laravel-5-Boilerplate/issues \" target = \" _ blank \"> est ici </a>. </ p>\n <p> <strong> Ce projet est très difficile à suivre compte tenu du rythme auquel la branche principale de Laravel change, toute aide est donc appréciée. </ strong> </ p>\n <p> - Anthony Rappa </ p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Votre compte a été confirmé.",
            "click_to_confirm" => "Cliquez ici pour confirmer votre compte:",
            "confirmation" => [
                "copyright" => "droits d'auteur",
                "details_1" => "Nous avons terminé la configuration de votre compte SJ Panel.",
                "details_2" => "Il suffit de confirmer votre email pour commencer!",
                "faq" => "FAQ's",
                "greeting" => "Hey",
                "heading" => "Vous êtes prêt à partir!",
                "how_it_works" => "Comment ça marche",
                "rewards" => "Récompenses",
                "unsubscribe" => "Se désabonner"
            ],
            "error" => "Oups!",
            "greeting" => "salut!",
            "password_cause_of_email" => "Vous recevez cet email car nous avons reçu une demande de réinitialisation du mot de passe pour votre compte.",
            "password_if_not_requested" => "Si vous n'avez pas demandé de réinitialisation de mot de passe, veuillez le signaler à help@sjpanel.com",
            "password_reset_subject" => "réinitialiser le mot de passe",
            "regards" => "Cordialement,",
            "reset_password" => "Cliquez ici pour réinitialiser votre mot de passe",
            "thank_you_for_using_app" => "Merci d'utiliser notre application!",
            "trouble_clicking_button" => "Si vous ne parvenez pas à cliquer sur le bouton \":action_text\", copiez et collez l’URL ci-dessous dans votre navigateur Web:"
        ],
        "contact" => [
            "email_body_title" => "Vous avez une nouvelle demande de formulaire de contact: Voici les détails:",
            "subject" => "Une nouvelle soumission de formulaire de contact :app_name!"
        ]
    ],
    "frontend" => [
        "disclaimer" => "Vous avez reçu ce courrier parce que vous êtes enregistré avec nous en tant que membre du Panel et avez accepté de recevoir un courrier électronique pour recevoir des sondages et gagner des récompenses. Vous pouvez toujours vous désinscrire de notre liste de diffusion en cliquant sur",
        "general" => [
            "joined" => "Rejoint"
        ],
        "test" => "Tester",
        "tests" => [
            "based_on" => [
                "permission" => "Basé sur les autorisations -",
                "role" => "Basé sur les rôles -"
            ],
            "js_injected_from_controller" => "Javascript injecté depuis un contrôleur",
            "using_access_helper" => [
                "array_permissions" => "Utilisation d'Access Helper avec un tableau de noms de permission ou d'identifiants où l'utilisateur doit tout posséder.",
                "array_permissions_not" => "Utilisation d'Access Helper avec un tableau de noms de permission ou d'identifiants pour lesquels l'utilisateur ne doit pas nécessairement tout posséder.",
                "array_roles" => "Utiliser Access Helper avec un tableau de noms de rôles ou d’ID où l’utilisateur doit tout posséder.",
                "array_roles_not" => "Utiliser Access Helper avec un tableau de noms de rôles ou d’ID où l’utilisateur n’est pas obligé de tout posséder.",
                "permission_id" => "Utilisation de Access Helper avec un identifiant de permission",
                "permission_name" => "Utiliser Access Helper avec le nom de permission",
                "role_id" => "Utilisation d'Access Helper avec l'ID de rôle",
                "role_name" => "Utilisation d'Access Helper avec un nom de rôle"
            ],
            "using_blade_extensions" => "Utilisation des extensions de lame",
            "view_console_it_works" => "Voir la console, vous devriez voir 'ça marche!' qui vient de FrontendController @ index",
            "you_can_see_because" => "Vous pouvez voir cela parce que vous avez le rôle de ':rôle'!",
            "you_can_see_because_permission" => "Vous pouvez voir cela parce que vous avez la permission de ':permission'!"
        ],
        "user" => [
            "change_email_notice" => "Si vous modifiez votre adresse électronique, vous serez déconnecté jusqu'à ce que vous confirmiez votre nouvelle adresse électronique.",
            "email_changed_notice" => "Vous devez confirmer votre nouvelle adresse e-mail avant de pouvoir vous reconnecter.",
            "password_updated" => "Mot de passe mis à jour avec succès.",
            "profile_updated" => "Profil mis à jour avec succès."
        ],
        "welcome_to" => "Bienvenue sur :place"
    ]
];
>>>>>>> dev
