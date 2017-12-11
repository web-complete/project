<?php

namespace modules\admin\assets;

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
            'js/lib/jqueryui-custom/jquery-ui.min.css',
            'js/lib/jqueryui-custom/jquery-ui.theme.css',
            'js/lib/select2/select2.min.css',
            'js/lib/redactor10/redactor.css',
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
        return \array_merge(AdminAuthAsset::baseJs(), [
            'js/lib/jqueryui-custom/jquery-ui.min.js',
            'bower_components/vue-top-progress/dist/vue-top-progress.min.js',
            'bower_components/vue-toasted/dist/vue-toasted.min.js',
            'bower_components/vue-js-modal/dist/index.js',
            'js/lib/blueimp-upload/jquery.fileupload.js',
            'js/lib/blueimp-upload/jquery.iframe-transport.js',
            'js/lib/sticky-kit.min.js',
            'js/lib/imask.min.js',
            'bower_components/Sortable/Sortable.js',
            'js/lib/vuedraggable.min.js',
            'js/lib/select2/select2.min.js',
            'js/lib/redactor10/redactor.js',
            'js/lib/redactor10/plugins/table/table.js',
            'js/lib/redactor10/lang/ru.js',
            'js/store/StoreNavigation.js',
            'js/store/StoreSettings.js',

            'js/model/FieldHelper.js',
            'js/model/Notify.js',
            'js/model/Modal.js',

            'js/vue/ui/VueTabs.js',
            'js/vue/ui/VueTab.js',
            'js/vue/ui/VueFieldString.js',
            'js/vue/ui/VueFieldCheckbox.js',
            'js/vue/ui/VueFieldSelect.js',
            'js/vue/ui/VueFieldTextarea.js',
            'js/vue/ui/VueFieldRedactor.js',
            'js/vue/ui/VueFieldFile.js',
            'js/vue/ui/VueFieldImage.js',
            'js/vue/ui/VueFieldImageModalEdit.js',
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