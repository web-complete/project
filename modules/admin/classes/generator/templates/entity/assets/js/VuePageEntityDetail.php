<?php

use modules\admin\classes\generator\Config;

/** @var Config $config */

?>
VuePage<?=$config->nameCamel ?>Detail = {
    template: `
<div class="page block">
    <transition name="fade">
        <div class="page-detail" v-show="isLoaded">
            <div class="page-top">
                <h1>
                    <router-link class="back" :to="'/list/'+entityName"><i class="ion-chevron-left"></i></router-link>
                    {{title}} <small v-if="entityId">#{{entityId}}</small>
                </h1>
            </div>
    
            <form @submit.prevent="saveItem" class="form-detail">
                <vue-multilang-select v-if="isMultilang" @input="currentLang = $event"></vue-multilang-select>
                <vue-field v-for="field in detailFields"
                           :field="field"
                           :currentLang="currentLang || $store.getters.mainLang.code"
                           :key="field.name"
                ></vue-field>

                <div class="form-actions">
                    <vue-button @click="saveItem">Сохранить</vue-button>
                    <vue-button @click.prevent="saveItem($event, true)">Применить</vue-button>
                    <vue-button @click.prevent="deleteItem" class="gray">Удалить</vue-button>
                </div>
            </form>
        </div>
    </transition>
</div>
    `,
    data(){
        return {
            title: '',
            detailFields: [],
            isMultilang: false,
            currentLang: null
        }
    },
    computed: {
        apiUrl(){
            return '/admin/api/entity/'+this.entityName+'/'+this.entityId;
        },
        listRoute(){
            return '/list/'+this.entityName;
        },
        isLoaded(){
            return this.title;
        },
        entityName(){
            return '<?=$config->name ?>';
        },
        entityId(){
            return parseInt(this.$route.params.id) || 0;
        }
    },
    created(){
        this.fetchData()
    },
    watch: {'$route': 'fetchData'},
    methods: {
        fetchData(){
            Request.get(this.apiUrl, {}, function(response){
                if (response.result) {
                    this.title = response.title;
                    this.detailFields = response.detailFields;
                    this.isMultilang = response.isMultilang;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        saveItem($e, toContinue){
            Request.post(this.apiUrl, this.getCurrentData(), function(response){
                if (response.result) {
                    Notify.successDefault();
                    if (toContinue) {
                        this.$router.push('/detail/' + this.entityName + '/' + response.id);
                    } else {
                        this.$router.push(this.listRoute);
                    }
                } else {
                    Notify.error(response.error || 'Ошибка сохранения');
                }
                this.processErrors(response);
            }.bind(this));
        },
        deleteItem(){
            Modal.confirm('Вы уверены?', function(){
                Request.delete(this.apiUrl, {id: this.entityId}, function(){
                    Notify.successDefault();
                    this.$router.push(this.listRoute);
                }.bind(this));
            }.bind(this));
        },
        processErrors(response){
            _.each(this.detailFields, function(field) {
                this.$set(field, 'error', null);
                if (response.errors && response.errors[field.name]) {
                    field.error = response.errors[field.name];
                }
                this.$set(field, 'multilangError', null);
                if (response.multilangErrors && response.multilangErrors[field.name]) {
                    field.multilangError = response.multilangErrors[field.name];
                }
            }.bind(this));
        },
        getCurrentData(){
            let data = {};
            _.each(this.detailFields, function(field){
                data[field.name] = field.value;
            });

            if (this.isMultilang) {
                data.multilang = {};
                _.each(this.detailFields, function(field){
                    if (field.isMultilang) {
                        _.each(this.$store.state.lang.langs, function(lang){
                            if (!lang.is_main) {
                                data.multilang[lang.code] = data.multilang[lang.code] || {};
                                data.multilang[lang.code][field.name] = field.multilangData[lang.code] || '';
                            }
                        }.bind(this));
                    }
                }.bind(this));
            }

            return {id: this.entityId, data: data};
        }
    }
};