VuePageRolesDetail = {
    template: `
<div class="page block">
    <transition name="fade">
        <div class="page-detail" v-show="isLoaded">
            <div class="page-top">
                <h1>
                    <router-link class="back" :to="'/roles'"><i class="ion-chevron-left"></i></router-link>
                    Пользовательская роль
                    <small v-if="id != 0">#{{id}}</small>
                </h1>
            </div>
    
            <form @submit.prevent="saveItem" class="form-detail">
                <component v-for="field in detailFields"
                           :is="field.component"
                           :fieldParams="field.fieldParams"
                           :label="field.title"
                           :name="field.name"
                           :error="errors[field.name]"
                           :key="field.name"
                           v-model="field.value"
                           @input="$delete(errors, field.name)"
                ></component>

                <div class="form-actions">
                    <vue-button @click="saveItem">Сохранить</vue-button>
                    <vue-button @click.prevent="deleteItem" class="gray">Удалить</vue-button>
                </div>
            </form>
        </div>
    </transition>
</div>
    `,
    data(){
        return {
            isLoaded: false,
            detailFields: [],
            errors: {}
        }
    },
    computed: {
        id(){
            return this.$route.params['id'];
        },
        apiUrl(){
            return '/admin/api/roles/'+this.id;
        },
        listRoute(){
            return '/roles';
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
                    this.detailFields = response.detailFields;
                    this.isLoaded = true;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        saveItem(){
            let data = {id: this.id};
            _.each(this.detailFields, function(field){
                data[field.name] = field.value;
            });
            Request.post(this.apiUrl, data, function(response){
                if (response.result) {
                    Notify.successDefault();
                    this.$router.push(this.listRoute);
                } else {
                    this.errors = response.errors || {};
                    Notify.error(response.error || 'Ошибка сохранения');
                }
            }.bind(this));
        },
        deleteItem(){
            Modal.confirm('Вы уверены?', function(){
                Request.delete(this.apiUrl, {id: this.id}, function(){
                    Notify.successDefault();
                    this.$router.push(this.listRoute);
                }.bind(this));
            }.bind(this));
        }
    }
};