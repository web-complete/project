Vue.component('VueEcommercePropertyItem', {
    template: `
        <tr class="_item">
            <td>
                <div class="_sort"><i class="fa fa-reorder"></i></div>
            </td>
            <td>
                <input class="_name" type="text" v-model="property.name" />
            </td>
            <td>
                <select class="_type" v-model="property.type">
                    <option v-for="type in types" :value="type.value" :selected="type.value === property.type">{{type.name}}</option>
                </select>
            </td>
            <td>
                <div class="checkbox-nice">
                    <input type="checkbox" v-model="property.enabled" value="1">
                    <label></label>
                </div>
            </td>
            <td>
                <a class="_remove" href="javascript://"><i class="fa fa-minus"></i></a>
            </td>
        </tr>
    `,
    props: {
        property: {type: Object, required: true}
    },
    data(){
        return {
            types: [
                {name: 'Строка', value: 'string'},
                {name: 'Выбор', value: 'enum'}
            ]
        }
    },
    mounted: function(){
        $(this.$el).find('select').select2();
    }
});
