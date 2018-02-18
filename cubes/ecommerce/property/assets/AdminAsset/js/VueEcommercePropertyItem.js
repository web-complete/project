Vue.component('VueEcommercePropertyItem', {
    // language=Vue
    template: `
        <tr class="_item" :class="{_disabled: isDisabled}">
            <td>
                <div class="_sort"><i class="fa fa-reorder"></i></div>
            </td>
            <td>
                <masked-input class="_code" v-model="property.code" :mask="/^[a-z0-9-_]+$/" :disabled="isDisabled"></masked-input>
            </td>
            <td>
                <input class="_name" type="text" v-model="property.name" :disabled="isDisabled" />
            </td>
            <td>
                <select class="_type" v-model="property.type" :disabled="isDisabled">
                    <option v-for="type in types" :value="type.value" :selected="type.value === property.type">{{type.name}}</option>
                </select>
            </td>
            <td>
                <a v-if="hasSettings && !isDisabled" @click="openSettings" class="_cog" href="javascript://"><i class="fa fa-cog"></i></a>
            </td>
            <td class="center">
                <div class="checkbox-nice">
                    <input :id="'id1-'+property.uid" type="checkbox" v-model="property.enabled" :true-value="1" :false-value="0">
                    <label :for="'id1-'+property.uid"></label>
                </div>
            </td>
            <td v-if="extended" class="center">
                <div v-if="property.enabled" class="checkbox-nice">
                    <input :id="'id2-'+property.uid" type="checkbox" v-model="property.for_main" :true-value="1" :false-value="0">
                    <label :for="'id2-'+property.uid"></label>
                </div>
            </td>
            <td v-if="extended" class="center">
                <div v-if="property.enabled" class="checkbox-nice">
                    <input :id="'id3-'+property.uid" type="checkbox" v-model="property.for_list" :true-value="1" :false-value="0">
                    <label :for="'id3-'+property.uid"></label>
                </div>
            </td>
            <td v-if="extended" class="center">
                <div v-if="property.enabled" class="checkbox-nice">
                    <input :id="'id4-'+property.uid" type="checkbox" v-model="property.for_filter" :true-value="1" :false-value="0">
                    <label :for="'id4-'+property.uid"></label>
                </div>
            </td>
            <td>
                <a v-if="!isDisabled" @click="$emit('remove')" class="_remove" href="javascript://"><i class="fa fa-minus"></i></a>
            </td>
        </tr>
    `,
    components: {'masked-input': VueIMask.IMaskComponent},
    props: {
        property: {type: Object, required: true},
        global: {type: Boolean, required: true},
        extended: {type: Boolean}
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
        },
        isDisabled: function(){
            return !this.global && this.property.global !== 0;
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
