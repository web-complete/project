<?php

use admin\classes\FieldType;

return [
    'sections' => [
        'common' => 'Основное',
        'system' => 'Система',
    ],
    'data' => [
        'common' => [
            'field_string' => [
                'title' => 'string',
                'field' => FieldType::STRING,
                'fieldParams' => [],
                'value' => '',
            ],
            'field_string_filter' => [
                'title' => 'string + filter num',
                'field' => FieldType::STRING,
                'fieldParams' => [
                    'filter' => '^[0-9]*$'
                ],
                'value' => '',
            ],
            'field_string_mask' => [
                'title' => 'string + mask date + placeholder',
                'field' => FieldType::STRING,
                'fieldParams' => [
                    'mask' => '00.00.0000',
                    'placeholder' => 'дд.мм.гггг'
                ],
                'value' => '',
            ],
        ],
        'system' => [
        ],
    ],
];
