<?php

return [
    'platform_database_list' => '站臺資料庫列表',
    'platform_setting'       => '站臺設定',
    'create_database'        => '新增站臺',
    'name'                   => '站臺名稱',
    'db_name'                => '資料庫名稱',
    'redis_database'         => 'redis資料庫',

    'status'       => '狀態',
    'status_types' => [
        'enable'  => '啟用',
        'disable' => '停用',
    ],

    'note'    => '備註',
    'operate' => '操作',
    'return'  => '返回',
    'create'  => '新增',
    'edit'    => '修改',
    'delete'  => '刪除',

    'kick_member_all' => '剔除各平台所有會員下線',
    'toggle_maintain' => [
        0 => '開啟所有平台維護',
        1 => '停止所有平台維護',
    ],

    'toggle_api_key' => [
        'enable'  => '開啟鎖定各平台apiKey',
        'disable' => '停止鎖定各平台apiKey',
    ],

    'alert' => [
        'kick_member_all_title'  => '是否確定剔除各平台所有會員下線?',
        'enable_maintain_title'  => '是否確定啟用所有平台維護?',
        'disable_maintain_title' => '是否確定停止所有平台維護?',
        'enable_api_key_title'   => '是否確定啟用所有平台鎖定apiKey?',
        'disable_api_key_title'  => '是否確定停止所有平台鎖定apiKey?',
    ]
];