<?php

namespace modules\pub\assets;

use WebComplete\mvc\assets\AbstractAsset;

class BaseAsset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/BaseAsset';
    }

    /**
     * @return array
     */
    public function css(): array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return [
            'js/jquery-3.2.1.min.js',
        ];
    }
}
