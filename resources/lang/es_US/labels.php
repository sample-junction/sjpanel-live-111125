<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "create" => "Crear rol",
                "edit" => "Editar rol",
                "management" => "Gestión de roles",
                "table" => [
                    "number_of_users" => "Número de usuarios",
                    "permissions" => "Permisos",
                    "role" => "Role",
                    "sort" => "Clasificar",
                    "total" => "rol total | roles total"
                ]
            ],
            "users" => [
                "active" => "Usuarios activos",
                "all_permissions" => "Todos los permisos",
                "change_password" => "Cambia la contraseña",
                "change_password_for" => "Cambiar contraseña para :user",
                "create" => "Crear usuario",
                "deactivated" => "Usuarios desactivados",
                "deleted" => "Usuarios eliminados",
                "edit" => "editar usuario",
                "management" => "Gestión de usuarios",
                "no_permissions" => "No permisos",
                "no_roles" => "No hay roles para establecer.",
                "permissions" => "Permisos",
                "total_panelists" => "Panelistas totales",
                "table" => [
                    "confirmed" => "Confirmado",
                    "doi" => "DOI",
                    "country" => "País",
                    "created" => "Creado",
                    "email" => "Email",
                    "first_name" => "Nombre de pila",
                    "id" => "CARNÉ DE IDENTIDAD",
                    "last_name" => "Apellido",
                    "last_updated" => "Última actualización",
                    "name" => "Nombre",
                    "no_deactivated" => "No hay usuarios desactivados",
                    "no_deleted" => "Sin usuarios eliminados",
                    "other_permissions" => "Otros permisos",
                    "permissions" => "Permisos",
                    "roles" => "Roles",
                    "social" => "Social",
                    "total" => "Total de usuario | Usuarios Total",
                    "uuid" =>"UUID",
                    "panelistid" =>"ID de panelista",
                    "age" =>"Edad",
                    "gender" =>"Género",
                    "fraud_count" => "Recuento de fraude",
                    "project_code" => "Fraude Código de proyecto",
                    "action" => "Acción",
                    "reset" => "Reiniciar",
                    "bulk_search" => "Búsqueda masiva",
                    "export_profiles" => "Exportar perfiles",
                    "bulk_mark" => "Fraude de marcas masivas",
                    "search" => "Buscar",
                    "search_type" => "Tipo de búsqueda",
                    "select_type" => "Seleccionar tipo de búsqueda",
                    "user_ids" => "ID de usuario",
                    "apply" => "Aplicar",
                    "add_fraud" => "Añadir fraude",
                    "project_code" => "Código de proyecto",
                    "reason" => "Razón",
                    "enter_reason" => "Ingrese el motivo",
                    "bulk_upload" => "Carga masiva de Excel (solo CSV)",
                    "sample_excel" => "Descargar ejemplo de Excel",
                    "upload_excel" => "Subir Excel (Solo CSV)",
                    "upload" => "Subir",
                    "fraud" => "Fraude",
                    "export_profile" => "Perfil de exportación",
                    "country_code" => "Código de país",
                    "export" => "Exportar",
                    //modified by obhi
                    "locale"=>"Idioma",
                    "Latest_update"=>"Última actualización (perfil, redes sociales, contraseña cambiada)",
                    "Last_login"=>"Último acceso",
                    "last_survey_taken"=>"Última encuesta realizada",
                    "Doi_reminder"=>"Recordar DOI",
                    "fisrt_name"=>"Nombre de pila",
                    "last_name"=>"Apellido",
                    "recent_activity"=>"Actividad reciente",
                    "profile_filled"=>"Perfil lleno",
                    "no_of_profile_filled"=>"Número de perfil completado",
                    "total_no_of_survey_attempted"=>"Número total de encuestas intentadas",
                    "last_survey_complete_on"=>"Fecha de finalización de la última encuesta",
                    "last_survey_status"=>"Estado de la última encuesta",
                    "total_no_of_survey_complete"=>"Número total de encuestas completadas",
                    "joining_date"=>"Dia de ingreso",
                    "latest_update_activity"=>"Última actividad actualizada (perfil, redes sociales, contraseña cambiada)",
                    "recent_activity_date"=>"Fecha y hora de actividad reciente",
                    "channel"=>"Nombre del canal de la encuesta realizada",
                    //modified by obhi
                    "zipcode"=>"Código postal",
                    "city_state"=>"Estado de la Ciudad",
                    "unsubscribed"=>"Cancelar suscripción",
                    "deactivated"=>"Desactivado",
                    "SOI"=>"ASIQUE",
                    "DOI"=>"DOI",
                ],
                "tabs" => [
                    "content" => [
                        "overview" => [
                            "avatar" => "Avatar",
                            "confirmed" => "Confirmado",
                            "created_at" => "Creado en",
                            "deleted_at" => "Eliminado en",
                            "email" => "Email",
                            "first_name" => "Nombre de pila",
                            "last_login_at" => "Último inicio de sesión en",
                            "last_login_ip" => "Último inicio de sesión de IP",
                            "last_name" => "Apellido",
                            "last_updated" => "Última actualización",
                            "name" => "Nombre",
                            "status" => "Estado",
                            "timezone" => "Zona horaria"
                        ]
                    ],
                    "titles" => [
                        "history" => "Historia",
                        "overview" => "Visión general"
                    ]
                ],
                "view" => "Ver Usuario"
            ],
            "reports" => [
                "active" => "Usuarias activas",
                "all_permissions" => "Todos los permisos",
                "deleted" => "Usuarios eliminadas",
                "edit" => "editar usuario",
                "management" => "Gestión de usuarios",
                "no_permissions" => "No permisos",
                "no_roles" => "No hay roles que establecer.",
                "permissions" => "Permisos",
                "table" => [
                    "total_earned" => "Total ganado (puntos del panel SJ)",
                    "total_invite_sent" => "Total de invitaciones enviadas",
                    "total_click_start" => "Clic total/Inicio",
                    "response_rate" => "Tasa de respuesta(%)",
                    "project_code" => "Código de proyecto",
                    "status" => "Estado",
                    "uuid" =>"UUID",
                    "panelistid" =>"ID de panelista",
                    "age" =>"Edad en años)",
                    "gender" =>"Género"
                ],
                "titles" => [
                    "response_rate_title" => "Tasa de respuesta de los panelistas",
                    "active_panelists" => "Panelista activo",
                    "rejection" => "Rechazo",
                    "incentive_distribution" => "Distribución de incentivos",
                    "survey" => "Informe de estado de la encuesta",
                    "panelist_management" => "Maestro Panelista",
                    "monthly_award" => "Datos de premios mensuales",
                    "survey_details" => "Detalles de la encuesta",
                    "new_survey_report" => "Reporte de encuesta"
                ],
            ],
            "setting" => [
                
                "management" => "Gestión de entornos",
                "table" => [
                    "total_earned" => "Total ganado (puntos del panel SJ)",
                    "total_invite_sent" => "Total de invitaciones enviadas",
                    "total_click_start" => "Clic total/Inicio",
                    "response_rate" => "Tasa de respuesta(%)",
                    "project_code" => "Código de proyecto",
                    "status" => "Estado",
                    "uuid" =>"UUID",
                    "panelistid" =>"ID de panelista",
                    "age" =>"Edad en años)",
                    "gender" =>"Género"
                ],
                "titles" => [
                    "active_fraud_title" => "Configuración de fraude activo",
                    "point_system_title" => "Configuración del sistema de puntos"
                ],
            ],
        ],
        "affiliate" => [
            "campaign" => "Campaña",
            "campaign_data" => "Datos de la campaña",
            "list" => "Lista"
        ]
    ],
    "frontend" => [
        "auth" => [
            "disclaimer_checkbox" => "Al hacer clic en esta casilla de verificación, comprende y acepta nuestro",
            "login_box_title" => "Iniciar sesión",
            "login_button" => "Iniciar sesión",
            "login_with" => "Inicia sesión con :social_media",
            "signup_with" => "Registrarte con :social_media",
            "register_box_title" => "Registro",
            "register_button" => "Registro",
            "checkbox_register" => "acepto el",
            "remember_me" => "Recuérdame"
        ],
        "contact" => [
            "box_title" => "Contáctenos",
            "button" => "Enviar información"
        ],
        "passwords" => [
            "expired_password_box_title" => "Tu contraseña ha expirado.",
            "forgot_password" => "¿Olvidaste tu contraseña?",
            "reset_password_box_title" => "Restablecer la contraseña",
            "reset_password_button" => "Restablecer la contraseña",
            "send_password_reset_link_button" => "Enviar contraseña Restablecer enlace",
            "sub_label" => "Puede restablecer su contraseña aquí.",
            "update_password_button" => "Actualiza contraseña"
        ],
        "user" => [
            "passwords" => [
                "change" => "Cambia la contraseña"
            ],
            "profile" => [
                "avatar" => "Avatar",
                "created_at" => "Creado en",
                "edit_information" => "editar informacion",
                "email" => "Email",
                "first_name" => "Nombre de pila",
                "last_name" => "Apellido",
                "last_updated" => "Última actualización",
                "name" => "Nombre",
                "update_information" => "Actualizar información"
            ]
        ]
    ],
    "general" => [
        "actions" => "Comportamiento",
        "active" => "Activo",
        "all" => "Todos",
        "buttons" => [
            "save" => "Salvar",
            "update" => "Actualizar"
        ],
        "copyright" => "Derechos de autor",
        "custom" => "Personalizado",
        "hide" => "Esconder",
        "inactive" => "Inactivo",
        "more" => "Comportamiento",
        "no" => "No",
        "none" => "Ninguna",
        "show" => "Show",
        "toggle_navigation" => "Navegación de palanca",
        "yes" => "Sí"
    ]
];
