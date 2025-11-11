<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "already_exists" => "Ce rôle existe déjà. Veuillez choisir un autre nom.",
                "cant_delete_admin" => "Vous ne pouvez pas supprimer le rôle Administrateur.",
                "create_error" => "Un problème est survenu lors de la création de ce rôle. Veuillez réessayer.",
                "delete_error" => "Un problème est survenu lors de la suppression de ce rôle. Veuillez réessayer.",
                "has_users" => "Vous ne pouvez pas supprimer un rôle avec des utilisateurs associés.",
                "needs_permission" => "Vous devez sélectionner au moins une autorisation pour ce rôle.",
                "not_found" => "Ce rôle n'existe pas.",
                "update_error" => "Un problème est survenu lors de la mise à jour de ce rôle. Veuillez réessayer."
            ],

            "users" => [
                "already_confirmed" => "Cet utilisateur est déjà confirmé.",
                "cant_confirm" => "Un problème est survenu lors de la confirmation du compte utilisateur.",
                "cant_deactivate_self" => "Vous ne pouvez pas vous faire ça.",
                "cant_delete_admin" => "Vous ne pouvez pas supprimer le super administrateur.",
                "cant_delete_own_session" => "Vous ne pouvez pas supprimer votre propre session.",
                "cant_delete_self" => "Vous ne pouvez pas vous supprimer.",
                "cant_restore" => "Cet utilisateur n'est pas supprimé et ne peut donc pas être restauré.",
                "cant_unconfirm_admin" => "Vous ne pouvez pas annuler la confirmation du super administrateur.",
                "cant_unconfirm_self" => "Vous ne pouvez pas vous dé-confirmer.",
                "create_error" => "Un problème est survenu lors de la création de cet utilisateur. Veuillez réessayer.",
                "delete_error" => "Un problème est survenu lors de la suppression de cet utilisateur. Veuillez réessayer.",
                "delete_first" => "Cet utilisateur doit d'abord être supprimé avant de pouvoir être détruit définitivement.",
                "email_error" => "Cette adresse email appartient à un autre utilisateur.",
                "mark_error" => "Un problème est survenu lors de la mise à jour de cet utilisateur. Veuillez réessayer.",
                "not_confirmed" => "Cet utilisateur n'est pas confirmé.",
                "not_found" => "Cet utilisateur n'existe pas.",
                "restore_error" => "Un problème est survenu lors de la restauration de cet utilisateur. Veuillez réessayer.",
                "role_needed" => "Vous devez choisir au moins un rôle.",
                "role_needed_create" => "Vous devez choisir au moins un rôle.",
                "session_wrong_driver" => "Votre pilote de session doit être défini sur la base de données pour utiliser cette fonctionnalité.",
                "social_delete_error" => "Un problème est survenu lors de la suppression du compte social de l'utilisateur.",
                "update_error" => "Un problème est survenu lors de la mise à jour de cet utilisateur. Veuillez réessayer.",
                "update_password_error" => "Un problème est survenu lors de la modification du mot de passe de cet utilisateur. Veuillez réessayer."
            ],
        ]
    ],

    "frontend" => [
        "auth" => [
            "confirmation" => [
                "already_confirmed" => "Votre compte est déjà confirmé.",
                //"confirm" => "Confirmez votre compte !",
                "confirm" => "Confirmez votre compte !",
                "confirm_doi_sub1"=>" Possibilité de gagner CAD 1.89 - Complétez votre inscription ",
				
                "confirm1" => "Terminez l'enregistrement de votre compte et gagnez",
                "confirm2" => "Points",
                "deleteconfirm" => "Confirmation requise : demande de désactivation de votre compte SJ Panel",
                "userinfodeleteconfirm" => "Confirmation requise : suppression de vos informations personnelles",
                "deletewelcome" => "Confirmation de la désactivation du compte SJ Panel",
                "userinfodeletewelcome" =>"Confirmation de la suppression des informations personnelles",
                "created_confirm" => "Votre compte a été créé avec succès. Nous vous avons envoyé un e-mail pour confirmer votre compte.",
                "created_ending" => "Votre compte a été créé avec succès et est en attente d'approbation. Un e-mail vous sera envoyé lorsque votre compte sera approuvé.",
                "mismatch" => "Votre code de confirmation ne correspond pas.",
                "not_found" => "Ce code de confirmation n'existe pas.",
                //"pending" => "Votre compte est actuellement en attente d'approbation.",
                "pending" => "Votre compte toujours en cours. Veuillez cliquer sur le lien envoyé dans votre e-mail enregistré pour finaliser votre inscription.",
                "resend" => "Votre compte n'est pas confirmé. Veuillez cliquer sur le lien de confirmation dans votre e-mail, ou <a href=\":url\">cliquez ici</a> pour renvoyer l'e-mail de confirmation." ,
                "resent" => "Un nouvel e-mail de confirmation a été envoyé à l'adresse enregistrée.",
                "success" => "Votre compte a été confirmé avec succès !"
            ],
            "deactivated" => "Votre compte a été désactivé, veuillez contacter notre équipe d'assistance.",
            "email_taken" => "Cette adresse e-mail est déjà prise.",
            "password" => [
                "change_mismatch" => "Ce n'est pas votre ancien mot de passe.",
                "reset_problem" => "Un problème est survenu lors de la réinitialisation de votre mot de passe. Veuillez renvoyer l'e-mail de réinitialisation du mot de passe."
            ],
            "registration_disabled" => "Les inscriptions sont actuellement fermées."
        ]
    ]
];
