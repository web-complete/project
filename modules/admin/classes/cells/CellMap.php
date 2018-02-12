<?php

namespace modules\admin\classes\cells;

class CellMap extends CellAbstract
{

    protected $data = [
        'component' => 'VueCellMap',
        'cellParams' => [
            'map' => [],
        ],
    ];

    /**
     * @param string $label
     * @param string $name
     * @param array $map
     * @param int $sortable
     */
    public function __construct(string $label, string $name, array $map, $sortable = \SORT_ASC)
    {
        $this->data['cellParams']['map'] = $map;
        parent::__construct($label, $name, $sortable);
    }
}
