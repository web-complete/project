<?php

namespace modules\admin\classes\fields;

class FieldHtml extends FieldTextarea
{

    protected $data = [
        'component' => 'VueFieldHtml',
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
