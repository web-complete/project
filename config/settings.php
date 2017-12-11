<?php

use modules\admin\classes\fields\Field;

return [
    'sections' => [
        'common' => 'Основное',
        'examples' => 'Примеры',
        'system' => 'Система',
        'theme' => 'Оформление',
    ],
    'fields' => [
        'common' => [
            'site_name' => Field::string('Название сайта', 'site_name'),
            'site_description' => Field::string('Описание сайта', 'site_description'),
        ],
        'examples' => [
            'field_string' => Field::string('string', 'field_string'),
            'field_string_disabled' => Field::string('string disabled', 'field_string_disabled')
                ->disabled(),
            'field_string_filter' => Field::string('string + filter num', 'field_string_filter')
                ->filter('^[0-9]*$'),
            'field_string_mask' => Field::string('string + mask date + placeholder', 'field_string_mask')
                ->mask('00.00.0000')
                ->placeholder('дд.мм.гггг'),
            'field_checkbox1' => Field::checkbox('checkbox 1', 'field_checkbox1'),
            'field_checkbox2' => Field::checkbox('checkbox 2', 'field_checkbox2'),
            'field_select' => Field::select('select', 'field_select')
                ->withEmpty(true)
                ->options([
                    1 => 'option 1',
                    2 => 'option 2',
                    3 => 'option 3',
                ]),
            'field_select_m' => Field::select('select multiple', 'field_select_m')
                ->multiple(true)
                ->options([
                    1 => 'option 1',
                    2 => 'option 2',
                    3 => 'option 3',
                ]),
            'field_textarea' => Field::textarea('textarea', 'field_textarea'),
            'field_redactor' => Field::redactor('textarea redactor', 'field_redactor'),
            'field_image' => Field::image('image', 'field_image'),
            'field_images' => Field::image('images', 'field_images')
                ->multiple(true),
        ],
        'system' => [
        ],
        'theme' => [
            'theme_logo' => Field::file('Логотип', 'theme_logo'),
            'theme_color1' => Field::string('Основной цвет', 'theme_color1')
                ->type('color')
                ->filter('^\#[0-9a-fA-F]*$')
                ->maxlength(7)
                ->placeholder('#F1A800')
                ->value('#F1A800'),
            'theme_color2' => Field::string('Дополнительный цвет', 'theme_color2')
                ->type('color')
                ->filter('^\#[0-9a-fA-F]*$')
                ->maxlength(7)
                ->placeholder('#E77E15')
                ->value('#E77E15'),
        ],
    ],
];
