Vue.component('VueFieldTextarea', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <textarea :name="name"
              :title="label"
              :placeholder="fieldParams.placeholder"
              :disabled="fieldParams.disabled"
              :maxlength="fieldParams.maxlength"
              :rows="fieldParams.rows"
              @input="$emit('input', $event.target.value)"
    >{{value}}</textarea>
    <span v-if="error" class="error">{{error}}</span>
</div>    
    `,
    props: {
        label: String,
        name: {type: String, required: true},
        value: [String, Number],
        error: String,
        fieldParams: {
            type: [Object, Array],
            default: function(){
                return {
                    placeholder: '',
                    disabled: false,
                    maxlength: '',
                    rows: 15,
                }
            }
        }
    }
});
