<?php

namespace cubes\multilang\lang\classes;

use WebComplete\form\AbstractForm;

abstract class MultilangForm extends AbstractForm
{

    protected $multilang = [];
    protected $multilangErrors = [];

    /**
     * @param array $data
     *
     * @return AbstractForm|MultilangForm
     * @throws \WebComplete\form\FormException
     */
    public function setData(array $data)
    {
        $this->setMultilangData($data);
        parent::setData($data);
        return $this;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        $data = parent::getData();
        if ($this->multilang) {
            $data['multilang'] = $this->multilang;
        }
        return $data;
    }

    /**
     * @param array $data
     */
    public function setMultilangData(array $data)
    {
        $multilangData = (array)($data['multilang'] ?? []);
        unset($data['multilang']);

        $this->multilang = [];
        foreach ($multilangData as $langCode => $langData) {
            $this->multilang[$langCode] = $langData;
        }
    }

    /**
     * @return bool
     * @throws \WebComplete\form\FormException
     */
    public function validate(): bool
    {
        $result = $this->validateMultilang();
        return parent::validate() && $result;
    }

    /**
     * @return array
     */
    public function getMultilangErrors(): array
    {
        return $this->multilangErrors;
    }

    /**
     * @return bool
     * @throws \WebComplete\form\FormException
     */
    protected function validateMultilang(): bool
    {
        $result = true;
        $this->multilangErrors = [];
        if ($this->multilang) {
            foreach ((array)$this->multilang as $langCode => $langData) {
                $form = clone $this;
                $form->setData(\array_merge($this->data, $langData));
                $result &= $form->validate();
                foreach ($form->getFirstErrors() as $field => $error) {
                    if (!isset($this->multilangErrors[$field])) {
                        $this->multilangErrors[$field] = [];
                    }
                    $this->multilangErrors[$field][$langCode] = $error;
                }
            }
        }
        return $result;
    }
}
