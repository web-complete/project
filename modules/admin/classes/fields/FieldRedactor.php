<?php

namespace modules\admin\classes\fields;

class FieldRedactor extends FieldTextarea
{

    protected $data = [
        'component' => 'VueFieldRedactor',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'disabled' => false,
            'maxlength' => '',
            'placeholder' => '',
        ]
    ];
}
