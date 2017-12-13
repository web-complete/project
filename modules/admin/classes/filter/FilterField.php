<?php

namespace modules\admin\classes\filter;

use modules\admin\classes\fields\FieldAbstract;

class FilterField
{
    /**
     * @var FieldAbstract
     */
    protected $field;
    /**
     * @var int
     */
    protected $mode;

    /**
     * @param FieldAbstract $field
     * @param int $mode
     */
    public function __construct(FieldAbstract $field, int $mode)
    {
        $this->field = $field;
        $this->mode = $mode;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->field->getName();
    }

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->field->get();
    }
}
