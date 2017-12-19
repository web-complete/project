<?php

namespace cubes\system\roles\assets;

use WebComplete\mvc\assets\AbstractAsset;

class RolesAsset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/RolesAsset';
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
            'js/VuePageRolesList.js',
            'js/VuePageRolesDetail.js',
        ];
    }
}
