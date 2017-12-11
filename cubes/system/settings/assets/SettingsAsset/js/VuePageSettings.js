VuePageSettings = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top"><h1>Настройки</h1></div>
        <form @submit.prevent="save" class="form-detail" v-show="isLoaded">
            <vue-tabs>
                <vue-tab v-for="section in settings.sections"
                         v-if="settings.fields[section.name].length"
                         :name="section.title"
                         :active="section.name == 'common'"
                         :key="section.name"
                >
                    <div v-for="item in settings.fields[section.name]">
                        <component :is="item.component"
                                   :fieldParams="item.fieldParams"
                                   :label="item.title"
                                   :name="item.name"
                                   v-model="item.value"
                        ></component>
                    </div>
                </vue-tab>
            </vue-tabs>

            <div class="form-actions">
                <vue-button type="submit">Сохранить</vue-button>
            </div>
        </form>
    </div>
</div>
`,
    data: function(){
        return {
            isLoaded: false,
            settings: {},
            deleteFileIds: []
        }
    },
    created: function(){
        this.fetchData()
    },
    mounted: function(){
        bus.$on('deleteFileId', function(id){
            this.deleteFileIds.push(id);
        }.bind(this));
    },
    watch: {'$route': 'fetchData'},
    methods: {
        fieldMap: function(code){
            return FieldHelper.map(code);
        },
        fetchData: function(){
            Request.get('/admin/api/settings', {}, function(response){
                if (response.result) {
                    this.isLoaded = true;
                    this.settings = response.settings;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        save: function(){
            let self = this;
            Request.post('/admin/api/settings', {
                fields: this.settings.fields,
                deleteFileIds: this.deleteFileIds
            }, function(response){
                self.deleteFileIds = [];
                response.result
                    ? Notify.successDefault()
                    : Notify.errorDefault();
                if (response.theme) {
                    $('body').append(response.theme);
                }
                if (response.logo !== undefined) {
                    self.$store.state.settings.theme_logo = response.logo;
                }
            }.bind(this));
        }
    }
};