<?php

namespace modules\admin\classes\fields;

abstract class FieldAbstract
{

    protected $data = [];

    /**
     * @param string $component
     *
     * @return $this
     */
    public function component(string $component)
    {
        $this->data['component'] = $component;
        return $this;
    }

    /**
     * @param $value
     *
     * @return $this
     */
    public function value($value)
    {
        $this->data['value'] = $value;
        return $this;
    }

    /**
     * @return mixed|null
     */
    public function getValue()
    {
        return $this->data['value'] ?? null;
    }

    /**
     * @return mixed|null
     */
    public function getProcessedValue()
    {
        return $this->getValue();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->data['name'];
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->data;
    }

    public function processField()
    {

    }
}
