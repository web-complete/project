VuePageSettings = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top"><h1>Настройки</h1></div>
        <form @submit.prevent="save" class="form-detail" v-show="isLoaded">
            <transition name="fade">
                <vue-tabs v-show="isLoaded">
                    <vue-tab v-for="section in settings.sections"
                             v-if="settings.fields[section.name].length"
                             :name="section.title"
                             :active="section.name == 'common'"
                             :key="section.name"
                    >
                        <component v-for="item in settings.fields[section.name]"
                                   :is="item.component"
                                   :fieldParams="item.fieldParams"
                                   :label="item.title"
                                   :name="item.name"
                                   :key="item.name"
                                   v-model="item.value"
                        ></component>
                    </vue-tab>
                </vue-tabs>
            </transition>

            <div class="form-actions">
                <vue-button type="submit">Сохранить</vue-button>
            </div>
        </form>
    </div>
</div>
`,
    data(){
        return {
            isLoaded: false,
            settings: {},
            deleteFileIds: []
        }
    },
    created(){
        this.fetchData()
    },
    mounted(){
        bus.$on('deleteFileId', function(id){
            this.deleteFileIds.push(id);
        }.bind(this));
    },
    watch: {'$route': 'fetchData'},
    methods: {
        fetchData(){
            Request.get('/admin/api/settings', {}, function(response){
                if (response.result) {
                    this.isLoaded = true;
                    this.settings = response.settings;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        save(){
            let self = this;
            Request.post('/admin/api/settings', {
                fields: this.settings.fields,
                deleteFileIds: this.deleteFileIds
            }, function(response){
                self.deleteFileIds = [];
                if (response.result) {
                    if (self.deleteFileIds.length) {
                        Request.post('/admin/api/delete-file', {id: self.deleteFileIds}, function(){
                            self.deleteFileIds = [];
                        });
                    }
                    Notify.successDefault();
                    if (response.theme) {
                        $('body').append(response.theme);
                    }
                    if (response.logo !== undefined) {
                        self.$store.state.settings.theme_logo = response.logo;
                    }
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        }
    }
};