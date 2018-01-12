<?php

namespace modules\admin;

use WebComplete\core\entity\AbstractEntity;

abstract class AbstractMultilangEntity extends AbstractEntity
{
    /**
     * @var array
     */
    private $multilang = [];

    /**
     * @param string|null $field
     *
     * @return array
     */
    public function getMultilangData(string $field = null): array
    {
        if ($field) {
            return $this->multilang[$field] ?? [];
        }
        return $this->multilang;
    }

    /**
     * @param array $data
     */
    public function setMultilangData(array $data)
    {
        $this->multilang = $data;
    }

    /**
     * @return array
     */
    public function mapToArray(): array
    {
        $result = parent::mapToArray();
        $result['multilang'] = $this->getMultilangData();
        return $result;
    }

    /**
     * @param string $field
     * @param $value
     */
    public function set(string $field, $value)
    {
        if ($field === 'multilang') {
            $this->setMultilangData((array)$value);
        } else {
            parent::set($field, $value);
        }
    }
}
