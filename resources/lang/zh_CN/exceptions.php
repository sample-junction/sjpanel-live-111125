<<<<<<< HEAD
<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "already_exists" => "该角色已经存在。请选择其他名称。",
                "cant_delete_admin" => "您不能删除管理员角色。",
                "create_error" => "创建此角色时出现问题。请再试一次。",
                "delete_error" => "删除此角色时出现问题。请再试一次。",
                "has_users" => "您无法删除具有关联用户的角色。",
                "needs_permission" => "您必须为此角色至少选择一个权限。",
                "not_found" => "该角色不存在。",
                "update_error" => "更新此角色时出现问题。请再试一次。"
            ],
            "users" => [
                "already_confirmed" => "该用户已被确认。",
                "cant_confirm" => "确认用户帐户时出现问题。",
                "cant_deactivate_self" => "你不能自己做。",
                "cant_delete_admin" => "您无法删除超级管理员。",
                "cant_delete_own_session" => "您无法删除自己的会话。",
                "cant_delete_self" => "您无法删除自己。",
                "cant_restore" => "此用户未删除，因此无法还原。",
                "cant_unconfirm_admin" => "您不能取消确认超级管理员。",
                "cant_unconfirm_self" => "您不能取消确认自己。",
                "create_error" => "创建此用户时出现问题。请再试一次。",
                "delete_error" => "删除此用户时出现问题。请再试一次。",
                "delete_first" => "必须先删除此用户，然后才能将其永久销毁。",
                "email_error" => "该电子邮件地址属于另一个用户。",
                "mark_error" => "更新此用户时出现问题。请再试一次。",
                "not_confirmed" => "未确认此用户。",
                "not_found" => "该用户不存在。",
                "restore_error" => "恢复该用户时出现问题。请再试一次。",
                "role_needed" => "您必须至少选择一个角色。",
                "role_needed_create" => "您必须至少选择一个角色。",
                "session_wrong_driver" => "您的会话驱动程序必须设置为数据库才能使用此功能。",
                "social_delete_error" => "从用户删除社交帐户时出现问题。",
                "update_error" => "更新此用户时出现问题。请再试一次。",
                "update_password_error" => "更改此用户密码时出现问题。请再试一次。"
            ]
        ]
    ],
    "frontend" => [
        "auth" => [
            "confirmation" => [
                "already_confirmed" => "您的帐户已被确认。",
                "confirm" => "确认您的帐户！",
                "created_confirm" => "您的帐户已成功创建。我们已经给您发送了一封电子邮件，以确认您的帐户。",
                "created_pending" => "您的帐户已成功创建，正在等待批准。批准您的帐户后，将会发送一封电子邮件。",
                "mismatch" => "您的确认码不匹配。",
                "not_found" => "该确认代码不存在。",
                "pending" => "您的帐户目前正在等待批准。",
                "resend" => "您的帐户未被确认。请单击电子邮件中的确认链接，或<a href=\":url\">单击此处</a>以重新发送确认电子邮件。",
                "resent" => "新的确认电子邮件已发送到文件中的地址。",
                "success" => "您的帐户已成功确认！"
            ],
            "deactivated" => "您的帐户已被停用。",
            "email_taken" => "该电子邮件地址已被占用。",
            "password" => [
                "change_mismatch" => "那不是您的旧密码。",
                "reset_problem" => "重置密码时出现问题。请重新发送密码重置电子邮件。"
            ],
            "registration_disabled" => "目前注册已关闭。"
        ]
    ]
];
=======
<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "already_exists" => "该角色已经存在。请选择其他名称。",
                "cant_delete_admin" => "您不能删除管理员角色。",
                "create_error" => "创建此角色时出现问题。请再试一次。",
                "delete_error" => "删除此角色时出现问题。请再试一次。",
                "has_users" => "您无法删除具有关联用户的角色。",
                "needs_permission" => "您必须为此角色至少选择一个权限。",
                "not_found" => "该角色不存在。",
                "update_error" => "更新此角色时出现问题。请再试一次。"
            ],
            "users" => [
                "already_confirmed" => "该用户已被确认。",
                "cant_confirm" => "确认用户帐户时出现问题。",
                "cant_deactivate_self" => "你不能自己做。",
                "cant_delete_admin" => "您无法删除超级管理员。",
                "cant_delete_own_session" => "您无法删除自己的会话。",
                "cant_delete_self" => "您无法删除自己。",
                "cant_restore" => "此用户未删除，因此无法还原。",
                "cant_unconfirm_admin" => "您不能取消确认超级管理员。",
                "cant_unconfirm_self" => "您不能取消确认自己。",
                "create_error" => "创建此用户时出现问题。请再试一次。",
                "delete_error" => "删除此用户时出现问题。请再试一次。",
                "delete_first" => "必须先删除此用户，然后才能将其永久销毁。",
                "email_error" => "该电子邮件地址属于另一个用户。",
                "mark_error" => "更新此用户时出现问题。请再试一次。",
                "not_confirmed" => "未确认此用户。",
                "not_found" => "该用户不存在。",
                "restore_error" => "恢复该用户时出现问题。请再试一次。",
                "role_needed" => "您必须至少选择一个角色。",
                "role_needed_create" => "您必须至少选择一个角色。",
                "session_wrong_driver" => "您的会话驱动程序必须设置为数据库才能使用此功能。",
                "social_delete_error" => "从用户删除社交帐户时出现问题。",
                "update_error" => "更新此用户时出现问题。请再试一次。",
                "update_password_error" => "更改此用户密码时出现问题。请再试一次。"
            ]
        ]
    ],
    "frontend" => [
        "auth" => [
            "confirmation" => [
                "already_confirmed" => "您的帐户已被确认。",
                "confirm" => "确认您的帐户！",
                "created_confirm" => "您的帐户已成功创建。我们已经给您发送了一封电子邮件，以确认您的帐户。",
                "created_pending" => "您的帐户已成功创建，正在等待批准。批准您的帐户后，将会发送一封电子邮件。",
                "mismatch" => "您的确认码不匹配。",
                "not_found" => "该确认代码不存在。",
                "pending" => "您的帐户目前正在等待批准。",
                "resend" => "您的帐户未被确认。请单击电子邮件中的确认链接，或<a href=\":url\">单击此处</a>以重新发送确认电子邮件。",
                "resent" => "新的确认电子邮件已发送到文件中的地址。",
                "success" => "您的帐户已成功确认！"
            ],
            "deactivated" => "您的帐户已被停用。",
            "email_taken" => "该电子邮件地址已被占用。",
            "password" => [
                "change_mismatch" => "那不是您的旧密码。",
                "reset_problem" => "重置密码时出现问题。请重新发送密码重置电子邮件。"
            ],
            "registration_disabled" => "目前注册已关闭。"
        ]
    ]
];
>>>>>>> dev
