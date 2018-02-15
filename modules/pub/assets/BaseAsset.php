<?php

namespace modules\pub\assets;

use WebComplete\mvc\assets\AbstractAsset;

class BaseAsset extends AbstractAsset
{

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return __DIR__ . '/BaseAsset';
    }

    /**
     * @return array
     */
    public function css(): array
    {
        return [
        ];
    }

    /**
     * @return array
     */
    public function js(): array
    {
        return [
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/lodash/dist/lodash.min.js',
            ENV === 'dev' ? 'bower_components/vue/dist/vue.js' : 'bower_components/vue/dist/vue.min.js',
            'node_modules/vue-imask/dist/vue-imask.js',
            'node_modules/imask/dist/imask.min.js',
            'js/jquery-migrate-3.0.0.min.js',
            'js/js.cookie.min.js',
            'js/Log.js',
            'js/Request.js',
        ];
    }
}
