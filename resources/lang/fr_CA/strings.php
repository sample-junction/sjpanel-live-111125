<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "Êtes-vous sûr de vouloir supprimer cet utilisateur définitivement ? N'importe où dans l'application faisant référence à l'identifiant de cet utilisateur, une erreur est très probable. Procédez à vos propres risques. Cette opération est irréversible.",
                "if_confirmed_off" => "(Si confirmé est désactivé)",
                "no_deactivated" => "Il n'y a aucun utilisateur désactivé.",
                "no_deleted" => "Aucun utilisateur supprimé.",
                "restore_user_confirm" => "Restaurer cet utilisateur à son état d'origine ?"
            ]
        ],
        "dashboard" => [
            "title" => "Tableau de bord",
            "welcome" => "Bienvenue",
            "default_heading" => "Le rapport du tableau de bord s'affiche par défaut pour les derniers jours :dashboard_days"
        ],
        "general" => [
            "all_rights_reserved" => "Tous droits réservés.",
            "are_you_sure" => "Etes-vous sûr de vouloir faire ça ?",
            "boilerplate_link" => "SJPanel",
            "continue" => "Continuer",
            "member_since" => "Membre depuis",
            "minutes" => "minutes",
            "search_placeholder" => "Rechercher...",
            "see_all" => [
                "messages" => "Voir tous les messages",
                "notifications" => "Tout afficher",
                "tasks" => "Afficher toutes les tâches"
            ],
            "status" => [
                "offline" => "Hors ligne",
                "online" => "En ligne"
            ],
            "timeout" => "Vous avez été automatiquement déconnecté pour des raisons de sécurité puisque vous n'aviez aucune activité",
            "you_have" => [
                "messages" => "{0} Vous n'avez pas de messages|{1} Vous avez 1 message|[2,Inf] Vous avez :number messages",
                "notifications" => "{0} Vous n'avez pas de notifications|{1} Vous avez 1 notification|[2,Inf] Vous avez :number notifications",
                "tasks" => "{0} Vous n'avez pas de tâches|{1} Vous avez 1 tâche|[2,Inf] Vous avez :number tâches"
            ]
        ],
        "search" => [
            "empty" => "Veuillez saisir un terme de recherche.",
            "incomplete" => "Vous devez écrire votre propre logique de recherche pour ce système.",
            "results" => "Résultats de recherche pour :query",
            "title" => "Résultats de la recherche"
        ],
        "welcome" => "<p>Ceci est le thème CoreUI de <a href=\"https://coreui.io/\" target=\"_blank\">creativeLabs</a>. Il s'agit d'un thème épuré avec uniquement les styles et les scripts nécessaires pour le faire fonctionner. Téléchargez la version complète pour commencer à ajouter des composants à votre tableau de bord.</p>\n <p>Toutes les fonctionnalités sont à titre indicatif, à l'exception de <strong>Access< /strong> à gauche. Ce modèle est livré avec une bibliothèque de contrôle d'accès entièrement fonctionnelle pour gérer les utilisateurs et les rôles, optimisée par <a href=\"https://github.com/spatie/laravel-permission\" target=\"_blank \">spatie/laravel-permission</a>.</p>\n <p>Gardez à l'esprit qu'il s'agit d'un travail en cours et qu'il peut s'agir de bugs ou d'autres problèmes que je n'ai pas rencontrés. Je ferai de mon mieux. pour les corriger au fur et à mesure que je les reçois.</p>\n <p>J'espère que vous apprécierez tout le travail que j'ai consacré à cela. Veuillez visiter le <a href=\"https://github.com/rappasoft/laravel -5-boilerplate\" target=\"_blank\">GitHub</a> pour plus d'informations et signaler tout <a href=\"https://github.com/rappasoft/Laravel-5-Boilerplate/issues\" target=\"_blank\">problèmes ici</a>.</p>\n <p><strong>Ce projet est très exigeant à suivre étant donné la vitesse à laquelle la branche principale de Laravel change, donc tout l'aide est appréciée.</strong></p>\n <p>- Anthony Rappa</p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Votre compte a été confirmé.",
            "click_to_confirm" => "Cliquez ici pour confirmer votre compte :",
            "confirmation" => [
                "copyright" => "Droit d'auteur",
                "copyrightcompany" => "RS Sample Junction LLP",
                // "link_content1" => "Vous recevez cet e-mail parce que vous êtes un membre enregistré du SJ Panel où nous vous récompensons par des incitations pour votre participation à des enquêtes en ligne. Si vous ne souhaitez plus recevoir d'e-mails de SJ Panel, veuillez Désabonnez-vous pour désactiver votre compte. Dès que vous vous désabonnez de SJ Panel, votre compte sera supprimé dans les 72 heures et vous ne recevrez plus d'e-mails de SJ Panel. Si vous avez besoin d'une assistance technique, veuillez écrire à notre équipe à " ,
                // "mail_content" => "Pour recevoir nos emails dans votre boîte de réception et éviter les spams, veuillez ajouter",
               // "link_content" => "à votre liste d'expéditeurs approuvés.",
                "link" => "donotreply@sjpanel.com",
                "link1" => "support@sjpanel.com",
                "all_right" => 'Tous droits réservés.',
                "com_details_1" => "Votre compte SJ Panel est maintenant actif ! Confirmez votre compte en cliquant sur le bouton ci-dessous pour accéder pleinement aux fonctionnalités de SJ Panel et gagner ",
                // "com_details_1" => "Your SJ Panel account is still not active. Confirm your account by clicking the button below to gain full access to SJ Panel's features and earn ",
                "tmp_1_details_sub1" => "Merci d'avoir rejoint SJ Panel. ",
                "tmp_1_details_sub2" => "Nos données montrent que vous n'avez pas encore confirmé votre inscription. Veuillez confirmer votre inscription en confirmant votre identifiant de messagerie.",
                "tmp_1_details_2" => "De plus, nous offrons une récompense de <b>Bienvenue</b> pouvant aller jusqu'à ",
                "tmp_1_details_3" => "Après avoir confirmé votre identifiant de messagerie, connectez-vous simplement avec les détails de votre compte SJ Panel et effectuez les tâches suivantes : ",
                "tmp_1_details_4" => "1.	Complétez vos enquêtes de profilage et gagnez CAD 3",
                "tmp_1_details_5" => "2.	Répondez à au moins 1 sondage en direct et gagnez CAD 2",
                "tmp_1_details_6" => "Si vous accomplissez les deux tâches, vous aurez droit à <b>CAD 5 supplémentaires</b> en plus de vos points d'enquête habituels.",
                "tmp_1_confirm_button" => "Confirmez votre identifiant de messagerie",
                "tmp_1_details_7" => '<i>Remarque : veuillez visiter la page “Enquêtes” pour des enquêtes plus intéressantes et la chance de gagner un maximum de récompenses. Pour une meilleure expérience d’enquête, assurez-vous d’avoir mis à jour tout votre profil détaillé. </i>',
                "tmp_2_details_sub2" => "Nos données montrent que vous n'avez pas répondu à vos enquêtes de profilage. Nous vous envoyons des sondages selon votre profil. Il est très important que vous remplissiez tous les détails en conséquence pour une meilleure expérience d’enquête et des récompenses maximales. ",
                "tmp_2_details_3" => "Connectez-vous simplement avec les détails de votre compte SJ Panel et effectuez les tâches suivantes :",
                "tmp_2_details_4" => "1.	Complétez vos enquêtes de profilage et gagnez CAD 3 supplémentaires",
                "tmp_2_details_5" => "2.	Répondez à au moins 2 sondages en direct et gagnez CAD 2 supplémentaires",
                "tmp_2_confirm_button" => "Connecte-toi maintenant",
                "tmp_2_details_7" => '<i>Remarque : veuillez visiter la page “Enquêtes” pour des enquêtes plus intéressantes et la chance de gagner un maximum de récompenses. Pour une meilleure expérience d’enquête, assurez-vous d’avoir mis à jour tout votre profil détaillé. </i>',
                "tmp_3_details_sub2" => "Nos données montrent que vous avez répondu à toutes vos enquêtes de profilage, mais que vous n’en avez toujours pas répondu une seule jusqu’à présent.",
                "tmp_3_details_2" => "En tant que panélistes appréciés, nous offrons une récompense de <b>Bienvenue</b> pouvant aller jusqu'à ",
                "tmp_3_details_4" => "1.	Répondez à au moins 2 sondages en direct et gagnez CAD 3",
                "tmp_3_details_5" => "2.	Parrainez au moins 5 personnes et gagnez CAD 2",
                "tmp_3_details_7" => '<i>Remarque : veuillez visiter la page “Enquêtes” pour des enquêtes plus intéressantes et la chance de gagner un maximum de récompenses. Pour une récompense supplémentaire et maximale, assurez-vous que vos filleuls rejoignent notre panel et répondent à un sondage.</i>',
                "contact_detail" => "Si vous n'avez envoyé aucune demande merci d'envoyer un mail à",
                "com_details_2" => " Points :",
                //"details_2" => "Si le lien ne fonctionne pas, copiez-le et collez-le dans votre navigateur et appuyez sur Entrée. S'il ne fonctionne toujours pas, veuillez écrire à support@sjpanel.com",
                "details_2" =>"Confirmez simplement votre email pour commencer !",
                "details_3"=>"“Tout le monde n'a pas besoin de travailler dans les services de défense ou dans des ONG pour servir son pays.
                            Vous pouvez le faire en donnant simplement une opinion HONNÊTE et IMJUSTÉE sur des enquêtes pour permettre aux entreprises de créer de meilleurs produits et services pour le monde.”",
                "delete_details_1"=> "Nous avons reçu une demande de désactivation de votre compte. Toutes vos données avec nous seront supprimées.",
                "userinfo_delete_details_1" => "Nous avons reçu une demande de votre part visant à supprimer vos informations personnelles stockées chez nous. Si vous avez réellement demandé la suppression de vos informations personnelles, veuillez cliquer sur le bouton ci-dessous comme confirmation finale, sinon veuillez le signaler à notre équipe d'assistance. à support@sjpanel.com.",
                "userinfo_delete_details_3" => "Nous avons récemment reçu une demande de votre part visant à supprimer vos informations personnelles stockées chez nous. Garantir la sécurité et la confidentialité de vos données est de la plus haute importance pour nous, et nous nous engageons à répondre à votre demande dans les plus brefs délais. ",
                "userinfo_delete_details_4" => "Pour finaliser la suppression de vos informations personnelles, veuillez cliquer sur le",
                 "dele" => "Supprimer",
                 "userinfo_delete_details_6"=> "bouton ci-dessous :",
                "userinfo_delete_details_5" => "Si vous n'avez pas fait cette demande ou si vous avez des inquiétudes concernant cette action, n'hésitez pas à le signaler à notre équipe d'assistance dédiée à",
                "userinfo_delete_details_7" => "Nous sommes là pour vous aider et répondre à toutes vos questions ou problèmes.",
                "delete_details_2" => "Si vous avez réellement demandé la désactivation de votre compte, veuillez cliquer sur le bouton ci-dessous comme confirmation finale, sinon veuillez en informer notre équipe d'assistance à support@sjpanel.com.",
                "delete_details_3" => "Nous espérons que ce message vous trouvera bien. Nous souhaitions vous informer que nous avons reçu une demande de désactivation de votre compte SJ Panel.",
                "delete_details_4" => "Si vous avez effectivement demandé la désactivation de votre compte, veuillez cliquer sur le bouton ci-dessous pour fournir votre confirmation définitive :",
                "delete_details_5" => "Si cette demande de désactivation n'a pas été initiée par vous, ou si vous avez des inquiétudes, n'hésitez pas à la signaler à notre équipe d'assistance dédiée à support@sjpanel.com. Nous sommes là pour vous aider et garantir la sécurité de votre compte.",
                "userinfo_delete_details_2" => "Si vous n'avez pas demandé la suppression de vos informations personnelles, cliquez ici.",
                "confirm_button" => "Confirmer",
                "faq" => "FAQ's",
                "greetings" => "Bonjour",
                "dear" => "Cher",
"heading" => "Vous êtes prêt à partir !",
                "how_it_works" => "Comment ça marche",
                "rewards" => "Démarrer l'enquête",
                "safeguards" => "Sauvegardes",
                "cookie" => "Politique en matière de cookies",
                "unsubscribe" => "Désabonnement",
                "footer" => "Bonne enquête !",
                "footer_1" => "Pour recevoir nos emails dans votre boîte de réception et éviter les spams, veuillez ajouter ",
                "contact"=>"Contact",
                "deactivate_content_1" => "Nous espérons que ce message vous trouvera bien. Nous souhaitions vous informer que nous avons reçu une demande de désactivation de votre compte SJ Panel.",
                "deactivate_content_2" => "Si vous avez effectivement demandé la désactivation de votre compte, veuillez cliquer sur le bouton ci-dessous pour fournir votre confirmation définitive :",
                "deactivate_content_3" => "Si cette demande de désactivation n'a pas été initiée par vous, ou si vous avez des inquiétudes, n'hésitez pas à la signaler à notre équipe d'assistance dédiée à ",
                "deactivate_content_4" => "Nous sommes là pour vous aider et assurer la sécurité de votre compte.",
                "person_delete" => "Nous vous écrivons pour vous informer que votre demande de suppression de vos informations personnelles, qui ont été stockées chez nous, a été traitée avec succès. Conformément à votre demande, nous avons définitivement supprimé toutes vos données personnelles de nos dossiers et votre compte a également été supprimé.",
                "person_delete1" => "Si vous décidez de rejoindre SJ Panel à l'avenir, nous vous demandons de bien vouloir créer un nouvel identifiant et nous serons ravis de vous accueillir à nouveau en tant que membre.",
                "person_delete2" => "Si vous avez des questions ou avez besoin d'aide supplémentaire, n'hésitez pas à nous contacter à ",
                "person_delete3" =>" Nous sommes là pour vous aider.",
                "com_details_3" => "Nous avons remarqué que vous avez rejoint SJ Panel mais que vous n'avez toujours pas terminé le processus d'inscription. Veuillez terminer le processus d'enregistrement de votre compte SJ Panel en cliquant simplement sur le bouton ci-dessous. afin que vous puissiez commencer à répondre à des sondages et gagner un maximum de récompenses.",
                "com_details_3a" => "Ce faisant, vous débloquerez l'accès à un monde d'enquêtes passionnantes où votre opinion compte vraiment, et vous gagnerez un fantastique CAD 1.89 (1400 points) rien qu'en commençant ! ",

            ],
           "error"=> "Oups !",
              "greeting" => "Bonjour !",
            "password_cause_of_email" => "Vous recevez cet e-mail car nous avons reçu une demande de réinitialisation du mot de passe de votre compte.",
            "password_cause_of_email_new" => "Nous avons reçu une demande de votre part pour réinitialiser votre mot de passe. Pour continuer, cliquez ici.",
            "password_cause_of_email_new1" => "Nous avons reçu une demande de réinitialisation de mot de passe de votre part. Pour continuer, veuillez cliquer sur le lien ci-dessous :",
            "password_cause_of_email_new2" => "Si vous n'avez pas initié cette demande, veuillez contacter notre équipe d'assistance à",
             "password_cause_of_email_new4"=> "immédiatement.",
            "password_cause_of_email_new3" => "Merci d'avoir choisi SJ Panel !",
            "password_if_not_requested" => "Si vous n'avez pas demandé de réinitialisation de mot de passe, veuillez le signaler à help@sjpanel.com",
            "password_if_not_requested_new" => "Si vous n'avez envoyé aucune demande, veuillez envoyer un mail à",
            "password_reset_subjects" => "Demande de réinitialisation du mot de passe",
            "regards" => "Cordialements",
            "reset_password" => "Cliquez ici pour réinitialiser votre mot de passe",
            "thank_you_for_using_app" => "Merci d'utiliser notre application !",
            "trouble_clicking_button" => "Si vous rencontrez des difficultés pour cliquer sur le bouton \":action_text\", copiez et collez l'URL ci-dessous dans votre navigateur Web :"
        ],
        "contact" => [
            "email_body_title" => "Vous avez une nouvelle demande de formulaire de contact : Ci-dessous les détails :",
            "subject" => "Une nouvelle soumission du formulaire de contact :app_name !"
        ],
        "fraud_mail" => [
            "greeting" => "Cher",
            "greeting_title" => "Salutations du panneau SJ !",
            "body_details" => "Notre client a trouvé vos réponses au sondage numéro :survey_number inacceptables et suspectes.",
"body_details_1" => "Nous vous demandons de parcourir notre",
            "body_details_2" => "clause numéro 4 & 5 afin de connaître les conséquences d'être marqué comme fraude dans notre panel.",
            "body_details_3" =>"Si vous avez des questions ou des préoccupations à ce sujet, n'hésitez pas à nous contacter par e-mail à support@samplejunction.com.",
            "list_details" => "Tentative d'enquête qui n'est actuellement pas disponible",
            "list_details_1" => "Tentative de sondage à partir d'un e-mail non enregistré",
            "list_details_2" => "Tentative de l'enquête depuis un pays ne correspondant pas à votre profil",
            "list_details_3" => "Tentative d'enquête à partir d'un lien d'enquête invalide",
            "list_details_4" => "Tentative d'enquête plusieurs fois",
            "list_details_5" => "Essayer ou participer à une enquête par des moyens déloyaux",
            "subject" => "Une nouvelle soumission du formulaire de contact :app_name !",
            "subject_fraud"=>'Activité frauduleuse observée avec votre compte',
            "subject_backlist"=>'Attention : Votre compte a été définitivement suspendu.',
            "subject_welcome"=>'Bienvenue sur le SJ Panel!',
            
        ],
        "blacklist_mail" => [
            "body_details" => "Malheureusement, nous devons suspendre définitivement votre compte chez nous car vos réponses ont été marquées comme frauduleuses :fraudulent_count times.",
            "body_details_1" => "Votre compte a été impliqué dans des activités contraires aux normes de qualité de notre panel. Par conséquent, vous ne pourrez ni participer à aucune enquête ni réclamer une quelconque incitation. Toutes vos incitations seront perdues. selon notre",
            "body_details_2" => "et vous ne pourrez pas le réclamer.",
            "body_details_3" =>"Si vous avez des questions ou des préoccupations à ce sujet, n'hésitez pas à nous contacter à support@samplejunction.com.",
        ]
    ],
    "frontend" => [
        "disclaimer" => "Vous recevez cet e-mail parce que vous êtes un membre enregistré du SJ Panel où nous vous récompensons par des incitations pour votre participation à des enquêtes en ligne. Si vous ne souhaitez plus recevoir d'e-mails de la part de SJ Panel, veuillez vous désabonner de désactivez votre compte. Dès que vous vous désabonnez de SJ Panel, votre compte sera supprimé dans les 72 heures et vous ne recevrez plus d'e-mails de SJ Panel. Si vous avez besoin d'une assistance technique, veuillez écrire à notre équipe à",
        "disclaimer_1" => "Équipe SJ Panel",
        "general" => [
            "joined" => "Rejoint"
        ],
        "test" => "Tester",
        "tests" => [
            "based_on" => [
                "permission" => "Basé sur une autorisation -",
                "role" => "Basé sur un rôle -"
            ],
            "js_injected_from_controller" => "Javascript injecté depuis un contrôleur",
            "using_access_helper" => [
                "array_permissions" => "Utilisation d'Access Helper avec un tableau de noms d'autorisations ou d'ID où l'utilisateur doit tous les posséder.",
                "array_permissions_not" => "Utilisation d'Access Helper avec un tableau de noms ou d'ID d'autorisation où l'utilisateur n'est pas obligé de tous les posséder.",
                "array_roles" => "Utilisation d'Access Helper avec un tableau de noms de rôles ou d'ID où l'utilisateur doit tous les posséder.",
                "array_roles_not" => "Utilisation d'Access Helper avec un tableau de noms de rôles ou d'ID où l'utilisateur n'est pas obligé de tous les posséder.",
                "permission_id" => "Utilisation d'Access Helper avec l'ID d'autorisation",
                "permission_name" => "Utilisation d'Access Helper avec le nom d'autorisation",
                "role_id" => "Utilisation d'Access Helper avec l'ID de rôle",
                "role_name" => "Utilisation d'Access Helper avec le nom de rôle"
            ],
"using_blade_extensions" => "Utilisation des extensions de lame",
            "view_console_it_works" => "Afficher la console, vous devriez voir 'ça marche !' qui vient de FrontendController@index",
            "you_can_see_because" => "Vous pouvez voir ceci parce que vous avez le rôle de ':role'!",
            "you_can_see_because_permission" => "Vous pouvez voir ceci car vous avez la permission de ':permission'!"
        ],
        "user" => [
            "change_email_notice" => "Si vous modifiez votre adresse e-mail, vous serez déconnecté jusqu'à ce que vous confirmiez votre nouvelle adresse e-mail.",
            "email_changed_notice" => "Vous devez confirmer votre nouvelle adresse e-mail avant de pouvoir vous reconnecter.",
            "password_updated" => "Mot de passe mis à jour avec succès.",
            "profile_updated" => "Profil mis à jour avec succès.",
            "password_updated_message" => "Mot de passe modifié avec succès, veuillez vous connecter avec votre mot de passe mis à jour.",
        ],
        "welcome_to" => "Bienvenue sur :place"
    ]
];
