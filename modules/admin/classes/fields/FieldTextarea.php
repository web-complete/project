<?php

namespace modules\admin\classes\fields;

class FieldTextarea extends FieldAbstract
{

    protected $data = [
        'component' => 'VueFieldTextarea',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'disabled' => false,
            'rows' => 15,
            'maxlength' => '',
            'placeholder' => '',
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
     * @param bool $isDisabled
     *
     * @return $this
     */
    public function disabled(bool $isDisabled = true)
    {
        $this->data['fieldParams']['disabled'] = $isDisabled;
        return $this;
    }

    /**
     * @param int $maxlength
     *
     * @return $this
     */
    public function maxlength(int $maxlength)
    {
        $this->data['fieldParams']['maxlength'] = $maxlength;
        return $this;
    }

    /**
     * @param int $rows
     *
     * @return $this
     */
    public function rows(int $rows)
    {
        $this->data['fieldParams']['rows'] = $rows;
        return $this;
    }

    /**
     * @param string $placeholder
     *
     * @return $this
     */
    public function placeholder(string $placeholder)
    {
        $this->data['fieldParams']['placeholder'] = $placeholder;
        return $this;
    }
}
