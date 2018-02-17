VuePageEcommerceProperty = {
    // language=Vue
    template: `
<div class="page block">
    <div class="page-detail page-ecommerce-property">
        <div class="page-top">
            <h1>Глобальные товарные свойства</h1>
        </div>

        <div v-if="isLoaded">
            <vue-ecommerce-property-list v-model="properties"
                                         :global="true"
                                         @valid="isValid = $event"
            ></vue-ecommerce-property-list>
            <div class="form-actions">
                <vue-button @click="save" :disabled="!isValid">Сохранить</vue-button>
            </div>
        </div>
    </div>
</div>
    `,
    data(){
        return {
            apiUrl: '/admin/api/ecommerce-properties',
            isLoaded: false,
            isValid: false,
            properties: []
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
                    this.isLoaded = true;
                    this.properties = response.properties;
                } else {
                    Notify.errorDefault();
                }
            }.bind(this));
        },
        save(){
            if (this.isValid) {
                Request.post(this.apiUrl, {properties: this.properties}, function(response){
                    Notify.successDefault();
                });
            }
        }
    }
};