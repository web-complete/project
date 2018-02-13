<?php

return [
    'permissions' => [
        'admin' => [
            'description' => 'Полное администрирование',
            'permissions' => [
                'admin:login' => ['description' => 'Вход в CMS'],
                'admin:cubes' => ['description' => 'Управление в CMS'],
            ],
        ],
    ],
    'roles' => [
        'admin' => [
            'description' => 'Администратор',
            'permissions' => ['admin:login', 'admin:cubes:user:view', 'admin:cubes:user:edit'],
        ],
        'manager' => [
            'description' => 'Контент-менеджер',
            'permissions' => ['admin:login'],
        ],
        'user' => [
            'description' => 'Пользователь',
            'permissions' => [],
        ]
    ],
];
