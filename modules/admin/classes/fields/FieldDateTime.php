<?php

namespace modules\admin\classes\fields;

class FieldDateTime extends FieldString
{

    protected $format = 'd.m.Y H:i:s';

    /**
     * @param $title
     * @param $name
     */
    public function __construct($title, $name)
    {
        parent::__construct($title, $name);
        $this->component('VueFieldDateTime');
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
