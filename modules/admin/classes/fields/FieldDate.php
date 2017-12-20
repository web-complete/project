<?php

namespace modules\admin\classes\fields;

class FieldDate extends FieldString
{

    protected $format = 'Y-m-d';

    public function parseFormat(string $format)
    {
        $this->format = $format;
    }

    public function processField()
    {
        $value = $this->getValue();
        $this->value($value);
    }

    public function getProcessedValue()
    {
        return '11.11.1111';
    }
}
