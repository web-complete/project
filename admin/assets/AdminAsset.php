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
        return [
            \ENV === 'prod' ? 'js/lib/vue.min.js' : 'js/lib/vue.js',
            'js/lib/vue-router.js',
            'js/lib/vuex.js',
            'js/lib/jquery-3.2.1.min.js',
            'node_modules/underscore/underscore-min.js',
            'js/store/StoreUser.js',
            'js/store/vuex.js',
            'js/model/App.js',
            'js/model/Request.js',
            'js/vue/VueApp.js',
            'js/vue/VuePageLogin.js',
        ];
    }
}
