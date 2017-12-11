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
            'multiple' => false,
            'cropRatio' => false,
            'cropMimeType' => 'image/jpeg',
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

    /**
     * @param float $ratio
     *
     * @param string $cropMimeType
     *
     * @return $this
     */
    public function cropRatio(float $ratio, string $cropMimeType = 'image/jpeg')
    {
        $this->data['fieldParams']['cropRatio'] = $ratio;
        $this->data['fieldParams']['cropMimeType'] = $cropMimeType;
        return $this;
    }
}
