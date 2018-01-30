<?php

namespace cubes\content\staticBlock\assets;

use WebComplete\mvc\assets\AbstractAsset;

class AdminAsset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/AdminAsset';
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
            'js/VuePageStaticBlockList.js',
            'js/VuePageStaticBlockDetail.js',
        ];
    }
}
