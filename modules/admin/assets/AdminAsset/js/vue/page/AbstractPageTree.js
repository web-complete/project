AbstractPageTree = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top">
            <h1>Заголовок</h1>
        </div>
        
        <transition name="fade">
            <div v-if="isLoaded">
                <vue-tree @open="openItem"
                          @move="moveItem"
                          :tree="tree"
                          name="classifier"
                          ref="tree"
                ></vue-tree>
                <hr class="mb10 clear">
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
            apiUrl: '',
            titleField: 'title',
            isLoaded: false,
            tree: [],
            parentId: null,
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
            Request.get(this.apiUrl + 'tree', {}, function(response){
                this.isLoaded = true;
                this.tree = response.tree;
                this.permissions = response.permissions;
            }.bind(this));
        },
        openItem(id, parentId){
            if (parentId === '#') {
                this.closeItem(false);
                return;
            }
            this.entityId = id;
            this.parentId = parentId;
            this.detailFields = [];
            Request.get(this.apiUrl + this.entityId, {}, function(response){
                this.detailFields = response.detailFields;
            }.bind(this));
        },
        moveItem(parentId, childrenIds){
            Request.post(this.apiUrl + 'move', {
                parent_id: parentId,
                children_ids: childrenIds,
            });
        },
        saveItem(){
            let data = this.getEntityData({
                parent_id: this.parentId
            });
            Request.post(this.apiUrl + this.entityId, data, function(response){
                if (response.result) {
                    (parseInt(this.entityId) !== parseInt(response.id))
                        ? this.$refs['tree'].createNode(this.parentId, response.id, response.data[this.titleField])
                        : this.$refs['tree'].renameNode(this.entityId, response.data[this.titleField]);
                    this.closeItem(true);
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
                    this.$refs['tree'].deleteNode(this.entityId);
                    this.closeItem(true);
                    Notify.successDefault();
                }.bind(this));
            }.bind(this));
        },
        closeItem(closeNode){
            this.entityId = null;
            this.parentId = null;
            this.detailFields = [];
            if (closeNode) {
                this.$refs['tree'].closeNode();
            }
        }
    }
};