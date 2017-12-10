VuePageSettings = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top"><h1>Настройки</h1></div>
        <form @submit.prevent="save" class="form-detail" v-show="isLoaded">
            <vue-tabs>
                <vue-tab v-for="section in settings.sections"
                         v-if="settings.data[section.code].length"
                         :name="section.title"
                         :active="section.code == 'common'"
                         :key="section.code"
                >
                    <div v-for="item in settings.data[section.code]">
                        <component :is="fieldMap(item.field)"
                                   :fieldParams="item.fieldParams"
                                   :label="item.title"
                                   :name="item.code"
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
            settings: {}
        }
    },
    created: function(){
        this.fetchData()
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
                }
            }.bind(this));
        },
        save: function(){
            Request.post('/admin/api/settings', {data: this.settings.data}, function(response){
                response.result
                    ? Notify.successDefault()
                    : Notify.errorDefault();
                if (response.theme) {
                    $('body').append(response.theme);
                }
            }.bind(this));
        }
    }
};