<?php

return [
    'email' => [
        'is_unique' => '邮箱地址已被使用'
    ],
    'password_confirmation' => [
        'required' => '请确认密码',
        'matches' => '请再次输入相同的密码'
    ]
];
