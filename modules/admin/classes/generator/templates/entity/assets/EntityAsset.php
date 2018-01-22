<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>


namespace <?=$config->namespace ?>\assets;

use WebComplete\mvc\assets\AbstractAsset;

class <?=$config->nameCamel ?>Asset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/<?=$config->nameCamel ?>Asset';
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
            'js/VuePage<?=$config->nameCamel ?>List.js',
            'js/VuePage<?=$config->nameCamel ?>Detail.js',
        ];
    }
}
