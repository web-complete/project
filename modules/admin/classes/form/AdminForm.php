<?php

namespace modules\admin\classes\form;

use cubes\multilang\lang\classes\MultilangForm;

class AdminForm extends MultilangForm
{
    const MESSAGE_REQUIRED = 'Поле обязательно для заполнения';
    const MESSAGE_NUMBER = 'Значение должно быть числом';
    const MESSAGE_NUMBER_INT = 'Значение должно быть целым числом';
    const MESSAGE_INCORRECT = 'Поле заполнено некорректно';
    const MESSAGE_NOT_UNIQUE = 'Такое значение уже существует';
    const MESSAGE_NOT_EXISTS = 'Значение не найдено';

    /**
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
}
