<?php

namespace modules\admin\classes\cells;

class Cell
{

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable \SORT_ASC, \SORT_DESC or null
     *
     * @return CellString
     */
    public static function string(string $label, string $name, int $sortable = null): CellString
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
    public static function checkbox(string $label, string $name, int $sortable = null): CellCheckbox
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
    public static function date(string $label, string $name, int $sortable = null): CellDate
    {
        return new CellDate($label, $name, $sortable);
    }

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable \SORT_ASC, \SORT_DESC or null
     *
     * @return CellSex
     */
    public static function sex(string $label, string $name, int $sortable = null): CellSex
    {
        return new CellSex($label, $name, $sortable);
    }
}
