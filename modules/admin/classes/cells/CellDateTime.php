<?php

namespace modules\admin\classes\cells;

class CellDateTime extends CellDate
{

    protected $data = [
        'component' => 'VueCellDateTime',
        'cellParams' => [
            'dateFormat' => 'DD.MM.YYYY',
            'timeFormat' => 'HH:mm:ss',
        ],
    ];

    /**
     * @param string $momentFormat
     *
     * @return $this
     */
    public function timeFormat(string $momentFormat = 'HH:mm:ss')
    {
        $this->data['cellParams']['timeFormat'] = $momentFormat;
        return $this;
    }
}
