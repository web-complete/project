<?php

namespace modules\admin\classes\filter;

use modules\admin\classes\fields\Field;
use WebComplete\core\condition\Condition;

class Filter
{
    const MODE_EQUAL = 1;
    const MODE_LIKE = 2;

    /**
     * @param string $title
     * @param string $name
     *
     * @param int $mode const MODE_EQUAL or MODE_LIKE
     *
     * @return FilterField
     */
    public static function string(string $title, string $name, int $mode = self::MODE_EQUAL): FilterField
    {
        return new FilterField(Field::string($title, $name), $mode);
    }

    /**
     * @param string $title
     * @param string $name
     * @param array $options
     *
     * @return FilterField
     */
    public static function select(string $title, string $name, array $options): FilterField
    {
        return new FilterField(Field::select($title, $name)->options($options), self::MODE_EQUAL);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FilterField
     */
    public static function boolean(string $title, string $name): FilterField
    {
        return new FilterField(Field::select($title, $name)
            ->options(['' => '', 0 => 'нет', 1 => 'да'])
            ->withEmpty(false)
            ->value(''), self::MODE_EQUAL);
    }

    /**
     * @param FilterField[] $filterFields
     * @param array $filter
     * @param Condition $condition
     */
    public static function parse(array $filterFields, array $filter, Condition $condition)
    {
        foreach ($filterFields as $filterField) {
            $filterName = $filterField->getName();
            if (isset($filter[$filterName])) {
                switch ($filterField->getMode()) {
                    case self::MODE_EQUAL:
                        $condition->addEqualsCondition($filterName, $filter[$filterName]);
                        break;
                    case self::MODE_LIKE:
                        $condition->addLikeCondition($filterName, $filter[$filterName]);
                        break;
                }
            }
        }
    }
}
