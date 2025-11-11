<<<<<<< HEAD
<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "您确定要永久删除该用户吗？ 在应用程序中引用此用户ID的任何位置很可能会出错。 继续需要您自担风险。 这不能被撤消。",
                "if_confirmed_off" => "（如果确认关闭）",
                "no_deactivated" => "没有停用的用户。",
                "no_deleted" => "没有已删除的用户。",
                "restore_user_confirm" => "将此用户还原到原始状态？"
            ]
        ],
        "dashboard" => [
            "title" => "仪表板",
            "welcome" => "欢迎"
        ],
        "general" => [
            "all_rights_reserved" => "版权所有。",
            "are_you_sure" => "你确定你要这么做吗？",
            "boilerplate_link" => "Laravel 5样板",
            "continue" => "继续",
            "member_since" => "会员自",
            "minutes" => "分钟",
            "search_placeholder" => "搜索...",
            "see_all" => [
                "messages" => "查看所有讯息",
                "notifications" => "查看全部",
                "tasks" => "查看所有任务"
            ],
            "status" => [
                "offline" => "离线",
                "online" => "线上"
            ],
            "timeout" => "由于安全原因，您出于安全原因自动登出",
            "you_have" => [
                "messages" => "{0}您没有消息| {1}您有1条消息| [2，Inf]您有：number条消息",
                "notifications" => "{0}您没有通知| {1}您有1条通知| [2，Inf]您有：number条通知",
                "tasks" => "{0}您没有任务| {1}您有1个任务| [2，Inf]您有：number个任务"
            ]
        ],
        "search" => [
            "empty" => "请输入一个搜索词。",
            "incomplete" => "您必须为此系统编写自己的搜索逻辑。",
            "results" => "：query的搜索结果",
            "title" => "搜索结果"
        ],
        "welcome" => "“ <p>这是<a href=\"\"https://coreui.io/\"\" target=\"\"_blank\"\"> creativeLabs </a>的CoreUI主题。这是精简版，仅包含必要的内容样式和脚本以使其运行。下载完整版本以开始将组件添加到仪表板。</p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "您的帐户已被确认。",
            "click_to_confirm" => "点击此处确认您的帐户：",
            "confirmation" => [
                "copyright" => "版权",
                "details_1" => "我们已经完成了您的SJ Panel帐户的设置。",
                "details_2" => "只需确认您的电子邮件即可开始！",
                "faq" => "您的帐户已被确认。",
                "greeting" => "点击此处确认您的帐户：",
                "heading" => "版权",
                "how_it_works" => "我们已经完成了您的SJ Panel帐户的设置。",
                "rewards" => "只需确认您的电子邮件即可开始！",
                "unsubscribe" => "常见问题"
            ],
            "error" => "嘿",
            "greeting" => "您准备好出发了！",
            "password_cause_of_email" => "这个怎么运作",
            "password_if_not_requested" => "如果您不要求重设密码，请发送电子邮件至 help@sjpanel.com",
            "password_reset_subject" => "退订",
            "regards" => "哎呀！",
            "reset_password" => "你好！",
            "thank_you_for_using_app" => "您收到此电子邮件是因为我们收到了您帐户的密码重置请求。",
            "trouble_clicking_button" => "如果您不要求重设密码，则无需采取进一步措施。"
        ],
        "contact" => [
            "email_body_title" => "重设密码",
            "subject" => "问候，"
        ]
    ],
    "frontend" => [
        "disclaimer" => "点击这里重设密码",
        "general" => [
            "joined" => "感谢您使用我们的应用程序！"
        ],
        "test" => "如果您在单击“：action_text”按钮时遇到问题，请复制以下网址并将其粘贴到网络浏览器中：",
        "tests" => [
            "based_on" => [
                "permission" => "基于权限-",
                "role" => "基于角色-"
            ],
            "js_injected_from_controller" => "从控制器注入的Javascript",
            "using_access_helper" => [
                "array_permissions" => "在用户确实拥有所有权限的情况下，将Access Helper与权限名称或ID数组配合使用。",
                "array_permissions_not" => "在用户不必全部拥有权限名称或ID的情况下使用Access Helper。",
                "array_roles" => "在用户必须拥有全部权限的情况下，将Access Helper与角色名称或ID数组配合使用。",
                "array_roles_not" => "在用户不必全部拥有的情况下，将Access Helper与角色名称或ID数组配合使用。",
                "permission_id" => "使用具有权限ID的Access Helper",
                "permission_name" => "使用具有权限名称的Access Helper",
                "role_id" => "使用具有角色ID的Access Helper",
                "role_name" => "通过角色名称使用Access Helper"
            ],
            "using_blade_extensions" => "使用刀片扩展",
            "view_console_it_works" => "在View Console中，您应该看到“有效！”这来自FrontendController @ index",
            "you_can_see_because" => "您可以看到这是因为您具有'：role'角色！",
            "you_can_see_because_permission" => "您可以看到这是因为您具有'：permission'的许可！"
        ],
        "user" => [
            "change_email_notice" => "如果更改电子邮件，您将注销，直到确认新的电子邮件地址。",
            "email_changed_notice" => "您必须先确认新的电子邮件地址，然后才能再次登录。",
            "password_updated" => "密码已成功更新。",
            "profile_updated" => "个人资料已成功更新。"
        ],
        "welcome_to" => "欢迎来到：place"
    ]
];
=======
<?php

return [
    "backend" => [
        "access" => [
            "users" => [
                "delete_user_confirm" => "您确定要永久删除该用户吗？ 在应用程序中引用此用户ID的任何位置很可能会出错。 继续需要您自担风险。 这不能被撤消。",
                "if_confirmed_off" => "（如果确认关闭）",
                "no_deactivated" => "没有停用的用户。",
                "no_deleted" => "没有已删除的用户。",
                "restore_user_confirm" => "将此用户还原到原始状态？"
            ]
        ],
        "dashboard" => [
            "title" => "仪表板",
            "welcome" => "欢迎"
        ],
        "general" => [
            "all_rights_reserved" => "版权所有。",
            "are_you_sure" => "你确定你要这么做吗？",
            "boilerplate_link" => "Laravel 5样板",
            "continue" => "继续",
            "member_since" => "会员自",
            "minutes" => "分钟",
            "search_placeholder" => "搜索...",
            "see_all" => [
                "messages" => "查看所有讯息",
                "notifications" => "查看全部",
                "tasks" => "查看所有任务"
            ],
            "status" => [
                "offline" => "离线",
                "online" => "线上"
            ],
            "timeout" => "由于安全原因，您出于安全原因自动登出",
            "you_have" => [
                "messages" => "{0}您没有消息| {1}您有1条消息| [2，Inf]您有：number条消息",
                "notifications" => "{0}您没有通知| {1}您有1条通知| [2，Inf]您有：number条通知",
                "tasks" => "{0}您没有任务| {1}您有1个任务| [2，Inf]您有：number个任务"
            ]
        ],
        "search" => [
            "empty" => "请输入一个搜索词。",
            "incomplete" => "您必须为此系统编写自己的搜索逻辑。",
            "results" => "：query的搜索结果",
            "title" => "搜索结果"
        ],
        "welcome" => "“ <p>这是<a href=\"\"https://coreui.io/\"\" target=\"\"_blank\"\"> creativeLabs </a>的CoreUI主题。这是精简版，仅包含必要的内容样式和脚本以使其运行。下载完整版本以开始将组件添加到仪表板。</p>"
    ],
    "emails" => [
        "auth" => [
            "account_confirmed" => "您的帐户已被确认。",
            "click_to_confirm" => "点击此处确认您的帐户：",
            "confirmation" => [
                "copyright" => "版权",
                "details_1" => "我们已经完成了您的SJ Panel帐户的设置。",
                "details_2" => "只需确认您的电子邮件即可开始！",
                "faq" => "您的帐户已被确认。",
                "greeting" => "点击此处确认您的帐户：",
                "heading" => "版权",
                "how_it_works" => "我们已经完成了您的SJ Panel帐户的设置。",
                "rewards" => "只需确认您的电子邮件即可开始！",
                "unsubscribe" => "常见问题"
            ],
            "error" => "嘿",
            "greeting" => "您准备好出发了！",
            "password_cause_of_email" => "这个怎么运作",
            "password_if_not_requested" => "如果您不要求重设密码，请发送电子邮件至 help@sjpanel.com",
            "password_reset_subject" => "退订",
            "regards" => "哎呀！",
            "reset_password" => "你好！",
            "thank_you_for_using_app" => "您收到此电子邮件是因为我们收到了您帐户的密码重置请求。",
            "trouble_clicking_button" => "如果您不要求重设密码，则无需采取进一步措施。"
        ],
        "contact" => [
            "email_body_title" => "重设密码",
            "subject" => "问候，"
        ]
    ],
    "frontend" => [
        "disclaimer" => "点击这里重设密码",
        "general" => [
            "joined" => "感谢您使用我们的应用程序！"
        ],
        "test" => "如果您在单击“：action_text”按钮时遇到问题，请复制以下网址并将其粘贴到网络浏览器中：",
        "tests" => [
            "based_on" => [
                "permission" => "基于权限-",
                "role" => "基于角色-"
            ],
            "js_injected_from_controller" => "从控制器注入的Javascript",
            "using_access_helper" => [
                "array_permissions" => "在用户确实拥有所有权限的情况下，将Access Helper与权限名称或ID数组配合使用。",
                "array_permissions_not" => "在用户不必全部拥有权限名称或ID的情况下使用Access Helper。",
                "array_roles" => "在用户必须拥有全部权限的情况下，将Access Helper与角色名称或ID数组配合使用。",
                "array_roles_not" => "在用户不必全部拥有的情况下，将Access Helper与角色名称或ID数组配合使用。",
                "permission_id" => "使用具有权限ID的Access Helper",
                "permission_name" => "使用具有权限名称的Access Helper",
                "role_id" => "使用具有角色ID的Access Helper",
                "role_name" => "通过角色名称使用Access Helper"
            ],
            "using_blade_extensions" => "使用刀片扩展",
            "view_console_it_works" => "在View Console中，您应该看到“有效！”这来自FrontendController @ index",
            "you_can_see_because" => "您可以看到这是因为您具有'：role'角色！",
            "you_can_see_because_permission" => "您可以看到这是因为您具有'：permission'的许可！"
        ],
        "user" => [
            "change_email_notice" => "如果更改电子邮件，您将注销，直到确认新的电子邮件地址。",
            "email_changed_notice" => "您必须先确认新的电子邮件地址，然后才能再次登录。",
            "password_updated" => "密码已成功更新。",
            "profile_updated" => "个人资料已成功更新。"
        ],
        "welcome_to" => "欢迎来到：place"
    ]
];
>>>>>>> dev
