VuePageEcommerceProperty = {
    // language=Vue
    template: `
<div class="page block">
    <div class="page-detail page-ecommerce-property">
        <div class="page-top">
            <h1>Общие товарные свойства</h1>
        </div>

        <div v-if="isLoaded">
            <table class="table properties-table">
                <thead>
                <tr>
                    <th width="30"></th>
                    <th>Код</th>
                    <th>Название</th>
                    <th>Тип</th>
                    <th width="30"></th>
                    <th>Вкл.</th>
                    <th width="30"></th>
                </tr>
                </thead>
                <draggable element="tbody" v-model="properties" :options="{handle: '._sort', draggable: '._item'}" class="_list">
                    <template v-for="property in properties">
                        <tr is="VueEcommercePropertyItem"
                            @remove="removeProperty(property.uid)"
                            @enumPopup="enumPopup(property)"
                            :property="property"
                            :key="property.uid"
                        ></tr>
                    </template>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><a @click="addProperty" class="_add" href="javascript://"><i class="fa fa-plus"></i></a></td>
                    </tr>
                </draggable>
            </table>

            <div class="form-actions">
                <vue-button @click="save" :disabled="!isValid">Сохранить</vue-button>
            </div>
        </div>
    </div>

    <vue-ecommerce-property-enum-popup ref="enum"></vue-ecommerce-property-enum-popup>
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
        addProperty(){
            this.properties.push({
                uid: uniqueId(12),
                name: '',
                type: 'string',
                enabled: true,
                data: {}
            });
        },
        removeProperty(uid){
            this.properties = _.filter(this.properties, function(property){
                return property.uid !== uid;
            });
        },
        enumPopup(property){
            this.$refs['enum'].open(property);
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