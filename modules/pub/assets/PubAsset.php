<?php

namespace modules\pub\assets;

use WebComplete\mvc\assets\AbstractAsset;

class PubAsset extends AbstractAsset
{

    public $publish = false;

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/PubAsset';
    }

    /**
     * @return array
     */
    public function css(): array
    {
        return [
            'css/normalize.css',
            'css/style.css',
        ];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return [
        ];
    }
}
