<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>
VuePage<?=$config->nameCamel ?>Detail = extendVuePage(VuePageEntityDetail, {
    computed: {
        entityName(){
            return '<?=$config->name ?>';
        }
    }
});