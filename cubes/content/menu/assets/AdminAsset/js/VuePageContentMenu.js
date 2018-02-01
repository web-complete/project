VuePageContentMenu = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top">
            <h1>Динамическое меню</h1>
        </div>
        
        <transition name="fade">
            <div v-if="isLoaded">
                <vue-tree @open="editItem"
                          :tree="tree"
                          name="classifier"
                ></vue-tree>
                <hr class="clear">
                <form v-if="showForm" @submit.prevent="saveItem" class="form-detail">
                    <vue-multilang-select @input="currentLang = $event"></vue-multilang-select>
                    <vue-field v-for="field in detailFields"
                               :field="field"
                               :currentLang="currentLang || $store.getters.mainLang.code"
                               :key="field.name"
                    ></vue-field>
    
                    <div class="form-actions">
                        <vue-button @click="saveItem">Сохранить</vue-button>
                        <vue-button @click.prevent="deleteItem" class="gray">Удалить</vue-button>
                    </div>
                </form>
            </div>
        </transition>
    </div>
</div>
`,
    data(){
        return {
            isLoaded: false,
            tree: [],
            entityId: null,
            detailFields: [],
            isMultilang: true,
            currentLang: null
        }
    },
    computed: {
        showForm(){
            return this.detailFields.length > 0;
        }
    },
    created(){
        this.fetchTree()
    },
    watch: {'$route': 'fetchTree'},
    methods: {
        fetchTree(){
            Request.get('/admin/api/entity/menu/tree', function(response){
                this.isLoaded = true;
                this.tree = response.tree;
            }.bind(this));
        },
        editItem(id){
            this.entityId = id;
            this.detailFields = [];
            Request.get('/admin/api/entity/menu/' + this.entityId, function(response){
                this.detailFields = response.detailFields;
            }.bind(this));
        },
        saveItem(){
            Request.post('/admin/api/entity/menu/' + this.entityId, this.getEntityData(), function(response){
                if (response.result) {
                    this.fetchTree();
                    Notify.successDefault();
                } else {
                    Notify.error(response.error || 'Ошибка сохранения');
                }
                this.processEntityErrors(response);
            }.bind(this));
        },
        deleteItem(){
            Modal.confirm('Удалить?', function(){
                console.log('TODO VuePageContentMenu.deleteItem', this.entityId);
            }.bind(this));
        },
        processEntityErrors(response){ // TODO mixin?
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
        getEntityData(){ // TODO mixin?
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