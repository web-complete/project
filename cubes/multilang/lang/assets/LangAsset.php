<?php

namespace cubes\multilang\lang\assets;

use WebComplete\mvc\assets\AbstractAsset;

class LangAsset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/LangAsset';
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
            'js/VuePageLangDetail.js',
        ];
    }
}
