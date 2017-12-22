Vue.component('VueFieldDate', {
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
    <span class="input-date"><i class="ion-calendar"></i></span>
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
        this.initPicker();
        this.initMask();
    },

    destroyed: function(){
        this.destroyMask();
        this.destroyPicker();
    },

    methods: {
        initPicker: function(){
            this.picker = $(this.$el).find('input').datepicker({
                onSelect: function(formattedDate){
                    this.mask.value = formattedDate;
                }.bind(this)
            }).data('datepicker');
        },
        destroyPicker: function(){
            this.picker.destroy();
        },
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
