VuePageEcommerceProperty = {
    // language=Vue
    template: `
<div class="page block">
    <div class="page-detail page-ecommerce-property">
        <div class="page-top">
            <h1>Общие товарные свойства</h1>
        </div>

        <div v-if="isLoaded">
            <vue-ecommerce-property-list v-model="properties"></vue-ecommerce-property-list>
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
            properties: []
        }
    },
    computed: {
        isValid(){
            let result = true;
            _.each(this.properties, function(property){
                if (!property.name || !property.code) {
                    result = false;
                }
            });
            return result;
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