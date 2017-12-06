<?php

namespace admin\assets;

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
            'css/normalize.css',
            'css/ionicons.min.css',
            'css/font-awesome.min.css',
            'css/admin/base.css',
            'css/admin/login.css',
            'css/admin/popup.css',
            'css/admin/theme.css',
        ];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return \array_merge(AdminAuthAsset::baseJs(), [
            'js/store/StoreNavigation.js',
            'js/vue/VueApp.js',
            'js/vue/VueHeader.js',
            'js/vue/VueFooter.js',
            'js/vue/VueNavigation.js',
            'js/vue/page/VuePageMain.js',
            'js/vue/page/VuePage404.js',
        ]);
    }
}
