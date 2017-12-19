Vue.component('VueFieldCheckbox', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <div class="checkbox-nice">
        <input :id="uid"
               :name="name"
               :checked="getValue"
               :disabled="fieldParams.disabled"
               @change="$emit('input', $event.target.checked ? 1 : 0)"
               type="checkbox"
               value="1"
        >
        <label :for="uid"></label>
    </div>
</div>    
    `,
    props: {
        label: String,
        name: {type: String, required: true},
        value: [String, Number, Boolean],
        error: String,
        fieldParams: {
            type: [Object, Array],
            default: function(){
                return {
                    disabled: false,
                }
            }
        }
    },
    computed: {
        getValue: function(){
            return parseInt(this.value) || 0;
        },
        uid: function(){
            return _.uniqueId('filter-checkbox');
        }
    }
});
