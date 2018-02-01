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
                <form v-if="this.detailFields.length" @submit.prevent="saveItem" class="form-detail">
                    <vue-multilang-select @input="currentLang = $event"></vue-multilang-select>
                    <vue-field v-for="field in detailFields"
                               :field="field"
                               :currentLang="currentLang || $store.getters.mainLang.code"
                               :key="field.name"
                    ></vue-field>
    
                    <div class="form-actions">
                        <vue-button @click="saveItem">Сохранить</vue-button>
                        <vue-button v-if="entityId" @click.prevent="deleteItem" class="gray">Удалить</vue-button>
                    </div>
                </form>
            </div>
        </transition>
    </div>
</div>
`,
    mixins: [VueMixinGetEntityData, VueMixinProcessEntityErrors],
    data(){
        return {
            apiUrl: '/admin/api/entity/menu/',
            isLoaded: false,
            tree: [],
            entityId: null,
            detailFields: [],
            isMultilang: true,
            currentLang: null
        }
    },
    created(){
        this.fetchTree()
    },
    watch: {'$route': 'fetchTree'},
    methods: {
        fetchTree(){
            Request.get(this.apiUrl + 'tree', function(response){
                this.isLoaded = true;
                this.tree = response.tree;
            }.bind(this));
        },
        editItem(id){
            this.entityId = id;
            this.detailFields = [];
            Request.get(this.apiUrl + this.entityId, function(response){
                this.detailFields = response.detailFields;
            }.bind(this));
        },
        saveItem(){
            Request.post(this.apiUrl + this.entityId, this.getEntityData(), function(response){
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
            Modal.confirm('Вы уверены?', function(){
                Request.delete(this.apiUrl + this.entityId, {id: this.entityId}, function(){
                    this.entityId = null;
                    this.fetchTree();
                    Notify.successDefault();
                }.bind(this));
            }.bind(this));
        }
    }
};
