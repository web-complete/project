Vue.component('VueFieldTags', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <select :name="name" multiple>
        <option v-for="tag in fieldParams.availableTags"
                :selected="fieldParams.selectedTags.indexOf(tag) !== -1"
                :value="tag"
        >{{tag}}</option>
    </select>
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
                    availableTags: [],
                    selectedTags: []
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
            this.selectize = $(this.$el).find('select').selectize({
                delimiter: ',',
                persist: false,
                create: function(input) {
                    return {
                        value: input,
                        text: input
                    }
                },
                render: {
                    option_create: function (data, escape) {
                        return '<div class="create">+ ' + escape(data.input) + '&hellip;</div>';
                    }
                },
                onChange: function(value){
                    this.$emit('input', value.join(','));
                }.bind(this)
            })[0].selectize;
        },
        destroyTags: function(){
            this.selectize.destroy();
        }
    }
});
