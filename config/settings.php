<?php

use modules\admin\classes\fields\FieldFactory;

$fields = FieldFactory::build();

return [
    'sections' => [
        'common' => 'Основное',
        'examples' => 'Примеры',
        'system' => 'Система',
        'theme' => 'Оформление',
    ],
    'fields' => [
        'common' => [
            'site_name' => $fields->string('Название сайта', 'site_name'),
            'site_description' => $fields->string('Описание сайта', 'site_description'),
        ],
        'examples' => [
            'field_string' => $fields->string('string', 'field_string'),
            'field_string_disabled' => $fields->string('string disabled', 'field_string_disabled')
                ->disabled(),
            'field_string_filter' => $fields->string('string + filter num', 'field_string_filter')
                ->filter('^[0-9]*$'),
            'field_string_mask' => $fields->string('string + mask date + placeholder', 'field_string_mask')
                ->mask('00.00.0000')
                ->placeholder('дд.мм.гггг'),
            'field_checkbox1' => $fields->checkbox('checkbox 1', 'field_checkbox1'),
            'field_checkbox2' => $fields->checkbox('checkbox 2', 'field_checkbox2'),
            'field_select' => $fields->select('select', 'field_select')
                ->withEmpty(true)
                ->options([
                    1 => 'option 1',
                    2 => 'option 2',
                    3 => 'option 3',
                ]),
            'field_select_m' => $fields->select('select multiple', 'field_select_m')
                ->multiple(true)
                ->options([
                    1 => 'option 1',
                    2 => 'option 2',
                    3 => 'option 3',
                ]),
            'field_textarea' => $fields->textarea('textarea', 'field_textarea'),
            'field_redactor' => $fields->redactor('textarea redactor', 'field_redactor'),
            'field_image' => $fields->image('image', 'field_image')
                ->cropRatio(400/200),
            'field_images' => $fields->image('images', 'field_images')
                ->multiple(true),
        ],
        'system' => [
        ],
        'theme' => [
            'theme_logo' => $fields->file('Логотип', 'theme_logo'),
            'theme_color1' => $fields->string('Основной цвет', 'theme_color1')
                ->type('color')
                ->filter('^\#[0-9a-fA-F]*$')
                ->maxlength(7)
                ->placeholder('#F1A800')
                ->value('#F1A800'),
            'theme_color2' => $fields->string('Дополнительный цвет', 'theme_color2')
                ->type('color')
                ->filter('^\#[0-9a-fA-F]*$')
                ->maxlength(7)
                ->placeholder('#E77E15')
                ->value('#E77E15'),
        ],
    ],
];
