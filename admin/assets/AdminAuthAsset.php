<?php

namespace admin\assets;

use WebComplete\mvc\assets\AbstractAsset;

class AdminAuthAsset extends AbstractAsset
{

    /**
     * @return array
     */
    public static function baseJs()
    {
        return [
            'js/lib/jquery-3.2.1.min.js',
            \ENV === 'prod' ? 'node_modules/vue/dist/vue.min.js' : 'node_modules/vue/dist/vue.js',
            'node_modules/vuex/dist/vuex.min.js',
            'node_modules/vue-router/dist/vue-router.min.js',
            'node_modules/underscore/underscore-min.js',
            'js/store/StoreUser.js',
            'js/model/App.js',
            'js/model/Request.js',
        ];
    }

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
        return \array_merge(self::baseJs(), [
            'js/store/vuex.js',
            'js/vue/VueApp.js',
            'js/vue/VuePageLogin.js',
        ]);
    }
}
