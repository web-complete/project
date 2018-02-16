Vue.component('VueEcommercePropertyItem', {
    template: `
        <tr class="_item">
            <td>
                <div class="_sort"><i class="fa fa-reorder"></i></div>
            </td>
            <td>
                <masked-input class="_code" v-model="property.code" :mask="/^[a-z0-9-_]+$/"></masked-input>
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
                <a v-if="hasSettings" @click="openSettings" class="_cog" href="javascript://"><i class="fa fa-cog"></i></a>
            </td>
            <td>
                <div class="checkbox-nice">
                    <input :id="'prop'+property.uid" type="checkbox" v-model="property.enabled" :true-value="1" :false-value="0">
                    <label :for="'prop'+property.uid"></label>
                </div>
            </td>
            <td>
                <a @click="$emit('remove')" class="_remove" href="javascript://"><i class="fa fa-minus"></i></a>
            </td>
        </tr>
    `,
    components: {'masked-input': VueIMask.IMaskComponent},
    props: {
        property: {type: Object, required: true}
    },
    data(){
        return {
            types: [
                {name: 'Строка', value: 'string'},
                {name: 'Флажок', value: 'bool'},
                {name: 'Выбор', value: 'enum'},
                {name: 'Изображение', value: 'image'},
                {name: 'Изображения', value: 'images'},
            ]
        }
    },
    computed: {
        hasSettings: function(){
            return this.property.type === 'enum';
        }
    },
    mounted: function(){
        this.initSelect();
    },
    destroyed: function(){
        this.destroySelect();
    },
    methods: {
        initSelect(){
            let self = this;
            $(this.$el).find('select').select2().on('change', function(){
                self.property.type = $(this).val();
                if (self.property.type === 'enum') {
                    self.property.data = {enum: []};
                }
            });
        },
        destroySelect(){
            $(this.$el).hide().find('select').select2('destroy');
        },
        openSettings(){
            if (this.property.type === 'enum') {
                this.$emit('enumPopup');
            }
        }
    }
});
