Vue.component('VueEcommercePropertyEnumPopup', {
    template: `
        <modal :name="'ecommerce-property-enum'"
               :scrollable="true"
               width="500px"
               height="auto"
        >
            <h1>Варианты выбора</h1>
            <div v-if="property.uid">
                <table class="table properties-table _wide">
                <thead>
                <tr>
                    <th width="30"></th>        
                    <th width="30%">Ключ</th>        
                    <th>Значение</th>        
                    <th width="30"></th>        
                </tr>
                </thead>
                <draggable element="tbody" v-model="items" :options="{handle: '._sort', draggable: '._item'}" class="_list">
                    <tr v-for="(item, k) in items" class="_item">
                        <td><div class="_sort"><i class="fa fa-reorder"></i></div></td>
                        <td><input class="_wide" type="text" v-model="item.code"></td>
                        <td><input class="_wide" type="text" v-model="item.value"></td>
                        <td><a @click="remove(k)" class="_remove" href="javascript://"><i class="fa fa-minus"></i></a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><a @click="add" class="_add" href="javascript://"><i class="fa fa-plus"></i></a></td>
                    </tr>
                </draggable>
                </table>

                <div class="popup-content pt0">
                    <div class="form-actions">
                        <button @click="save" class="button" :disabled="!isValid" type="button">Применить</button>
                        <button @click="close" class="button gray" type="button">Отменить</button>
                    </div>
                </div>
            </div>
        </modal>
    `,
    data(){
        return {
            property: {},
            items: []
        }
    },
    computed: {
        isValid(){
            if (this.items.length === 0) return false;
            let result = true;
            _.each(this.items, function(item){
                if (!item.code.trim() || !item.value.trim()) {
                    result = false;
                }
            });
            return result;
        }
    },
    methods: {
        open: function(property){
            if (property.type === 'enum') {
                this.property = property;
                this.items = JSON.parse(JSON.stringify(property.data.enum || []));
                this.$modal.show('ecommerce-property-enum');
            }
        },
        close: function(){
            this.$modal.hide('ecommerce-property-enum');
        },
        save: function(){
            if (this.isValid) {
                this.property.data = {enum: JSON.parse(JSON.stringify(this.items))};
                this.close();
            }
        },
        add: function(){
            this.items.push({
                code: '',
                value: ''
            });
        },
        remove: function(idx){
            this.items.splice(idx, 1);
        }
    }
});
