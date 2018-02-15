<?php

namespace modules\admin\classes\fields;

use cubes\system\multilang\lang\classes\AbstractMultilangEntity;
use WebComplete\core\entity\AbstractEntity;

class FieldService
{

    /**
     * @param FieldAbstract[] $detailFields
     * @param AbstractEntity $item
     *
     * @return array
     */
    public function populateEntityFields(array $detailFields, AbstractEntity $item): array
    {
        $result = [];
        /** @var AbstractMultilangEntity $item */
        $isMultilang = $item instanceof AbstractMultilangEntity;
        foreach ($detailFields as $field) {
            if ($isMultilang && $field->isMultilang()) {
                $field->multilangData($item->getMultilangData($field->getName()));
            }
            $field->value($this->getNestedValue($item, $field->getName()));
            $field->processField();
            $result[] = $field->get();
        }
        return $result;
    }

    /**
     * Fetch nested field value by "dot delimiter".
     * Example: "preferences.user.property1" will fetch: $entity->preferences['user']['property1']
     *
     * @param AbstractEntity $item
     * @param string $field
     *
     * @return mixed|null
     */
    protected function getNestedValue(AbstractEntity $item, string $field)
    {
        $path = \explode('.', $field);
        $node = \array_shift($path);
        $nodeValue = $item->get($node);
        if ($path && \is_array($nodeValue)) {
            foreach ($path as $node) {
                $nodeValue = $nodeValue[$node] ?? null;
                if (!$nodeValue || !\is_array($nodeValue)) {
                    break;
                }
            }
        }
        return $nodeValue;
    }
}
