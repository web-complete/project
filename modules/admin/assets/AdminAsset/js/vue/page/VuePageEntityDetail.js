VuePageEntityDetail = {
    template: `
<div class="page block">
    <transition name="fade">
        <div class="page-detail" v-show="isLoaded">
            <div class="page-top">
                <h1>
                    <router-link class="back" :to="'/list/'+entityName"><i class="ion-chevron-left"></i></router-link>
                    {{title}}
                    <small v-if="entityId">#{{entityId}}</small>
                </h1>
            </div>
    
            <form @submit.prevent="saveItem" class="form-detail">
                <component v-for="field in detailFields"
                           :is="field.component"
                           :fieldParams="field.fieldParams"
                           :label="field.title"
                           :name="field.name"
                           :key="field.name"
                           v-model="field.value"
                ></component>

                <div class="form-actions">
                    <vue-button @click="saveItem">Сохранить</vue-button>
                    <vue-button @click.prevent="saveItem(true)">Применить</vue-button>
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
            errors: {}
        }
    },
    computed: {
        url(){
            return '/admin/api/entity/'+this.entityName+'/'+this.entityId;
        },
        isLoaded(){
            return this.title;
        },
        entityName(){
            return this.$route.params['entity'];
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
            Request.get(this.url, {}, function(response){
                if (response.result) {
                    this.title = response.title;
                    this.detailFields = response.detailFields;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        saveItem(toContinue){
            let data = {id: this.entityId};
            _.each(this.detailFields, function(field){
                data[field.name] = field.value;
            });
            Request.post(this.url, data, function(response){
                if (response.result) {
                    Notify.successDefault();
                    if (!toContinue) {
                        Notify.info('TODO route to list');
                        // TODO route to list
                    }
                } else {
                    this.errors = response.errors || {}; // TODO errors in fields too, and in vue fields
                    Notify.error(response.error || 'Ошибка сохранения');
                }
            }.bind(this));
        },
        deleteItem(){
            // TODO delete item and route to list
        }
    }
};