<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>
VuePage<?=$config->nameCamel ?>List = extendVuePage(VuePageEntityList, {
    computed: {
        entityName(){
            return '<?=$config->name ?>';
        }
    }
});