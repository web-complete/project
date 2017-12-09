Vue.component('VueFieldString', {
    // language=Vue
    template: '<div class="form-row">\n    <label>{{label}}</label>\n    <input :type="fieldParams.type"\n           :name="name"\n           :value="value"\n           :title="label"\n           :placeholder="fieldParams.placeholder"\n           :disabled="fieldParams.disabled"\n           :maxlength="fieldParams.maxlength"\n    />\n</div>',
    props: {
        label: String,
        name: {type: String, required: true},
        value: [String, Number],
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
