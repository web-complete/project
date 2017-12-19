Vue.component('VueFieldSelect', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <select :name="name"
            :title="label"
            :multiple="fieldParams.multiple"
            :disabled="fieldParams.disabled"
            class="select2"
    >
        <option v-if="fieldParams.withEmpty && !fieldParams.multiple"></option>
        <option v-for="(option, v) in fieldParams.options"
                :value="v"
                :selected="isSelected(v)"
        >{{option}}</option>
    </select>
    <span v-if="error" class="error">{{error}}</span>
</div>    
    `,
    props: {
        label: String,
        name: {type: String, required: true},
        value: [String, Number, Array],
        error: String,
        fieldParams: {
            type: [Object, Array],
            default: function(){
                return {
                    withEmpty: true,
                    multiple: false,
                    disabled: false,
                }
            }
        }
    },
    mounted: function(){
        let self = this;
        $(this.$el).find('select').select2().on('change', function(){
            self.$emit('input', $(this).val());
        });
    },
    destroyed: function(){
        $(this.$el).hide().find('select').select2('destroy');
    },
    methods: {
        isSelected: function(value){
            if (this.fieldParams.multiple && this.value instanceof Array) {
                return this.value.indexOf(value) !== -1;
            } else {
                return value == this.value;
            }
        }
    }
});
