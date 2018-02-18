<?php

namespace cubes\system\multilang\lang\classes;

use WebComplete\core\entity\AbstractEntity;

abstract class AbstractMultilangEntity extends AbstractEntity
{
    /**
     * @var array
     */
    private $multilang = [];
    private $currentLangCode;

    /**
     * @param string $code
     *
     * @return $this|AbstractMultilangEntity
     */
    public function setLang(string $code = null)
    {
        $this->currentLangCode = $code;
        return $this;
    }

    /**
     * @param string|null $field
     *
     * @return array
     */
    public function getMultilangData(string $field = null): array
    {
        if ($field) {
            $result = [];
            foreach ($this->multilang as $langCode => $langData) {
                $result[$langCode] = $langData[$field] ?? null;
            }
            return $result;
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
     * @param null $default
     *
     * @return mixed|null
     */
    public function get(string $field, $default = null)
    {
        if ($this->currentLangCode) {
            return $this->multilang[$this->currentLangCode][$field] ?? parent::get($field, $default);
        }
        return parent::get($field, $default);
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
