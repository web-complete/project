<?php

namespace cubes\system\settings\assets;

use WebComplete\mvc\assets\AbstractAsset;

class SettingsAsset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/SettingsAsset';
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
            'js/VuePageSettings.js',
        ];
    }
}