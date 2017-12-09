VuePageSettings = {
    // language=Vue
    template: '<div class="page block">\n    <div class="page-detail">\n        <div class="page-top"><h1>Настройки</h1></div>\n        <form @submit.prevent="save" class="form-detail" v-show="isLoaded">\n            <vue-tabs>\n                <vue-tab v-for="section in settings.sections"\n                         v-if="settings.data[section.code].length"\n                         :name="section.title"\n                         :active="section.code == \'common\'"\n                         :key="section.code"\n                >\n                    <div v-for="item in settings.data[section.code]">\n                        <component :is="fieldMap(item.field)"\n                                   :fieldParams="item.fieldParams"\n                                   :label="item.title"\n                                   :name="item.code"\n                                   v-model="item.value"\n                        ></component>\n                    </div>\n                </vue-tab>\n            </vue-tabs>\n\n            <div class="form-actions">\n                <vue-button type="submit">Сохранить</vue-button>\n            </div>\n        </form>\n    </div>\n</div>',
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
            }.bind(this));
        }
    }
};