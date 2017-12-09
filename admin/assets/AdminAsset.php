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
            'bower_components/vue-toasted/dist/vue-toasted.min.css',
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
            'bower_components/vue-top-progress/dist/vue-top-progress.min.js',
            'bower_components/vue-toasted/dist/vue-toasted.min.js',
            'bower_components/vue-js-modal/dist/index.js',
            'js/lib/sticky-kit.min.js',
            'js/lib/imask.min.js',
            'js/store/StoreNavigation.js',

            'js/model/FieldHelper.js',
            'js/model/Notify.js',
            'js/model/Modal.js',

            'js/vue/ui/VueTabs.js',
            'js/vue/ui/VueTab.js',
            'js/vue/ui/VueFieldString.js',
            'js/vue/ui/VueButton.js',

            'js/vue/VueApp.js',
            'js/vue/VueHeader.js',
            'js/vue/VueFooter.js',
            'js/vue/VueNavigation.js',

            'js/vue/page/VuePageMain.js',
            'js/vue/page/VuePage404.js',
        ]);
    }
}
