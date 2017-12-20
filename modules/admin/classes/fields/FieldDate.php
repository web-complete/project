<?php

namespace modules\admin\classes\fields;

class FieldDate extends FieldString
{

    protected $format = 'd.m.Y';

    public function parseFormat(string $format)
    {
        $this->format = $format;
    }

    public function processField()
    {
        $value = $this->getValue();
        $value = $value ? \date($this->format, \strtotime($value)) : '';
        $this->value($value);
    }
}
