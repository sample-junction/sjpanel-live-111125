<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "create" => "Créer un rôle",
                "edit" => "Modifier le rôle",
                "management" => "Gestion des rôles",
                "table" => [
                    "number_of_users" => "Nombre d'utilisateurs",
                    "permissions" => "Autorisations",
                    "role" => "Role",
                    "sort" => "Trier",
                    "total" => "rôle total|rôles total"
                ]
            ],
            "users" => [
                "active" => "Utilisateurs actifs",
                "all_permissions" => "Toutes les autorisations",
                "change_password" => "Changer le mot de passe",
                "change_password_for" => "Changer le mot de passe pour :user",
                "create" => "Créer un utilisateur",
                "deactivated" => "Utilisateurs désactivés",
                "deleted" => "Utilisateurs supprimés",
                "edit" => "Modifier l'utilisateur",
                "management" => "Gestion des utilisateurs",
                "no_permissions" => "Aucune autorisation",
                "no_roles" => "Aucun rôle à définir.",
                "permissions" => "Autorisations",
                "total_panelists" => "Total des panélistes",
                "table" => [
                    "confirmed" => "Confirmé",
                    "doi" => "DOI",
                    "country" => "Pays",
                    "created" => "Créé",
                    "e-mail" => "E-mail",
                    "first_name" => "Prénom",
                    "id" => "identifiant",
                    "last_name" => "Nom de famille",
                    "last_updated" => "Dernière mise à jour",
                    "name" => "Nom de famille",
                    "no_deactivated" => "Aucun utilisateur désactivé",
                    "no_deleted" => "Aucun utilisateur supprimé",
                    "other_permissions" => "Autres autorisations",
                    "permissions" => "Autorisations",
                    "roles" => "Rôles",
                    "social" => "Social",
                    "total" => "total des utilisateurs|total des utilisateurs",
                    "uuid" =>"UUID",
                    "panelistid" =>"Identifiant du panéliste",
                    "age" =>"Âge",
                    "gender" =>"Genre",
                    "fraud_count" => "Nombre de fraudes",
                    "project_code" => "Code du projet",
                    "action" => "Action",
                    "reset" => "Réinitialiser",
                    "bulk_search" => "Recherche groupée",
                    "export_profiles" => "Exporter les profils",
                    "bulk_mark" => "Fraude par marque groupée",
                    "search" => "Rechercher",
                    "search_type" => "Type de recherche",
                    "select_type" => "Sélectionner le type de recherche",
                    "user_ids" => "ID utilisateur",
                    "apply" => "Appliquer",
                    "add_fraud" => "Ajouter une fraude",
                    "code_projet" => "Code du projet",
                    "reason" => "Raison",
                    "enter_reason" => "Entrez le motif",
                    "bulk_upload" => "Téléchargement groupé Excel (CSV uniquement)",
                    "sample_excel" => "Télécharger un exemple Excel",
                    "upload_excel" => "Télécharger Excel (uniquement CSV)",
                    "télécharger" => "Télécharger",
                    "fraude" => "Fraude",
                    "export_profile" => "Exporter le profil",
                    "country_code" => "Code pays",
                    "export" => "Exporter",
                    //modified by obhi
                    "locale"=>"Langue",
                    "Latest_update"=>"Dernière mise à jour",
                    "Last_login"=>"Dernière connexion",
                    "last_survey_taken"=>"Dernière enquête réalisée",
                    //modified by obhi
                    "total_no_of_survey_complete"=>"Nombre total d'enquêtes complétées",
                    "last_survey_complete_on"=>"Date de fin de la dernière enquête",
                    "zipcode"=>"Code postal",
                    "city_state"=>"Ville et État",
                    "unsubscribed"=>"Désabonné",
                    "deactivated"=>"Désactivé",
                    "SOI"=>"DONC JE",
                    "DOI"=>"EST CE QUE JE",
                ],
                "tabs" => [
                    "content" => [
                        "overview" => [
                            "avatar" => "Avatar",
                            "confirmed" => "Confirmé",
                            "created_at" => "Créé à",
                            "deleted_at" => "Supprimé à",
                            "email" => "E-mail",
                            "first_name" => "Prénom",
                            "last_login_at" => "Dernière connexion à",
                            "last_login_ip" => "Dernière IP de connexion",
"last_name" => "Nom de famille",
                            "last_updated" => "Dernière mise à jour",
                            "name" => "Nom de famille",
                            "statut" => "Statut",
                            "timezone" => "Fuseau horaire"
                        ]
                    ],
                    "titles" => [
                        "history" => "Histoire",
                        "overview" => "Aperçu"
                    ]
                ],
                "view" => "Afficher l'utilisateur"
            ],
            "reports" => [
                "active" => "Utilisateurs actifs",
                "all_permissions" => "Toutes les autorisations",
                "deleted" => "Utilisateurs supprimés",
                "edit" => "Modifier l'utilisateur",
                "management" => "Gestion des utilisateurs",
                "no_permissions" => "Aucune autorisation",
                "no_roles" => "Aucun rôle à définir.",
                "permissions" => "Autorisations",
                "table" => [
                    "total_earned" => "Total gagné (points du panel SJ)",
                    "total_invite_sent" => "Total des invitations envoyées",
                    "total_click_start" => "Total Clic/Démarrer",
                    "response_rate" => "Taux de réponse (%)",
                    "project_code" => "Code du projet",
                    "status" => "Statut",
                    "uuid" =>"UUID",
                    "panelistid" =>"PanellistId",
                    "age" =>"Âge(En années)",
                    "gender" =>"Genre"
                ],
                "titles" => [
                    "response_rate_title" => "Taux de réponse des panélistes",
                    "active_panelists" => "Panellist actif",
                    "rejection" => "Rejet",
                    "incentive_distribution" => "Distribution incitative",
                    "survey" => "Rapport sur l'état de l'enquête",
                    "panelist_management" => "Maître du panéliste",
                    "monthly_award" => "Données mensuelles sur les récompenses",
                    "survey_details" => "Détails de l'enquête",
                    "new_survey_report" => "Rapport d'enquête"
                ],
            ],
            "setting" => [
                
                "management" => "Gestion des paramètres",
                "table" => [
                    "total_earned" => "Total gagné (points du panel SJ)",
                    "total_invite_sent" => "Total des invitations envoyées",
                    "total_click_start" => "Total Clic/Démarrer",
                    "response_rate" => "Taux de réponse (%)",
                    "project_code" => "Code du projet",
                    "status" => "Statut",
                    "uuid" =>"UUID",
                    "panelistid" =>"PanellistId",
                    "age" =>"Âge(En années)",
                    "gender" =>"Genre"
],
                "titles" => [
                    "active_fraud_title" => "Paramètre de fraude active",
                    "point_system_title" => "Paramètre du système de points"
                ],
            ],
        ],
        "affiliate" => [
            "campaign" => "Campagne",
            "campaign_data" => "Données de campagne",
            "list" => "Liste"
        ]
    ],
    "frontend" => [
        "auth" => [
            "disclaimer_checkbox" => "En cliquant sur cette case à cocher, vous comprenez et acceptez nos",
            "login_box_title" => "Connexion",
            "login_button" => "Connexion",
            "login_with" => "Connectez-vous avec :social_media",
            "signup_with" => "Inscrivez-vous avec :social_media",
            "register_box_title" => "S'inscrire",
            "register_button" => "S'inscrire",
            "checkbox_register" => "J'accepte le",
            "remember_me" => "Se souvenir de moi"
        ],
        "contact" => [
            "box_title" => "Contactez-nous",
            "bouton" => "Envoyer les informations"
        ],
        "passwords" => [
            "expired_password_box_title" => "Votre mot de passe a expiré.",
            "forgot_password" => "Mot de passe oublié ?",
            "reset_password_box_title" => "Réinitialiser le mot de passe",
            "reset_password_button" => "Réinitialiser le mot de passe",
            "send_password_reset_link_button" => "Envoyer le lien de réinitialisation du mot de passe",
            "sub_label" => "Vous pouvez réinitialiser votre mot de passe ici.",
            "update_password_button" => "Mettre à jour le mot de passe"
        ],
        "user" => [
            "passwords" => [
                "change" => "Changer le mot de passe"
            ],
            "profile" => [
                "avatar" => "Avatar",
                "created_at" => "Créé à",
                "edit_information" => "Modifier les informations",
                "e-mail" => "E-mail",
                "first_name" => "Prénom",
                "last_name" => "Nom de famille",
                "last_updated" => "Dernière mise à jour",
                "name" => "Nom de famille",
                "update_information" => "Mettre à jour les informations"
            ]
        ]
    ],
    "general" => [
        "actions" => "Actions",
        "active" => "Actif",
        "all" => "Tous",
        "buttons" => [
            "save" => "Enregistrer",
            "update" => "Mettre à jour"
        ],
        "copyright" => "Droit d'auteur",
        "custom" => "Personnalisé",
        "hide" => "Masquer",
        "inactive" => "Inactif",
        "more" => "Actions",
        "no" => "Non",
        "none" => "Aucun",
        "show" => "Afficher",
        "toggle_navigation" => "Basculer la navigation",
        "yes" => "Oui"
    ]
];
