<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "¿Estás seguro de que quieres eliminar este usuario de forma permanente? Lo más probable es que se produzca un error en cualquier lugar de la aplicación que haga referencia a la identificación de este usuario. Procede bajo tu propio riesgo. Esto no se puede deshacer.",
                "if_confirmed_off" => "(Si la confirmación está desactivada)",
                "no_deactivated" => "No hay usuarios desactivados.",
                "no_deleted" => "No hay usuarios eliminados.",
                "restore_user_confirm" => "¿Restaurar este usuario a su estado original?"
            ]
        ],
        "dashboard" => [
            "title" => "Tablero",
            "welcome" => "Bienvenido"
        ],
        "general" => [
            "all_rights_reserved" => "Todos los derechos reservados.",
            "are_you_sure" => "¿Seguro que quieres hacer esto?",
            "boilerplate_link" => "Laravel 5",
            "continue" => "Continuar",
            "member_since" => "Miembro desde",
            "minutes" => "minutos",
            "search_placeholder" => "Buscar...",
            "see_all" => [
                "messages" => "Ver todos los mensajes",
                "notifications" => "Ver todo",
                "tasks" => "Ver todas las tareas"
            ],
            "status" => [
                "offline" => "Desconectado",
                "online" => "En línea"
            ],
            "timeout" => "Se desconectó automáticamente por razones de seguridad ya que no tenía actividad en",
            "you_have" => [
                "messages" => "{0} No tiene mensajes | {1} Tiene 1 mensaje | [2, Inf] Tiene :number de mensajes",
                "notifications" => "{0} No tiene notificaciones | {1} Tiene 1 notificación | [2, Inf] Tiene :number notificaciones de número",
                "tasks" => "{0} No tienes tareas | {1} Tienes 1 tarea | [2, Inf] Tienes :number de tareas"
            ]
        ],
        "search" => [
            "empty" => "Por favor, introduzca un término de búsqueda.",
            "incomplete" => "Debes escribir tu propia lógica de búsqueda para este sistema.",
            "results" => "Resultados de la búsqueda para :query",
            "title" => "Resultados de la búsqueda"
        ],
        "welcome" => "<p> Este es el tema CoreUI de <a href=\"https://coreui.io/\" target=\"_blank\"> creativeLabs </a>. Esta es una versión simplificada con solo lo necesario Estilos y scripts para ponerlo en funcionamiento. Descargue la versión completa para comenzar a agregar componentes a su panel de control. </p>\n <p> Toda la funcionalidad es para mostrar, con la excepción del <strong> Acceso </strong> a la izquierda. Esta placa de calderas viene con una biblioteca de control de acceso completamente funcional para administrar usuarios y roles impulsados ​​por <a href=\"https://github.com/spatie/laravel-permission\" target=\"_blank\"> spatie / laravel- permiso </a>. </p>\n <p> Tenga en cuenta que es un trabajo en progreso y que pueden tratarse de errores u otros problemas que no he encontrado. Haré mi mejor esfuerzo para corregirlos cuando los reciba. </p>\n <p> Espero que disfrutes todo el trabajo que he puesto en esto. Visite la página <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"_blank\"> GitHub </a> para obtener más información y reportar cualquier <a href = \" https://github.com/rappasoft/Laravel-5-Boilerplate/issues \" target = \" _ blank \"> problemas aquí </a>. </p>\n <p> <strong> Este proyecto es muy exigente para mantenerse al día, dada la velocidad a la que cambia la sucursal Laravel maestra, por lo que se agradece cualquier ayuda. </strong> </p>\n <p> - Anthony Rappa </p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Su cuenta ha sido confirmada.",
            "click_to_confirm" => "Haga clic aquí para confirmar su cuenta:",
            "confirmation" => [
                "copyright" => "Derechos de autor",
                "details_1" => "Hemos terminado de configurar su cuenta de SJ Panel.",
                "details_2" => "¡Solo confirma tu email para empezar!",
                "faq" => "Preguntas frecuentes",
                "greeting" => "Oye",
                "heading" => "Usted está listo para ir!",
                "how_it_works" => "Cómo funciona",
                "rewards" => "Recompensas",
                "unsubscribe" => "Darse de baja"
            ],
            "error" => "Whoops!",
            "greeting" => "¡Hola!",
            "password_cause_of_email" => "Está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.",
            "password_if_not_requested" => "Si no solicitó un restablecimiento de contraseña, informe a help@sjpanel.com",
            "password_reset_subject" => "Restablecer la contraseña",
            "regards" => "Saludos,",
            "reset_password" => "Pincha aquí para restaurar tu contraseña",
            "thank_you_for_using_app" => "¡Gracias por utilizar nuestra aplicación!",
            "trouble_clicking_button" => "Si tienes problemas para hacer clic en el botón \":action_text\", copia y pega la URL a continuación en tu navegador web:"
        ],
        "contact" => [
            "email_body_title" => "Tiene una nueva solicitud de formulario de contacto: A continuación se muestran los detalles:",
            "subject" => "Un nuevo :app_name formulario de contacto de presentación!"
        ]
    ],
    "frontend" => [
        "disclaimer" => "Hai ricevuto questa mail perché sei registrato con noi come membro del Panel e hai acconsentito a ricevere comunicazioni e-mail per ricevere sondaggi e guadagnare premi. Puoi sempre annullare l'iscrizione alla nostra mailing list, facendo clic su",
        "general" => [
            "joined" => "Unido"
        ],
        "test" => "Prueba",
        "tests" => [
            "based_on" => [
                "permission" => "Basado en permisos",
                "role" => "Basado en roles"
            ],
            "js_injected_from_controller" => "Javascript inyectado desde un controlador",
            "using_access_helper" => [
                "array_permissions" => "Uso de Access Helper con una matriz de nombres de permisos o ID donde el usuario tiene que poseer todos.",
                "array_permissions_not" => "Uso de Access Helper con una matriz de nombres de permisos o ID donde el usuario no tiene que poseer todos.",
                "array_roles" => "Uso de Access Helper con Array of Role Names o ID's donde el usuario tiene que poseer todos.",
                "array_roles_not" => "Uso de Access Helper con Array of Role Names o ID's donde el usuario no tiene que poseer todos.",
                "permission_id" => "Uso de Access Helper con ID de permiso",
                "permission_name" => "Usando Access Helper con nombre de permiso",
                "role_id" => "Uso de Access Helper con ID de rol",
                "role_name" => "Uso de Access Helper con nombre de rol"
            ],
            "using_blade_extensions" => "Usando Extensiones Blade",
            "view_console_it_works" => "Ver la consola, deberías ver 'funciona'! que viene de FrontendController @ index",
            "you_can_see_because" => "¡Puedes ver esto porque tienes el rol de ':role'!",
            "you_can_see_because_permission" => "¡Puedes ver esto porque tienes el permiso de ':permission'!"
        ],
        "user" => [
            "change_email_notice" => "Si cambia su correo electrónico, se cerrará su sesión hasta que confirme su nueva dirección de correo electrónico.",
            "email_changed_notice" => "Debe confirmar su nueva dirección de correo electrónico antes de poder iniciar sesión nuevamente.",
            "password_updated" => "Contraseña actualizada con éxito.",
            "profile_updated" => "Perfil actualizado con éxito."
        ],
        "welcome_to" => "Bienvenido a :place"
    ]
];
