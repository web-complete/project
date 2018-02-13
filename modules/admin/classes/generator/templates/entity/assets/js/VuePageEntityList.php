<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>
VuePage<?=$config->nameCamel ?>List = {
    template: `
<div class="page block">
    <div class="page-list">
        <div class="page-top" v-show="isLoaded">
            <h1>{{title}}</h1>
            <router-link v-if="isAllowed(permissions.edit)" class="button" :to="'/detail/'+entityName+'/0'">Добавить</router-link>
        </div>
        
        <transition name="fade">
            <vue-entity-list @title="title = $event"
                             @permissions="permissions = $event"
                             :entityName="entityName"
                             :key="entityName"
            ></vue-entity-list>
        </transition>
    </div>
</div>
    `,
    mixins: [VueMixinRbac],
    data(){
        return {
            title: '',
            permissions: {
                view: '',
                edit: ''
            }
        }
    },
    computed: {
        isLoaded(){
            return this.title;
        },
        entityName(){
            return '<?=$config->name ?>';
        }
    }
};