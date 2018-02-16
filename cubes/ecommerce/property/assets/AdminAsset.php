<?php

namespace cubes\ecommerce\property\assets;

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
        return [
            'css/style.css',
        ];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return [
            'js/VueEcommercePropertyEnumPopup.js',
            'js/VueEcommercePropertyItem.js',
            'js/VueEcommercePropertyList.js',
            'js/VuePageEcommerceProperty.js',
        ];
    }
}
