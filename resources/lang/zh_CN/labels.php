<<<<<<< HEAD
<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "create" => "创建角色",
                "edit" => "编辑角色",
                "management" => "角色管理",
                "table" => [
                    "number_of_users" => "用户数",
                    "permissions" => "权限",
                    "role" => "角色",
                    "sort" => "分类",
                    "total" => "角色总数|角色总数"
                ]
            ],
            "users" => [
                "active" => "活跃用户",
                "all_permissions" => "所有权限",
                "change_password" => "更改密码",
                "change_password_for" => "更改用户密码：",
                "create" => "创建用户",
                "deactivated" => "停用的用户",
                "deleted" => "删除的用户",
                "edit" => "编辑使用者",
                "management" => "用户管理",
                "no_permissions" => "没有权限",
                "no_roles" => "没有角色可设置。",
                "permissions" => "权限",
                "table" => [
                    "confirmed" => "已确认",
                    "created" => "已建立",
                    "email" => "电子邮件",
                    "first_name" => "名字",
                    "id" => "ID",
                    "last_name" => "姓",
                    "last_updated" => "最近更新时间",
                    "name" => "名称",
                    "no_deactivated" => "没有停用的用户",
                    "no_deleted" => "没有已删除的用户",
                    "other_permissions" => "其他权限",
                    "permissions" => "权限",
                    "roles" => "的角色",
                    "social" => "社会的",
                    "total" => "用户总数|用户总数"
                ],
                "tabs" => [
                    "content" => [
                        "overview" => [
                            "avatar" => "头像",
                            "confirmed" => "已确认",
                            "created_at" => "创建于",
                            "deleted_at" => "删除于",
                            "email" => "电子邮件",
                            "first_name" => "名字",
                            "last_login_at" => "上次登录时间：",
                            "last_login_ip" => "上次登录IP",
                            "last_name" => "姓",
                            "last_updated" => "最近更新时间",
                            "name" => "名称",
                            "status" => "状态",
                            "timezone" => "时区"
                        ]
                    ],
                    "titles" => [
                        "history" => "历史",
                        "overview" => "总览"
                    ]
                ],
                "view" => "查看用户"
            ]
        ],
        "affiliate" => [
            "campaign" => "运动",
            "campaign_data" => "广告活动资料",
            "list" => "清单"
        ]
    ],
    "frontend" => [
        "auth" => [
            "disclaimer_checkbox" => "通过单击此复选框，您了解并同意我们的",
            "login_box_title" => "登录",
            "login_button" => "登录",
            "login_with" => "用 :social_media 登录",
            "register_box_title" => "寄存器",
            "register_button" => "寄存器",
            "remember_me" => "记住账号"
        ],
        "contact" => [
            "box_title" => "联系我们",
            "button" => "发送信息"
        ],
        "passwords" => [
            "expired_password_box_title" => "您的密码已过期。",
            "forgot_password" => "忘记密码了吗？",
            "reset_password_box_title" => "重设密码",
            "reset_password_button" => "重设密码",
            "send_password_reset_link_button" => "发送密码重置链接",
            "sub_label" => "你可以在这里重设密码。",
            "update_password_button" => "更新密码"
        ],
        "user" => [
            "passwords" => [
                "change" => "更改密码"
            ],
            "profile" => [
                "avatar" => "头像",
                "created_at" => "创建于",
                "edit_information" => "编辑信息",
                "email" => "电子邮件",
                "first_name" => "名字",
                "last_name" => "姓",
                "last_updated" => "最近更新时间",
                "name" => "名称",
                "update_information" => "更新资料"
            ]
        ]
    ],
    "general" => [
        "actions" => "动作",
        "active" => "活性",
        "all" => "所有",
        "buttons" => [
            "save" => "救",
            "update" => "更新资料"
        ],
        "copyright" => "版权",
        "custom" => "自订",
        "hide" => "隐藏",
        "inactive" => "不活跃",
        "more" => "动作",
        "no" => "没有",
        "none" => "没有",
        "show" => "节目",
        "toggle_navigation" => "切换导航",
        "yes" => "是"
    ]
];
=======
<?php

return [
    "backend" => [
        "access" => [
            "roles" => [
                "create" => "创建角色",
                "edit" => "编辑角色",
                "management" => "角色管理",
                "table" => [
                    "number_of_users" => "用户数",
                    "permissions" => "权限",
                    "role" => "角色",
                    "sort" => "分类",
                    "total" => "角色总数|角色总数"
                ]
            ],
            "users" => [
                "active" => "活跃用户",
                "all_permissions" => "所有权限",
                "change_password" => "更改密码",
                "change_password_for" => "更改用户密码：",
                "create" => "创建用户",
                "deactivated" => "停用的用户",
                "deleted" => "删除的用户",
                "edit" => "编辑使用者",
                "management" => "用户管理",
                "no_permissions" => "没有权限",
                "no_roles" => "没有角色可设置。",
                "permissions" => "权限",
                "table" => [
                    "confirmed" => "已确认",
                    "created" => "已建立",
                    "email" => "电子邮件",
                    "first_name" => "名字",
                    "id" => "ID",
                    "last_name" => "姓",
                    "last_updated" => "最近更新时间",
                    "name" => "名称",
                    "no_deactivated" => "没有停用的用户",
                    "no_deleted" => "没有已删除的用户",
                    "other_permissions" => "其他权限",
                    "permissions" => "权限",
                    "roles" => "的角色",
                    "social" => "社会的",
                    "total" => "用户总数|用户总数"
                ],
                "tabs" => [
                    "content" => [
                        "overview" => [
                            "avatar" => "头像",
                            "confirmed" => "已确认",
                            "created_at" => "创建于",
                            "deleted_at" => "删除于",
                            "email" => "电子邮件",
                            "first_name" => "名字",
                            "last_login_at" => "上次登录时间：",
                            "last_login_ip" => "上次登录IP",
                            "last_name" => "姓",
                            "last_updated" => "最近更新时间",
                            "name" => "名称",
                            "status" => "状态",
                            "timezone" => "时区"
                        ]
                    ],
                    "titles" => [
                        "history" => "历史",
                        "overview" => "总览"
                    ]
                ],
                "view" => "查看用户"
            ]
        ],
        "affiliate" => [
            "campaign" => "运动",
            "campaign_data" => "广告活动资料",
            "list" => "清单"
        ]
    ],
    "frontend" => [
        "auth" => [
            "disclaimer_checkbox" => "通过单击此复选框，您了解并同意我们的",
            "login_box_title" => "登录",
            "login_button" => "登录",
            "login_with" => "用 :social_media 登录",
            "register_box_title" => "寄存器",
            "register_button" => "寄存器",
            "remember_me" => "记住账号"
        ],
        "contact" => [
            "box_title" => "联系我们",
            "button" => "发送信息"
        ],
        "passwords" => [
            "expired_password_box_title" => "您的密码已过期。",
            "forgot_password" => "忘记密码了吗？",
            "reset_password_box_title" => "重设密码",
            "reset_password_button" => "重设密码",
            "send_password_reset_link_button" => "发送密码重置链接",
            "sub_label" => "你可以在这里重设密码。",
            "update_password_button" => "更新密码"
        ],
        "user" => [
            "passwords" => [
                "change" => "更改密码"
            ],
            "profile" => [
                "avatar" => "头像",
                "created_at" => "创建于",
                "edit_information" => "编辑信息",
                "email" => "电子邮件",
                "first_name" => "名字",
                "last_name" => "姓",
                "last_updated" => "最近更新时间",
                "name" => "名称",
                "update_information" => "更新资料"
            ]
        ]
    ],
    "general" => [
        "actions" => "动作",
        "active" => "活性",
        "all" => "所有",
        "buttons" => [
            "save" => "救",
            "update" => "更新资料"
        ],
        "copyright" => "版权",
        "custom" => "自订",
        "hide" => "隐藏",
        "inactive" => "不活跃",
        "more" => "动作",
        "no" => "没有",
        "none" => "没有",
        "show" => "节目",
        "toggle_navigation" => "切换导航",
        "yes" => "是"
    ]
];
>>>>>>> dev
