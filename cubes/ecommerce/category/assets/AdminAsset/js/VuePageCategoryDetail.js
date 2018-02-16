VuePageCategoryDetail = extendVuePage(VuePageEntityDetail, {
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
                    </vue-tab>
                    <vue-tab :name="'Товарные свойства'" :key="'tab2'">
                        <vue-ecommerce-property-list v-model="properties" @valid="isValid = $event"></vue-ecommerce-property-list>
                    </vue-tab>
                </vue-tabs>

                <div v-if="isAllowed(permissions.edit)" class="form-actions">
                    <vue-button @click="saveItem" :disabled="!isValid">Сохранить</vue-button>
                    <vue-button @click.prevent="saveItem($event, true)" :disabled="!isValid">Применить</vue-button>
                    <vue-button v-if="entityId" @click.prevent="deleteItem" class="gray">Удалить</vue-button>
                </div>
            </form>
        </div>
    </transition>
</div>
    `,
    data(){
        return _.merge({}, VuePageEntityDetail.data(), {
            properties: [],
            isValid: false
        });
    },
    computed: {
        entityName(){
            return 'ecommerce-category';
        }
    },
    methods: {
        fetchData(){
            Request.get(this.apiUrl, {}, function(response){
                if (response.result) {
                    this.title = response.title;
                    this.detailFields = response.detailFields;
                    this.isMultilang = response.isMultilang;
                    this.permissions = response.permissions;
                    this.properties = response.properties;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        saveItem($e, toContinue){
            if (this.isValid) {
                VuePageEntityDetail.methods.saveItem.call(this, $e, toContinue);
            }
        }
    }
});