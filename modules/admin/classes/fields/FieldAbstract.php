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
     * @param string $error
     *
     * @return $this
     */
    public function error(string $error)
    {
        $this->data['error'] = $error;
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
     * @param bool $isMultilang
     *
     * @return $this
     */
    public function multilang(bool $isMultilang = true)
    {
        $this->data['fieldParams']['multilang'] = $isMultilang;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMultilang(): bool
    {
        return $this->data['fieldParams']['multilang'] ?? false;
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function multilangData(array $data)
    {
        if (!isset($this->data['fieldParams'])) {
            $this->data['fieldParams'] = [];
        }
        $this->data['fieldParams']['multilangData'] = $data;
        return $this;
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

    /**
     * @return null
     */
    public function processField()
    {
        return null;
    }
}
