<?php

return [
    "accepted" => "El atributo :attribute debe ser aceptado.",
    "active_url" => "El :attribute no es una URL válida.",
    "after" => "El atributo :attribute debe ser una fecha después de :date.",
    "after_or_equal" => "El atributo :attribute debe ser una fecha posterior o igual a la :date.",
    "alpha" => "El atributo :attribute solo puede contener letras.",
    "alpha_dash" => "El atributo :attribute solo puede contener letras, números, guiones y guiones bajos.",
    "alpha_num" => "El atributo :attribute solo puede contener letras y números.",
    "array" => "El :attribute debe ser una matriz.",
    "attributes" => [
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "Roles asociados",
                    "dependencies" => "Dependencias",
                    "display_name" => "Nombre para mostrar",
                    "first_name" => "Nombre de pila",
                    "group" => "Grupo",
                    "group_sort" => "Grupo de clasificación",
                    "groups" => [
                        "name" => "Nombre del grupo"
                    ],
                    "last_name" => "Apellido",
                    "name" => "Nombre",
                    "system" => "Sistema"
                ],
                "roles" => [
                    "associated_permissions" => "Permisos asociados",
                    "name" => "Nombre",
                    "sort" => "Ordenar"
                ],
                "users" => [
                    "active" => "Activo",
                    "associated_roles" => "Roles asociados",
                    "confirmed" => "Confirmado",
                    "email" => "Dirección de correo electrónico",
                    "first_name" => "Nombre de pila",
                    "language" => "Idioma",
                    "last_name" => "Apellido",
                    "name" => "Nombre",
                    "other_permissions" => "Otros permisos",
                    "password" => "Contraseña",
                    "password_confirmation" => "Confirmación de contraseña",
                    "send_confirmation_email" => "Enviar correo electrónico de confirmación",
                    "timezone" => "Zona horaria"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "Ubicación de Avatar",
            "email" => "Dirección de correo electrónico",
            "first_name" => "Nombre de pila",
            "middle_name" => "Segundo nombre",
            "language" => "Idioma",
            "last_name" => "Apellido",
            "message" => "Mensaje",
            "name" => "Nombre completo",
            "new_password" => "Nueva contraseña",
            "new_password_confirmation" => "Nueva confirmación de contraseña",
            "old_password" => "Contraseña anterior",
            "password" => "Contraseña",
            "password_confirmation" => "Confirmación de contraseña",
            "phone" => "Teléfono",
            "timezone" => "Zona horaria",
            "password_require" => "Requisito de contraseña:",
            "password_require1" => "La longitud mínima de la contraseña es de 8 caracteres.",
            "password_require2" => "Requiere al menos una letra mayúscula del latín albhabet (A-Z).",
            "password_require3" => "Requiere al menos un número.",
            "password_require4" => "Requerir al menos un carácter no alfanumérico (!@#$%^&*()_+=[]{}|')
            ",
        ]
    ],
    "before" => "El :attribute debe ser una fecha anterior a :date.",
    "before_or_equal" => "El :attribute debe ser una fecha anterior o igual a la :date.",
    "between" => [
        "array" => "El :attribute debe tener entre :min y :max elementos.",
        "file" => "El :attribute debe estar entre :min y :max de kilobytes.",
        "numeric" => "El :attribute debe estar entre :min y :max.",
        "string" => "El :attribute debe estar entre :min y :max caracteres."
    ],
    "boolean" => "El campo :attribute debe ser verdadero o falso.",
    "confirmed" => "La confirmación del :attribute no coincide.",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "mensaje personalizado"
        ]
    ],
    "date" => "El :attribute no es una fecha válida.",
    "date_equals" => "El :attribute debe ser una fecha igual a :date.",
    "date_format" => "El :attribute no coincide con el formato :format.",
    "different" => "El :attribute y :other ser diferentes.",
    "digits" => "El :attribute debe ser :digits dígitos.",
    "digits_between" => "El :attribute debe estar entre :min y :max de dígitos.",
    "dimensions" => "El :attribute tiene dimensiones de imagen no válidas.",
    "distinct" => "El campo :attribute tiene un valor duplicado.",
    "email" => "El :attribute debe ser una dirección de correo electrónico válida.",
    "exists" => "Elseleccionado :attribute no es válido.",
    "file" => "El :attribute debe ser un archivo.",
    "filled" => "El campo :attribute debe tener un valor.",
    "gt" => [
        "array" => "El :attribute debe tener más de :value de .",
        "file" => "El :attribute debe ser mayor que :value de kilobytes.",
        "numeric" => "El :attribute debe ser mayor que :value",
        "string" => "El :attribute debe ser mayor que :value caracteres de valor."
    ],
    "gte" => [
        "array" => "El :attribute debe tener :value elementos de valor o más.",
        "file" => "El :attribute debe ser mayor o igual que :value el de kilobytes.",
        "numeric" => "El :attribute debe ser mayor o igual que el :value.",
        "string" => "El :attribute debe ser mayor o igual que los caracteres de :value."
    ],
    "image" => "El :attribute debe ser una imagen.",
    "in" => "Elseleccionado :attribute no es válido.",
    "in_array" => "El campo :attribute no existe en :other.",
    "integer" => "El :attribute debe ser un número entero.",
    "ip" => "El :attribute debe ser una dirección IP válida.",
    "ipv4" => "El :attribute debe ser una dirección IPv4 válida.",
    "ipv6" => "El :attribute debe ser una dirección IPv6 válida.",
    "json" => "El :attribute debe ser una cadena JSON válida.",
    "lt" => [
        "array" => "El :attribute debe tener menos de :value de .",
        "file" => "El :attribute debe ser menor que :value de kilobytes.",
        "numeric" => "El :attribute debe ser menor que :value.",
        "string" => "El :attribute debe ser menor que :value de ."
    ],
    "lte" => [
        "array" => "El :attribute no debe tener más de :value elementos de valor.",
        "file" => "El :attribute debe ser menor o igual que el :value de kilobytes.",
        "numeric" => "El :attribute debe ser menor o igual que el :value",
        "string" => "El :attribute debe ser menor o igual que el :value de los caracteres."
    ],
    "max" => [
        "array" => "El :attribute no puede tener más de :max elementos.",
        "file" => "El :attribute no puede ser mayor que :max kilobytes.",
        "numeric" => "El :attribute no puede ser mayor que :max.",
        "string" => "El :attribute no puede ser mayor que :max caracteres."
    ],
    "mimes" => "El :attribute debe ser un archivo de tipo :values.",
    "mimetypes" => "El :attribute debe ser un archivo de tipo :values.",
    "min" => [
        "array" => "El :attribute debe tener al menos :min elementos .",
        "file" => "El :attribute debe ser al menos :min kilobytes mínimos.",
        "numeric" => "El :attribute debe ser al menos :min.",
        "string" => "El :attribute debe ser al menos :min caracteres."
    ],
    "not_in" => "El :attribute seleccionado no es válido.",
    "not_regex" => "El formato de :attribute no es válido.",
    "numeric" => "El :attribute debe ser un número.",
    "present" => "El campo :attribute debe estar presente.",
    "regex" => "El formato de :attribute no es válido.",
    "required" => "El campo :attribute es obligatorio.",
    "required_if" => "El campo :attribute es obligatorio cuando :value otro es.",
    "required_unless" => "El campo :attribute es obligatorio a menos que :value otro esté en .",
    "required_with" => "El campo :attribute es obligatorio cuando :values los valores están presentes.",
    "required_with_all" => "El campo :attribute es obligatorio cuando :values los valores están presentes.",
    "required_without" => "El campo :attribute es obligatorio cuando :valueslos valores no están presentes.",
    "required_without_all" => "El campo :attribute es obligatorio cuando ninguno de los :values está presente.",
    "same" => "Ely :attribute :other debe coincidir.",
    "size" => [
        "array" => "El :attribute debe contener :size elementos de tamaño.",
        "file" => "El :attribute debe ser :sizekilobytes de tamaño.",
        "numeric" => "El :attribute debe ser :size tamaño.",
        "string" => "El :attribute debe :sizecaracteres de tamaño."
    ],
    "starts_with" => "El :attribute debe comenzar con uno de los siguientes: :values",
    "string" => "El :attribute debe ser una cadena.",
    "timezone" => "El :attribute debe ser una zona válida.",
    "unique" => "El :attribute ya ha sido tomado.",
    "uploaded" => "El :attribute no se pudo cargar.",
    "url" => "El formato de :attribute no es válido.",
    "uuid" => "El :attribute debe ser un UUID válido."
];
