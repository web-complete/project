<?php

namespace modules\admin\classes\fields;

class FieldImage extends FieldFile
{

    protected $data = [
        'component' => 'VueFieldImage',
        'name' => '',
        'title' => '',
        'value' => '',
        'fieldParams' => [
            'data' => [],
            'multiple' => false
        ]
    ];

    /**
     * @param bool $isMultiple
     *
     * @return $this
     */
    public function multiple(bool $isMultiple)
    {
        $this->data['fieldParams']['multiple'] = $isMultiple;
        return $this;
    }
}
