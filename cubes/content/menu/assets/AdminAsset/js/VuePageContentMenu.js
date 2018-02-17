VuePageContentMenu = extendVuePage(AbstractPageTree, {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top">
            <h1>Динамическое меню</h1>
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
                               v-show="isVisibleField(field.name)"
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
    data(){
        return _.merge(AbstractPageTree.data(), {
            apiUrl: '/admin/api/entity/menu/',
        });
    },
    methods: {
        isVisibleField(name){
            if (name === 'url') {
                return parseInt(this.getField('type').value) === 1;
            }
            if (name === 'page') {
                return parseInt(this.getField('type').value) === 2;
            }
            return true;
        },
        getField(name){
            let result = null;
            _.each(this.detailFields, function(field){
                if (field.name === name) result = field;
            });
            return result;
        }
    }
});
