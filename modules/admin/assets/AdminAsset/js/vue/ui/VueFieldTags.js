Vue.component('VueFieldTags', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <input type="text" />
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
    mounted: function(){
        this.initTags();
    },
    destroyed: function(){
        this.destroyTags();
    },
    methods: {
        initTags: function(){
            $(this.$el).find('input').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                }
            });
        },
        destroyTags: function(){
            // TODO
        }
    }
});
