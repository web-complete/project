<?php

namespace modules\admin\classes\fields;

class FieldCheckbox extends FieldAbstract
{

    protected $data = [
        'component' => 'VueFieldCheckbox',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'disabled' => false,
        ]
    ];

    /**
     * @param $title
     * @param $name
     */
    public function __construct($title, $name)
    {
        $this->data['title'] = $title;
        $this->data['name'] = $name;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function value($value)
    {
        $this->data['value'] = (int)$value;
        return $this;
    }

    /**
     * @param bool $isDisabled
     *
     * @return $this
     */
    public function disabled(bool $isDisabled = true)
    {
        $this->data['fieldParams']['disabled'] = $isDisabled;
        return $this;
    }
}
