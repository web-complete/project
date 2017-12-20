Vue.component('VueFieldRedactor', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <textarea :name="name"
              :title="label"
              :placeholder="fieldParams.placeholder"
              :disabled="fieldParams.disabled"
              :maxlength="fieldParams.maxlength"
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
                    maxlength: ''
                }
            }
        }
    },
    mounted: function(){
        this.initRedactor();
    },
    destroyed: function(){
        this.destroyRedactor();
    },
    methods: {
        initRedactor: function(){
            let self = this;
            $(this.$el).find('textarea').redactor({
                lang: 'ru',
                minHeight: 200,
                imageUpload: '/admin/api/upload-file',
                imageFloatMargin: '20px',
                imageResizable: true,
                buttons: ['html', 'bold', 'italic', 'deleted', 'unorderedlist', 'orderedlist',
                    'outdent', 'indent', 'image', 'table', 'link', 'alignment', '|',
                    'horizontalrule'],
                formattingTags: [],
                toolbarFixed: true,
                toolbarFixedTopOffset: 0,
                plugins: ['table'],
                changeCallback: function(){
                    self.$emit('input', this.code.get());
                }
            });
            setTimeout(function(){
                $('html,body').trigger('scroll');
            }, 0);
        },
        destroyRedactor: function(){
            $(this.$el).find('textarea').hide().redactor('core.destroy');
        }
    }
});
