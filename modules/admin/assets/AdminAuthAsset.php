<?php

namespace modules\admin\assets;

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
            'js/lib/jquery-migrate-3.0.0.min.js',
            'js/lib/js.cookie.min.js',
            'js/lib/Log.js',
            \ENV === 'prod' ? 'node_modules/vue/dist/vue.min.js' : 'node_modules/vue/dist/vue.js',
            'node_modules/vuex/dist/vuex.min.js',
            'node_modules/vue-router/dist/vue-router.min.js',
            'bower_components/lodash/dist/lodash.min.js',
            'js/functions.js',
            'js/store/StoreUser.js',
            'js/model/App.js',
            'js/model/Rbac.js',
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
            'bower_components/vue-toasted/dist/vue-toasted.min.css',
            'css/normalize.css',
            'css/ionicons.min.css',
            'css/font-awesome.min.css',
            'css/admin/base.css',
            'css/admin/login.css',
            'css/admin/popup.css',
        ];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return \array_merge(self::baseJs(), [
            'bower_components/vue-toasted/dist/vue-toasted.min.js',
            'js/model/Notify.js',
            'js/store/StoreSettings.js',
            'js/vue/VueApp.js',
            'js/vue/page/VuePageLogin.js',
        ]);
    }
}
