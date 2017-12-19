<?php

namespace modules\admin\classes\fields;

class FieldString extends FieldAbstract
{

    protected $data = [
        'component' => 'VueFieldString',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'type' => 'text',
            'disabled' => false,
            'maxlength' => '',
            'placeholder' => '',
            'filter' => '',
            'mask' => '',
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
     * @param string $type
     *
     * @return $this
     */
    public function type(string $type)
    {
        $this->data['fieldParams']['type'] = $type;
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
     * @param string $placeholder
     *
     * @return $this
     */
    public function placeholder(string $placeholder)
    {
        $this->data['fieldParams']['placeholder'] = $placeholder;
        return $this;
    }

    /**
     * @param string $filter Example: '^[0-9]*$'
     *
     * @return $this
     */
    public function filter(string $filter)
    {
        $this->data['fieldParams']['filter'] = \trim($filter, '~/#');
        return $this;
    }

    /**
     * @param string $mask
     *
     * @return $this
     */
    public function mask(string $mask)
    {
        $this->data['fieldParams']['mask'] = $mask;
        return $this;
    }
}
