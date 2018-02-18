<?php

namespace cubes\ecommerce\property\property;

use modules\admin\classes\fields\FieldAbstract;
use modules\admin\classes\fields\FieldFactory;

class PropertyFieldFactory
{
    /**
     * @var FieldFactory
     */
    protected $fieldFactory;

    /**
     * @param FieldFactory $fieldFactory
     */
    public function __construct(FieldFactory $fieldFactory)
    {
        $this->fieldFactory = $fieldFactory;
    }

    /**
     * @param PropertyAbstract $property
     *
     * @return \modules\admin\classes\fields\FieldString
     * @throws \RuntimeException
     */
    public function createField(PropertyAbstract $property): FieldAbstract
    {
        $field = null;
        switch ($property->type) {
            case 'string':
                $field = $this->fieldFactory->string($property->name, $property->code)->multilang();
                $field->multilangData($property->multilang ?? []);
                break;
            case 'enum':
                /** @var PropertyEnum $property */
                $options = $property->getOptions();
                $field = $this->fieldFactory->select($property->name, $property->code)->options($options);
                break;
            case 'bool':
                $field = $this->fieldFactory->checkbox($property->name, $property->code);
                break;
            case 'image':
                $field = $this->fieldFactory->image($property->name, $property->code);
                break;
            case 'images':
                $field = $this->fieldFactory->image($property->name, $property->code)->multiple(true);
                break;
        }

        if (!$field) {
            throw new \RuntimeException('Field for type not found: ' . $property->type);
        }

        $field->value($property->getValue());
        return $field;
    }
}
