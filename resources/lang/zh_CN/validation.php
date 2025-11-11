<<<<<<< HEAD
<?php

return [
    "accepted" => "：attribute必须被接受。",
    "active_url" => "：attribute不是有效的URL。",
    "after" => "：attribute必须是：date之后的日期。",
    "after_or_equal" => "：attribute必须是等于或小于：date的日期。",
    "alpha" => "：attribute只能包含字母。",
    "alpha_dash" => "：attribute只能包含字母，数字，破折号和下划线。",
    "alpha_num" => "：attribute只能包含字母和数字。",
    "array" => "：attribute必须是一个数组。",
    "attributes" => [
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "相关角色",
                    "dependencies" => "依存关系",
                    "display_name" => "显示名称",
                    "first_name" => "名字",
                    "group" => "组",
                    "group_sort" => "组排序",
                    "groups" => [
                        "name" => "组名"
                    ],
                    "last_name" => "姓",
                    "name" => "名称",
                    "system" => "系统"
                ],
                "roles" => [
                    "associated_permissions" => "相关权限",
                    "name" => "名称",
                    "sort" => "分类"
                ],
                "users" => [
                    "active" => "活性",
                    "associated_roles" => "相关角色",
                    "confirmed" => "已确认",
                    "email" => "电子邮件地址",
                    "first_name" => "名字",
                    "language" => "语言",
                    "last_name" => "姓",
                    "name" => "名称",
                    "other_permissions" => "其他权限",
                    "password" => "密码",
                    "password_confirmation" => "确认密码",
                    "send_confirmation_email" => "发送确认电子邮件",
                    "timezone" => "时区"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "头像位置",
            "email" => "电子邮件地址",
            "first_name" => "名字",
            "language" => "语言",
            "last_name" => "姓",
            "message" => "信息",
            "name" => "全名",
            "new_password" => "新密码",
            "new_password_confirmation" => "新密码确认",
            "old_password" => "旧密码",
            "password" => "密码",
            "password_confirmation" => "确认密码",
            "phone" => "电话",
            "timezone" => "时区"
        ]
    ],
    "before" => "：attribute必须是：date之前的日期。",
    "before_or_equal" => "：attribute必须是等于或小于：date的日期。",
    "between" => [
        "array" => "：attribute必须在：min和：max之间。",
        "file" => "：attribute必须介于：min和：max千字节之间。",
        "numeric" => "：attribute必须介于：min和：max之间。",
        "string" => "：attribute必须介于：min和：max之间。"
    ],
    "boolean" => "：attribute字段必须为true或false。",
    "confirmed" => "：attribute确认不匹配。",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "自定义消息"
        ]
    ],
    "date" => "：attribute不是有效日期。",
    "date_equals" => "：attribute必须是等于：date的日期。",
    "date_format" => "：attribute与格式：format不匹配。",
    "different" => "：attribute和：other必须不同。",
    "digits" => "：attribute必须为：digits位数。",
    "digits_between" => "：attribute必须介于：min和：max数字之间。",
    "dimensions" => "：attribute的图片尺寸无效。",
    "distinct" => "：attribute字段具有重复值。",
    "email" => "：attribute必须是有效的电子邮件地址。",
    "exists" => "所选的：attribute无效。",
    "file" => "：attribute必须是一个文件。",
    "filled" => "：attribute字段必须有一个值。",
    "gt" => [
        "array" => "：attribute必须包含多个：value项目。",
        "file" => "：attribute必须大于：value千字节。",
        "numeric" => "：attribute必须大于：value。",
        "string" => "：attribute必须大于：value字符。"
    ],
    "gte" => [
        "array" => "：attribute必须具有：value项或更多。",
        "file" => "：attribute必须大于或等于：value千字节。",
        "numeric" => "：attribute必须大于或等于：value。",
        "string" => "：attribute必须大于或等于：value字符。"
    ],
    "image" => "：attribute必须是图像。",
    "in" => "所选的：attribute无效。",
    "in_array" => "：attribute字段在：other中不存在。",
    "integer" => "：attribute必须为整数。",
    "ip" => "：attribute必须是有效的IP地址。",
    "ipv4" => "：attribute必须是有效的IPv4地址。",
    "ipv6" => "：attribute必须是有效的IPv6地址。",
    "json" => "：attribute必须是有效的JSON字符串。",
    "lt" => [
        "array" => "：attribute必须少于：value个项目。",
        "file" => "：attribute必须小于：value千字节。",
        "numeric" => "：attribute必须小于：value。",
        "string" => "：attribute必须小于：value字符。"
    ],
    "lte" => [
        "array" => "：attribute不得超过：value个项目。",
        "file" => "：attribute必须小于或等于：value千字节。",
        "numeric" => "：attribute必须小于或等于：value。",
        "string" => "：attribute必须小于或等于：value字符。"
    ],
    "max" => [
        "array" => "：attribute不能超过：max个项目。",
        "file" => "：attribute不得大于：max千字节。",
        "numeric" => "：attribute不得大于：max。",
        "string" => "：attribute不得大于：max个字符。"
    ],
    "mimes" => "：attribute必须是：values类型的文件。",
    "mimetypes" => "：attribute必须是类型：：values的文件。",
    "min" => [
        "array" => "：attribute必须至少包含：min个项目。",
        "file" => "：attribute必须至少为：min千字节。",
        "numeric" => "：attribute必须至少为：min。",
        "string" => "：attribute必须至少为：min个字符。"
    ],
    "not_in" => "所选的：attribute无效。",
    "not_regex" => "：attribute格式无效。",
    "numeric" => "：attribute必须为数字。",
    "present" => "：attribute字段必须存在。",
    "regex" => "：attribute格式无效。",
    "required" => "：attribute字段是必填字段。",
    "required_if" => "当：other是：value时，：attribute字段是必需的。",
    "required_unless" => "除非：other位于：values中，否则：attribute字段是必填字段。",
    "required_with" => "如果存在：values，则：attribute字段是必需的。",
    "required_with_all" => "存在：values时，：attribute字段是必需的。",
    "required_without" => "当：values不存在时，：attribute字段是必需的。",
    "required_without_all" => "当：values不存在时，：attribute字段是必需的。",
    "same" => "：attribute和：other必须匹配。",
    "size" => [
        "array" => "：attribute必须包含：size项。",
        "file" => "：attribute必须为：size千字节。",
        "numeric" => "：attribute必须为：size。",
        "string" => "：attribute必须为：size字符。"
    ],
    "starts_with" => "：attribute必须以下列之一开头：：values",
    "string" => "：attribute必须为字符串。",
    "timezone" => "：attribute必须是有效区域。",
    "unique" => "：attribute已经被使用。",
    "uploaded" => "：attribute上传失败。",
    "url" => "：attribute格式无效。",
    "uuid" => "：attribute必须是有效的UUID。"
];
=======
<?php

return [
    "accepted" => "：attribute必须被接受。",
    "active_url" => "：attribute不是有效的URL。",
    "after" => "：attribute必须是：date之后的日期。",
    "after_or_equal" => "：attribute必须是等于或小于：date的日期。",
    "alpha" => "：attribute只能包含字母。",
    "alpha_dash" => "：attribute只能包含字母，数字，破折号和下划线。",
    "alpha_num" => "：attribute只能包含字母和数字。",
    "array" => "：attribute必须是一个数组。",
    "attributes" => [
        "backend" => [
            "access" => [
                "permissions" => [
                    "associated_roles" => "相关角色",
                    "dependencies" => "依存关系",
                    "display_name" => "显示名称",
                    "first_name" => "名字",
                    "group" => "组",
                    "group_sort" => "组排序",
                    "groups" => [
                        "name" => "组名"
                    ],
                    "last_name" => "姓",
                    "name" => "名称",
                    "system" => "系统"
                ],
                "roles" => [
                    "associated_permissions" => "相关权限",
                    "name" => "名称",
                    "sort" => "分类"
                ],
                "users" => [
                    "active" => "活性",
                    "associated_roles" => "相关角色",
                    "confirmed" => "已确认",
                    "email" => "电子邮件地址",
                    "first_name" => "名字",
                    "language" => "语言",
                    "last_name" => "姓",
                    "name" => "名称",
                    "other_permissions" => "其他权限",
                    "password" => "密码",
                    "password_confirmation" => "确认密码",
                    "send_confirmation_email" => "发送确认电子邮件",
                    "timezone" => "时区"
                ]
            ]
        ],
        "frontend" => [
            "avatar" => "头像位置",
            "email" => "电子邮件地址",
            "first_name" => "名字",
            "language" => "语言",
            "last_name" => "姓",
            "message" => "信息",
            "name" => "全名",
            "new_password" => "新密码",
            "new_password_confirmation" => "新密码确认",
            "old_password" => "旧密码",
            "password" => "密码",
            "password_confirmation" => "确认密码",
            "phone" => "电话",
            "timezone" => "时区"
        ]
    ],
    "before" => "：attribute必须是：date之前的日期。",
    "before_or_equal" => "：attribute必须是等于或小于：date的日期。",
    "between" => [
        "array" => "：attribute必须在：min和：max之间。",
        "file" => "：attribute必须介于：min和：max千字节之间。",
        "numeric" => "：attribute必须介于：min和：max之间。",
        "string" => "：attribute必须介于：min和：max之间。"
    ],
    "boolean" => "：attribute字段必须为true或false。",
    "confirmed" => "：attribute确认不匹配。",
    "custom" => [
        "attribute-name" => [
            "rule-name" => "自定义消息"
        ]
    ],
    "date" => "：attribute不是有效日期。",
    "date_equals" => "：attribute必须是等于：date的日期。",
    "date_format" => "：attribute与格式：format不匹配。",
    "different" => "：attribute和：other必须不同。",
    "digits" => "：attribute必须为：digits位数。",
    "digits_between" => "：attribute必须介于：min和：max数字之间。",
    "dimensions" => "：attribute的图片尺寸无效。",
    "distinct" => "：attribute字段具有重复值。",
    "email" => "：attribute必须是有效的电子邮件地址。",
    "exists" => "所选的：attribute无效。",
    "file" => "：attribute必须是一个文件。",
    "filled" => "：attribute字段必须有一个值。",
    "gt" => [
        "array" => "：attribute必须包含多个：value项目。",
        "file" => "：attribute必须大于：value千字节。",
        "numeric" => "：attribute必须大于：value。",
        "string" => "：attribute必须大于：value字符。"
    ],
    "gte" => [
        "array" => "：attribute必须具有：value项或更多。",
        "file" => "：attribute必须大于或等于：value千字节。",
        "numeric" => "：attribute必须大于或等于：value。",
        "string" => "：attribute必须大于或等于：value字符。"
    ],
    "image" => "：attribute必须是图像。",
    "in" => "所选的：attribute无效。",
    "in_array" => "：attribute字段在：other中不存在。",
    "integer" => "：attribute必须为整数。",
    "ip" => "：attribute必须是有效的IP地址。",
    "ipv4" => "：attribute必须是有效的IPv4地址。",
    "ipv6" => "：attribute必须是有效的IPv6地址。",
    "json" => "：attribute必须是有效的JSON字符串。",
    "lt" => [
        "array" => "：attribute必须少于：value个项目。",
        "file" => "：attribute必须小于：value千字节。",
        "numeric" => "：attribute必须小于：value。",
        "string" => "：attribute必须小于：value字符。"
    ],
    "lte" => [
        "array" => "：attribute不得超过：value个项目。",
        "file" => "：attribute必须小于或等于：value千字节。",
        "numeric" => "：attribute必须小于或等于：value。",
        "string" => "：attribute必须小于或等于：value字符。"
    ],
    "max" => [
        "array" => "：attribute不能超过：max个项目。",
        "file" => "：attribute不得大于：max千字节。",
        "numeric" => "：attribute不得大于：max。",
        "string" => "：attribute不得大于：max个字符。"
    ],
    "mimes" => "：attribute必须是：values类型的文件。",
    "mimetypes" => "：attribute必须是类型：：values的文件。",
    "min" => [
        "array" => "：attribute必须至少包含：min个项目。",
        "file" => "：attribute必须至少为：min千字节。",
        "numeric" => "：attribute必须至少为：min。",
        "string" => "：attribute必须至少为：min个字符。"
    ],
    "not_in" => "所选的：attribute无效。",
    "not_regex" => "：attribute格式无效。",
    "numeric" => "：attribute必须为数字。",
    "present" => "：attribute字段必须存在。",
    "regex" => "：attribute格式无效。",
    "required" => "：attribute字段是必填字段。",
    "required_if" => "当：other是：value时，：attribute字段是必需的。",
    "required_unless" => "除非：other位于：values中，否则：attribute字段是必填字段。",
    "required_with" => "如果存在：values，则：attribute字段是必需的。",
    "required_with_all" => "存在：values时，：attribute字段是必需的。",
    "required_without" => "当：values不存在时，：attribute字段是必需的。",
    "required_without_all" => "当：values不存在时，：attribute字段是必需的。",
    "same" => "：attribute和：other必须匹配。",
    "size" => [
        "array" => "：attribute必须包含：size项。",
        "file" => "：attribute必须为：size千字节。",
        "numeric" => "：attribute必须为：size。",
        "string" => "：attribute必须为：size字符。"
    ],
    "starts_with" => "：attribute必须以下列之一开头：：values",
    "string" => "：attribute必须为字符串。",
    "timezone" => "：attribute必须是有效区域。",
    "unique" => "：attribute已经被使用。",
    "uploaded" => "：attribute上传失败。",
    "url" => "：attribute格式无效。",
    "uuid" => "：attribute必须是有效的UUID。"
];
>>>>>>> dev
