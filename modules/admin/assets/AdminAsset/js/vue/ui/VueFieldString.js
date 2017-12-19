Vue.component('VueFieldString', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <input :type="fieldParams.type"
           :name="name"
           :value="value"
           :title="label"
           :placeholder="fieldParams.placeholder"
           :disabled="fieldParams.disabled"
           :maxlength="fieldParams.maxlength"
    />
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
                    type: 'text',
                    mask: '',
                    placeholder: '',
                    disabled: false,
                    maxlength: null
                }
            }
        }
    },

    mounted: function(){
        this.initMask();
    },

    destroyed: function(){
        this.destroyMask();
    },

    methods: {
        initMask: function(){
            var fieldParams = this.fieldParams instanceof Array ? {} : this.fieldParams;
            var options = {mask: /^.*$/};
            if (fieldParams.filter) {
                options.mask = new RegExp(fieldParams.filter);
            } else if (fieldParams.mask) {
                options.mask = fieldParams.mask;
            }
            this.mask = new IMask(this.$el.querySelector('input'), options);
            this.mask.on('accept', function(){
                this.$emit('input', this.mask.value);
            }.bind(this));
        },
        destroyMask: function(){
            if (this.mask) {
                this.mask.destroy();
            }
        }
    }
});
