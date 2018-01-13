<?php

namespace modules\admin\classes\form;

use WebComplete\form\AbstractForm;

class AdminForm extends AbstractForm
{

    const MESSAGE_REQUIRED = 'Поле обязательно для заполнения';
    const MESSAGE_NUMBER = 'Значение должно быть числом';
    const MESSAGE_NUMBER_INT = 'Значение должно быть целым числом';
    const MESSAGE_INCORRECT = 'Поле заполнено некорректно';
    const MESSAGE_NOT_UNIQUE = 'Такое значение уже существует';
    const MESSAGE_NOT_EXISTS = 'Значение не найдено';

    protected $multilang = [];
    protected $multilangErrors = [];

    /**
     * FastForm constructor.
     *
     * @param array $rules
     * @param array $filters
     * @param $validatorsObject
     * @param $filtersObject
     */
    public function __construct($rules = [], $filters = [], $validatorsObject = null, $filtersObject = null)
    {
        parent::__construct(
            $rules,
            $filters,
            $validatorsObject ?? new AdminValidators(),
            $filtersObject ?? new AdminFilters()
        );
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return array
     */
    public function filters(): array
    {
        return [];
    }

    /**
     * @param array $data
     *
     * @return AbstractForm|AdminForm
     * @throws \WebComplete\form\FormException
     */
    public function setData(array $data)
    {
        parent::setData($data);
        $this->multilang = [];
        if (isset($data['multilang'])) {
            $multilangData = (array)$data['multilang'];
            unset($data['multilang']);
            foreach ($multilangData as $langCode => $langData) {
                $this->multilang[$langCode] = \array_merge($data, $langData);
            }
        }
        return $this;
    }

    /**
     * @return bool
     * @throws \WebComplete\form\FormException
     */
    public function validate(): bool
    {
        $this->multilangErrors = [];
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
        if ($this->multilang) {
            foreach ((array)$this->multilang as $langCode => $langData) {
                $form = clone $this;
                $form->setData($langData);
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
