Vue.component('VueEcommercePropertyList', {
    template: `
        <div>
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
            <vue-ecommerce-property-enum-popup ref="enum"></vue-ecommerce-property-enum-popup>
        </div>
    `,
    props: {
        value: {type: Array, required: true},
    },
    computed: {
        properties: {
            get(){
                return this.value;
            },
            set(value){
                this.$emit('input', value);
            }
        }
    },
    methods: {
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
        }
    }
});
