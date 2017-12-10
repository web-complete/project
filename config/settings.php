<?php

use modules\admin\classes\FieldType;

return [
    'sections' => [
        'common' => 'Основное',
        'examples' => 'Примеры',
        'system' => 'Система',
        'theme' => 'Оформление',
    ],
    'data' => [
        'common' => [
            'site_name' => [
                'title' => 'Название сайта',
                'field' => FieldType::STRING,
                'value' => '',
            ],
            'site_description' => [
                'title' => 'Описание сайта',
                'field' => FieldType::STRING,
                'value' => '',
            ],
            'file' => [
                'title' => 'file',
                'field' => FieldType::FILE,
                'value' => '',
            ],
        ],
        'examples' => [
            'field_string' => [
                'title' => 'string',
                'field' => FieldType::STRING,
                'value' => '',
            ],
            'field_string_disabled' => [
                'title' => 'string disabled',
                'field' => FieldType::STRING,
                'fieldParams' => [
                    'disabled' => true,
                ],
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
            'field_checkbox1' => [
                'title' => 'checkbox 1',
                'field' => FieldType::CHECKBOX,
                'value' => 0,
            ],
            'field_checkbox2' => [
                'title' => 'checkbox 2',
                'field' => FieldType::CHECKBOX,
                'value' => 0,
            ],
            'field_select' => [
                'title' => 'select',
                'field' => FieldType::SELECT,
                'fieldParams' => [
                    'withEmpty' => true,
                    'options' => [
                        1 => 'option 1',
                        2 => 'option 2',
                        3 => 'option 3',
                    ]
                ],
                'value' => '',
            ],
            'field_select_m' => [
                'title' => 'select multiple',
                'field' => FieldType::SELECT,
                'fieldParams' => [
                    'multiple' => true,
                    'options' => [
                        1 => 'option 1',
                        2 => 'option 2',
                        3 => 'option 3',
                    ]
                ],
                'value' => '',
            ],
            'field_textarea' => [
                'title' => 'textarea',
                'field' => FieldType::TEXTAREA,
                'value' => '',
            ],
            'field_redactor' => [
                'title' => 'textarea redactor',
                'field' => FieldType::REDACTOR,
                'fieldParams' => [],
                'value' => '',
            ],
        ],
        'system' => [
        ],
        'theme' => [
            'theme_color1' => [
                'title' => 'Основной цвет',
                'field' => FieldType::STRING,
                'fieldParams' => [
                    'filter' => '^[0-9a-fA-F]*$',
                    'maxlength' => 6,
                    'placeholder' => 'F1A800',
                ],
                'value' => 'F1A800',
            ],
            'theme_color2' => [
                'title' => 'Дополнительный цвет',
                'field' => FieldType::STRING,
                'fieldParams' => [
                    'filter' => '^[0-9a-fA-F]*$',
                    'maxlength' => 6,
                    'placeholder' => 'E77E15',
                ],
                'value' => 'E77E15',
            ],
        ],
    ],
];
