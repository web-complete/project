<?php

namespace modules\admin\classes\filter;

use modules\admin\classes\fields\FieldFactory;
use WebComplete\core\condition\Condition;
use WebComplete\core\utils\container\ContainerInterface;

class FilterFactory
{
    const MODE_EQUAL = 1;
    const MODE_LIKE = 2;

    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var FieldFactory
     */
    protected $fieldFactory;

    /**
     * factory method
     *
     * @param ContainerInterface|null $container
     *
     * @return FilterFactory
     */
    public static function build(ContainerInterface $container = null): FilterFactory
    {
        if (!$container) {
            global $application;
            $container = $application->getContainer();
        }
        return $container->get(__CLASS__);
    }

    /**
     * @param ContainerInterface $container
     * @param FieldFactory $fieldFactory
     */
    public function __construct(ContainerInterface $container, FieldFactory $fieldFactory)
    {
        $this->container = $container;
        $this->fieldFactory = $fieldFactory;
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @param int $mode const MODE_EQUAL or MODE_LIKE
     *
     * @return FilterField
     */
    public function string(string $title, string $name, int $mode = self::MODE_EQUAL): FilterField
    {
        return new FilterField($this->fieldFactory->string($title, $name), $mode);
    }

    /**
     * @param string $title
     * @param string $name
     * @param array $options
     *
     * @return FilterField
     */
    public function select(string $title, string $name, array $options): FilterField
    {
        return new FilterField($this->fieldFactory->select($title, $name)->options($options), self::MODE_EQUAL);
    }

    /**
     * @param string $title
     * @param string $name
     *
     * @return FilterField
     */
    public function boolean(string $title, string $name): FilterField
    {
        return new FilterField($this->fieldFactory->select($title, $name)
            ->options(['' => '', 0 => 'нет', 1 => 'да'])
            ->withEmpty(false)
            ->value(''), self::MODE_EQUAL);
    }

    /**
     * @param FilterField[] $filterFields
     * @param array $filter
     * @param Condition $condition
     */
    public function parse(array $filterFields, array $filter, Condition $condition)
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
