<?php

return [
    'permissions' => [
        'admin' => [
            'admin:login',
            'admin:content' => [
                'admin:content:article' => [
                    'admin:content:article:view',
                    'admin:content:article:edit',
                ],
            ]
        ]
    ],
    'roles' => [
        'admin' => ['admin'],
        'manager' => ['admin:login', 'admin:content'],
    ]
];

return [
    'permissions' => [
        'admin' => [
            'description' => 'Полное администрирование',
            'permissions' => [
                'admin:login' => ['description' => 'Вход в административную панель'],
                'content' => ['description' => 'Управление контентом'],
            ],
        ],
    ],
    'roles' => [
        'admin' => [
            'description' => 'Администратор',
            'permissions' => [],
        ],
        'manager' => [
            'description' => 'Контент-менеджер',
            'permissions' => [],
        ]
    ],
];
