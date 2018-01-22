<?php

namespace cubes\multilang\translation\assets;

use WebComplete\mvc\assets\AbstractAsset;

class PubAsset extends AbstractAsset
{

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
        return [];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return [
            'js/translations.js',
        ];
    }
}
