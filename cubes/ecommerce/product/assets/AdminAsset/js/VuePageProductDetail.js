VuePageProductDetail = extendVuePage(VuePageEntityDetail, {
    // language=Vue
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
                <vue-tabs>
                    <vue-tab :name="'Основное'" :active="true" :key="'tab1'">
                        <vue-multilang-select v-if="isMultilang" @input="currentLang = $event"></vue-multilang-select>
                        <vue-field v-for="field in detailFields"
                                   :field="field"
                                   :currentLang="currentLang || $store.getters.mainLang.code"
                                   :key="field.name"
                        ></vue-field>

                        <div v-if="propertyFields.length" class="mt20">
                            <div class="form-row"><label><b>Товарные свойства:</b></label></div>
                            <vue-field v-for="field in propertyFields"
                                       :field="field"
                                       :currentLang="currentLang || $store.getters.mainLang.code"
                                       :key="field.name"
                            ></vue-field>
                        </div>
                    </vue-tab>
                </vue-tabs>

                <div v-if="isAllowed(permissions.edit)" class="form-actions">
                    <vue-button @click="saveItem">Сохранить</vue-button>
                    <vue-button @click.prevent="saveItem($event, true)">Применить</vue-button>
                    <vue-button v-if="entityId" @click.prevent="deleteItem" class="gray">Удалить</vue-button>
                </div>
            </form>
        </div>
    </transition>
</div>
    `,
    data(){
        return _.merge(VuePageEntityDetail.data(), {
            propertyFields: []
        });
    },
    computed: {
        entityName(){
            return 'ecommerce-product';
        }
    },
    methods: {
        fetchData(){
            Request.get(this.apiUrl, {}, function(response){
                if (response.result) {
                    this.title = response.title;
                    this.detailFields = response.detailFields;
                    this.propertyFields = response.propertyFields;
                    this.isMultilang = response.isMultilang;
                    this.permissions = response.permissions;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        getEntityData(){
            let propertiesData = {};
            _.each(this.propertyFields, function(field){
                propertiesData[field.name] = field.value;
            });

            if (this.isMultilang) {
                propertiesData.multilang = {};
                _.each(this.detailFields, function(field){
                    if (field.isMultilang) {
                        _.each(this.$store.state.lang.langs, function(lang){
                            if (!lang.is_main) {
                                propertiesData.multilang[lang.code] = propertiesData.multilang[lang.code] || {};
                                propertiesData.multilang[lang.code][field.name] = field.multilangData[lang.code] || '';
                            }
                        }.bind(this));
                    }
                }.bind(this));
            }

            return VueMixinGetEntityData.methods.getEntityData.call(this, {
                propertiesData: propertiesData
            });
        }
    }
});