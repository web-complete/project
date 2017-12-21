<?php

namespace modules\admin\classes\cells;

use WebComplete\core\utils\container\ContainerInterface;

class CellFactory
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * factory method
     *
     * @param ContainerInterface|null $container
     *
     * @return CellFactory
     */
    public static function build(ContainerInterface $container = null): CellFactory
    {
        if (!$container) {
            global $application;
            $container = $application->getContainer();
        }
        return $container->get(__CLASS__);
    }

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable \SORT_ASC, \SORT_DESC or null
     *
     * @return CellString
     */
    public function string(string $label, string $name, int $sortable = null): CellString
    {
        return new CellString($label, $name, $sortable);
    }

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable \SORT_ASC, \SORT_DESC or null
     *
     * @return CellCheckbox
     */
    public function checkbox(string $label, string $name, int $sortable = null): CellCheckbox
    {
        return new CellCheckbox($label, $name, $sortable);
    }

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable \SORT_ASC, \SORT_DESC or null
     *
     * @return CellDate
     */
    public function date(string $label, string $name, int $sortable = null): CellDate
    {
        return new CellDate($label, $name, $sortable);
    }

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable \SORT_ASC, \SORT_DESC or null
     *
     * @return CellDateTime
     */
    public function dateTime(string $label, string $name, int $sortable = null): CellDateTime
    {
        return new CellDateTime($label, $name, $sortable);
    }

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable \SORT_ASC, \SORT_DESC or null
     *
     * @return CellSex
     */
    public function sex(string $label, string $name, int $sortable = null): CellSex
    {
        return new CellSex($label, $name, $sortable);
    }
}
