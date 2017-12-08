VuePageSettings = {
    // language=Vue
    template: '<div class="page block">\n    <div class="page-detail">\n        <div class="page-top"><h1>Настройки</h1></div>\n        <form class="form-detail" v-show="isLoaded">\n            <vue-tabs>\n                <vue-tab v-for="section in settings.sections" :name="section.title" :active="section.code == \'common\'" :key="section.code">\n                    <div v-for="item in settings.data[section.code]">\n                        [{{section.code}} / {{item.code}}] {{item.title}}: {{item.value}}\n                    </div>\n                </vue-tab>\n            </vue-tabs>\n        </form>\n    </div>\n</div>',

    data: function(){
        return {
            isLoaded: false,
            settings: {}
        }
    },

    created: function(){
        this.fetchData()
    },

    watch: {
        '$route': 'fetchData'
    },

    methods: {
        fetchData: function(){
            Request.get('/admin/api/settings', function(response){
                if (response.result) {
                    this.isLoaded = true;
                    this.settings = response.settings;
                }
            }.bind(this));
        }
    }
};