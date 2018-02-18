Vue.component('VueEcommercePropertyList', {
    // language=Vue
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
                    <th v-if="extended">Главное</th>
                    <th v-if="extended">Список</th>
                    <th v-if="extended">Фильтр</th>
                    <th width="30"></th>
                </tr>
                </thead>
                <draggable element="tbody" v-model="properties" :options="{handle: '._sort', draggable: '._item'}" class="_list">
                    <template v-for="property in properties">
                        <tr is="VueEcommercePropertyItem"
                            @remove="removeProperty(property.uid)"
                            @enumPopup="enumPopup(property)"
                            :class="{'_error': (errors[property.uid])}"
                            :property="property"
                            :global="global"
                            :extended="extended"
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
                        <td v-if="extended"></td>
                        <td v-if="extended"></td>
                        <td v-if="extended"></td>
                        <td><a @click="addProperty" class="_add" href="javascript://"><i class="fa fa-plus"></i></a></td>
                    </tr>
                </draggable>
            </table>
            <vue-ecommerce-property-enum-popup ref="enum"></vue-ecommerce-property-enum-popup>
        </div>
    `,
    props: {
        value: {type: Array, required: true},
        global: {type: Boolean, required: true},
        extended: {type: Boolean}
    },
    data(){
        return {
            errors: {}
        }
    },
    computed: {
        properties: {
            get(){
                return this.value;
            },
            set(value){
                this.$emit('input', value);
            }
        },
        isValid(){
            let result = true;
            let codes = [];
            let names = [];
            this.errors = {};
            _.each(this.properties, function(property){
                if (!property.name || !property.code) {
                    this.errors[property.uid] = true;
                    result = false;
                }
                if (_.indexOf(codes, property.code) !== -1) {
                    this.errors[property.uid] = true;
                    result = false;
                }
                if (_.indexOf(names, property.name) !== -1) {
                    this.errors[property.uid] = true;
                    result = false;
                }
                codes.push(property.code);
                names.push(property.name);
            }.bind(this));
            return result;
        }
    },
    watch: {
        properties: {
            handler: function(){ this.$emit('valid', this.isValid) },
            immediate: true,
            deep: true
        }
    },
    methods: {
        addProperty(){
            this.properties.push({
                uid: uniqueId(12),
                name: '',
                type: 'string',
                global: this.global ? 1 : 0,
                enabled: 1,
                for_main: 0,
                for_list: 0,
                for_filter: 0,
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
