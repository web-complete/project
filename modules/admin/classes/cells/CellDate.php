<?php

namespace modules\admin\classes\cells;

class CellDate extends CellAbstract
{

    protected $data = [
        'component' => 'VueCellDate',
        'cellParams' => [
            'dateFormat' => 'DD.MM.YYYY',
        ],
    ];

    /**
     * @param string $momentFormat
     *
     * @return $this
     */
    public function dateFormat(string $momentFormat = 'DD.MM.YYYY')
    {
        $this->data['cellParams']['dateFormat'] = $momentFormat;
        return $this;
    }
}
