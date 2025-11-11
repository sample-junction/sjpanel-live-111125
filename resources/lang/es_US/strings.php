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
        "welcome" => "<p> Este es el tema CoreUI de <a href=\"https://coreui.io/\" target=\"_blank\"> creativeLabs </a>. Esta es una versión simplificada con solo lo necesario Estilos y scripts para ponerlo en funcionamiento. Descargue la versión completa para comenzar a agregar componentes a su panel de control. </p>\n <p> Toda la funcionalidad es para mostrar, con la excepción del <strong> Acceso </strong> a la izquierda. Esta placa de calderas viene con una biblioteca de control de acceso completamente funcional para administrar usuarios y roles impulsados por <a href=\"https://github.com/spatie/laravel-permission\" target=\"_blank\"> spatie / laravel- permiso </a>. </p>\n <p> Tenga en cuenta que es un trabajo en progreso y que pueden tratarse de errores u otros problemas que no he encontrado. Haré mi mejor esfuerzo para corregirlos cuando los reciba. </p>\n <p> Espero que disfrutes todo el trabajo que he puesto en esto. Visite la página <a href=\"https://github.com/rappasoft/laravel-5-boilerplate\" target=\"_blank\"> GitHub </a> para obtener más información y reportar cualquier <a href = \" https://github.com/rappasoft/Laravel-5-Boilerplate/issues \" target = \" _ blank \"> problemas aquí </a>. </p>\n <p> <strong> Este proyecto es muy exigente para mantenerse al día, dada la velocidad a la que cambia la sucursal Laravel maestra, por lo que se agradece cualquier ayuda. </strong> </p>\n <p> - Anthony Rappa </p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "Su cuenta ha sido confirmada.",
            "click_to_confirm" => "Haga clic aquí para confirmar su cuenta:",
            "confirmation" => [
                "copyright" => "Derechos de autor",
                "copyrightcompany" => "Sample Junction Canada In",
                "details_1" => "Hemos terminado de configurar su cuenta de SJ Panel.",
                "details_2" => "¡Solo confirma tu email para empezar!",
                "all_right" => 'Reservados todos los derechos.',
                "link_content1" => "Está recibiendo este correo electrónico porque es un miembro registrado de SJ Panel, donde lo recompensamos mediante incentivos por participar en encuestas en línea. Si no desea recibir ningún correo electrónico futuro de SJ Panel, cancele su suscripción para desactivar su cuenta. Tan pronto como cancele su suscripción a SJ Panel, su cuenta se eliminará dentro de las 72 horas y dejará de recibir correos electrónicos de SJ Panel. En caso de necesitar soporte técnico, por favor escriba a nuestro equipo a",
                "mail_content" => "Para recibir nuestros correos electrónicos en su bandeja de entrada y evitar spam, agregue",
                "link_content" => "a tu lista de remitentes seguros.",
                "link" => "donotreply@sjpanel.com",
                "link1" => "support@sjpanel.com",
                "com_details_1" => "¡Su cuenta SJ Panel ya está activa! Confirme su cuenta haciendo clic en el botón a continuación para obtener acceso completo a las funciones de SJ Panel y ganar",
                "com_details_2" => " Puntos:",
                "com_details_3" => "Hemos notado que se ha unido a SJ Panel pero aún no ha completado el proceso de registro. Complete el proceso de registro de su cuenta de SJ Panel simplemente haciendo clic en el botón a continuación. para que pueda comenzar a realizar encuestas y obtener las máximas recompensas.",
                "com_details_3a" => "Al hacerlo, desbloquearás el acceso a un mundo de encuestas interesantes donde tu opinión realmente importa, ¡y ganarás fantásticos $1.4 (1400 puntos) solo por comenzar!",

                "com_details_4"=>"puntos.",
                "doi_reminder" => "Recordatorio:",
                "doi_success"=>"Exitosa",
                "doi_fail"=>"ningún record fue encontrado",
                //"contact_detail" => "Si no envió ninguna solicitud por favor envíe un correo a",
                //"details_2" => "If the link is not working then copy and paste it in your browser and hit enter. If it still does not work please write to support@sjpanel.com",
                "details_2" =>"¡Solo confirma tu correo electrónico para comenzar!",
                "details_3"=>"“No todo el mundo necesita estar en los servicios de Defensa o en las ONG para servir a su país.
                Puede hacerlo simplemente dando una opinión HONESTA e IMPARCIAL en las encuestas para permitir que las empresas elaboren mejores productos y servicios para el mundo”.",
                "delete_details_1" => "Recibimos una solicitud de usted para desactivar la cuenta. Todos sus datos con nosotros serán eliminados.",
                "userinfo_delete_details_1" => "Hemos recibido una solicitud de usted para eliminar su información personal almacenada con nosotros. Si realmente solicitó la eliminación de su información personal, haga clic en el botón a continuación como su confirmación final; de lo contrario, informe esto a nuestro equipo de soporte en support@sjpanel.com.",
                "delete_details_2" => "Si realmente solicitó desactivar su cuenta, haga clic en el botón a continuación como su confirmación final; de lo contrario, informe a nuestro equipo de soporte en support@sjpanel.com.",
                "userinfo_delete_details_2" => "Si no solicitó eliminar su información personal, haga clic aquí.",
                "userinfo_delete_details_3" => "Recientemente hemos recibido una solicitud suya para eliminar su información personal que se almacena con nosotros. Asegurar la seguridad y la privacidad de sus datos es de suma importancia para nosotros, y estamos comprometidos a cumplir con su solicitud con prontitud.",
                "userinfo_delete_details_4" => "Para finalizar la eliminación de su información personal, haga clic en el botón ",
                "userinfo_delete_details_6"=> "a continuación:",
                "userinfo_delete_details_5" => "Si no hizo esta solicitud o tiene ninguna inquietud sobre esta acción, no dude en informarla a nuestro equipo de apoyo dedicado a",
                "userinfo_delete_details_7" => "Estamos aquí para ayudarlo y abordar cualquier pregunta o problema que pueda tener.",
                "confirm_button" => "Confirmar",
                "faq" => "Preguntas frecuentes",
                "contact" => "Contactos",
                "dele" => "Borrar",
                "greetings" => "Oye",
                "dear" => "Querido",
                "heading" => "Usted está listo para ir!",
                "how_it_works" => "Cómo funciona",
                "rewards" => "Iniciar la encuesta",
                "unsubscribe" => "Darse de baja",
                "cookie" => "Política de cookies",
                "safeguards" => "salvaguardias",
                "footer" => "¡Feliz encuesta, tomando la encuesta!",
                "footer_1" => "Para recibir nuestros correos electrónicos en su bandeja de entrada y evitar spam, agregue ",
                "deactivate_content_1" => "Esperamos que este mensaje te encuentre bien. Queríamos informarle que hemos recibido una solicitud de desactivación para su cuenta del SJ Panel.",
                "deactivate_content_2" => "Si realmente solicitó la desactivación de su cuenta, haga clic en el botón a continuación para proporcionar su confirmación final:",
                "deactivate_content_3" => "Si usted no inició esta solicitud de desactivación, o si tiene alguna inquietud, no dude en informarla a nuestro equipo de apoyo dedicado a",
                "deactivate_content_4" => "Estamos aquí para ayudarlo y garantizar la seguridad de su cuenta.",
                "person_delete" => "Estamos escribiendo para informarle que su solicitud de eliminar su información personal, que fue almacenada con nosotros, se ha procesado con éxito. Según su solicitud, hemos eliminado permanentemente todos sus datos personales de nuestros registros, y su cuenta también se ha eliminado.",
                "person_delete1" => "Si decide reunirse con el SJ Panel en el futuro, solicitamos amablemente que cree un nuevo inicio de sesión, y estaremos encantados de darle la bienvenida como miembro.",
                "person_delete2" => "Si tiene alguna pregunta o requiere más ayuda, no dude en comunicarse con nosotros a ",
                "person_delete3" => " Estamos aquí para ayudar.",
                "Minutes" => "Minutos",
                "Enter"=> "Ingresar"

            ],
            "error" => "Whoops!",
            "greeting" => "¡Hola!",
            "password_cause_of_email" => "Está recibiendo este correo electrónico porque recibimos una solicitud de restablecimiento de contraseña para su cuenta.",
            "password_cause_of_email_new" => "Recibimos una solicitud tuya para restablecer tu contraseña. Para proceder haga clic aquí.",
            "password_cause_of_email_new1" => "Hemos recibido una solicitud de restablecimiento de contraseña de usted. Para continuar, haga clic en el enlace a continuación:",
            "password_cause_of_email_new2" => "Si no inició esta solicitud, comuníquese con nuestro equipo de soporte a",
            "password_cause_of_email_new4"=> "de inmediato.",
            "password_cause_of_email_new3" => "¡Gracias por elegir el SJ Panel!",
            "password_if_not_requested" => "Si no solicitó un restablecimiento de contraseña, informe a help@sjpanel.com",
            "password_if_not_requested_new" => "Si no envió ninguna solicitud por favor envíe un correo a",
            "password_reset_subjects" => "Solicitud de restablecimiento de contraseña",
            "regards" => "Saludos,",
            "reset_password" => "Pincha aquí para restaurar tu contraseña",
            "thank_you_for_using_app" => "¡Gracias por utilizar nuestra aplicación!",
            "trouble_clicking_button" => "Si tienes problemas para hacer clic en el botón \":action_text\", copia y pega la URL a continuación en tu navegador web:"
        ],
        "contact" => [
            "email_body_title" => "Tiene una nueva solicitud de formulario de contacto: A continuación se muestran los detalles:",
            "subject" => "Un nuevo :app_name formulario de contacto de presentación!"
        ],
        "fraud_mail" => [
            "greeting" => "Estimada",
            "greeting_title" => "¡Saludos desde Panel SJ!",
            "body_details" => "Nuestro cliente ha encontrado sus respuestas para la encuesta número :survey_number inaceptables y sospechosas.",
            "body_details_1" => "Le solicitamos que pase por nuestra",
            "body_details_2" => "cláusula número 4 y 5 para conocer las consecuencias de ser marcado como fraude en nuestro panel.",
            "body_details_3" =>"Si tiene alguna pregunta o inquietud al respecto, no dude en comunicarse con nosotros por correo electrónico a support@samplejunction.com.",
            "list_details" => "Intentando la encuesta que actualmente no está disponible",
            "list_details_1" => "Intentar la encuesta desde un correo electrónico no registrado",
            "list_details_2" => "Intentar la encuesta desde un país que no coincide con su perfil",
            "list_details_3" => "Intentando la encuesta desde un enlace de encuesta no válido",
            "list_details_4" => "Intentar la encuesta más de una vez",
            "list_details_5" => "Probar o competir en una encuesta por medios desleales",
            "subject" => "¡Un nuevo envío de formulario de contacto de :app_name!",
            "subject_fraud"=>'Actividad fraudulenta observada con su cuenta',
            "subject_backlist"=>'Atención: Su cuenta ha sido suspendida permanentemente.',
            "subject_welcome"=>"¡Bienvenido al panel de SJ!",
        ],
        "blacklist_mail" => [
            "body_details" => "Desafortunadamente, tenemos que suspender permanentemente su cuenta con nosotros porque sus respuestas se marcan como fraudulentas :fraudulent_count veces.",
            "body_details_1" => "Su cuenta estuvo involucrada en actividades que van en contra de nuestros estándares de calidad del panel. En consecuencia, no podrá participar en ninguna encuesta ni podrá reclamar ningún incentivo. Todos sus incentivos se perderán según nuestro",
            "body_details_2" => "y no podrás reclamarlo.",
            "body_details_3" =>"Si tiene alguna pregunta o inquietud al respecto, no dude en comunicarse con nosotros en support@samplejunction.com.",
        ]
    ],
    "frontend" => [
        "disclaimer" => "Está recibiendo este correo electrónico porque es un miembro registrado de SJ Panel, donde lo recompensamos mediante incentivos por participar en encuestas en línea. Si no desea recibir ningún correo electrónico futuro de SJ Panel, cancele su suscripción para desactivar su cuenta. Tan pronto como cancele su suscripción a SJ Panel, su cuenta se eliminará dentro de las 72 horas y dejará de recibir correos electrónicos de SJ Panel. En caso de necesitar soporte técnico, por favor escriba a nuestro equipo a",
        "disclaimer_1" => "Equipo del panel SJ",
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
            "profile_updated" => "Perfil actualizado con éxito.",
            "password_updated_message" => "Contraseña cambiada exitosamente, por favor inicie sesión con su contraseña actualizada.",
        ],
        "welcome_to" => "Bienvenido a :place"
    ]
];
