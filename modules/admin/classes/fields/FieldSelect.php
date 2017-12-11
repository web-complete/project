<?php

namespace modules\admin\classes\fields;

class FieldSelect extends FieldAbstract
{

    protected $data = [
        'component' => 'VueFieldSelect',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'withEmpty' => true,
            'disabled' => false,
            'multiple' => false,
            'options' => [],
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
     * @param bool $isMultiple
     *
     * @return $this
     */
    public function multiple(bool $isMultiple = true)
    {
        $this->data['fieldParams']['multiple'] = $isMultiple;
        return $this;
    }

    /**
     * @param bool $withEmpty
     *
     * @return $this
     */
    public function withEmpty(bool $withEmpty = true)
    {
        $this->data['fieldParams']['withEmpty'] = $withEmpty;
        return $this;
    }

    /**
     * @param array $options
     *
     * @return $this
     */
    public function options(array $options)
    {
        $this->data['fieldParams']['options'] = $options;
        return $this;
    }
}
