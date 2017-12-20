<?php

namespace modules\admin\classes\fields;

class FieldDate extends FieldString
{

    protected $format = 'd.m.Y';

    /**
     * @param $title
     * @param $name
     */
    public function __construct($title, $name)
    {
        parent::__construct($title, $name);
        $this->component('VueFieldDate');
    }

    /**
     * @param string $format
     */
    public function parseFormat(string $format)
    {
        $this->format = $format;
    }

    /**
     */
    public function processField()
    {
        $value = $this->getValue();
        $value = $value ? \date($this->format, \strtotime($value)) : '';
        $this->value($value);
    }
}
