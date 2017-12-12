<?php

namespace modules\admin\classes\cells;

abstract class CellAbstract
{

    protected $data = [];

    /**
     * @param string $label
     * @param string $name
     * @param int $sortable
     */
    public function __construct(string $label, string $name, $sortable = \SORT_ASC)
    {
        $isSortable = false;
        if ($sortable) {
            $isSortable = $sortable === \SORT_DESC ? 'desc' : 'asc';
        }
        $this->data['label'] = $label;
        $this->data['name'] = $name;
        $this->data['sortable'] = $isSortable;
    }

    /**
     * @return array
     */
    public function get(): array
    {
        return $this->data;
    }
}
