Vue.component('VueFieldHtml', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <div class="ace-wrapper">
        <div :id="'ace-'+name" class="ace-editor"></div>
    </div>
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
                    maxlength: ''
                }
            }
        }
    },
    mounted: function(){
        this.initAce();
    },
    destroyed: function(){
        this.destroyAce();
    },
    methods: {
        initAce: function(){
            this.editor = ace.edit('ace-'+this.name);
            let update = _.debounce(function(){
                this.$emit('input', this.editor.getValue());
            }.bind(this), 1000);

            this.editor.setTheme("ace/theme/chrome");
            this.editor.getSession().setMode("ace/mode/php");
            if (this.value) {
                this.editor.setValue(this.value);
            }
            this.editor.gotoLine(1);
            this.editor.getSession().on('change', function() {
                update();
            });
        },
        destroyAce: function(){
            this.editor.destroy();
        }
    }
});
