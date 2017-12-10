Vue.component('VueFieldFile', {
    template: `
<div class="form-row">
    <label v-if="label">{{label}}</label>
    <div class="form-file">
        <input type="file"
               :name="name"
        />
        <span data-state="add">
            <a @click="selectFile" href="javascript://" class="_add">Загрузить</a>
        </span>
    </div>
</div>    
    `,
    props: {
        label: String,
        name: {type: String, required: true},
        value: [Number, String],
        fieldParams: {
            type: [Object, Array],
            default: function(){
                return {
                }
            }
        }
    },
    mounted: function(){
        this.initUploader();
    },
    destroyed: function(){
        this.destroyUploader();
    },
    methods: {
        initUploader: function(){
            $(this.$el).find('input[type=file]').fileupload({
                dataType: 'json',
                url: '/admin/api/upload',
                add: function (e, data) {
                    $(Request).trigger('start');
                    data.formData = {};
                    data.submit();
                },
                done: function (e, data) {
                    if(data.result) {
                        $(Request).trigger('stop');
                    }
                    else {
                        $(Request).trigger('error');
                        Notify.error(data.error || 'Ошибка загрузки файла');
                    }
                },
                fail: function () {
                    $(Request).trigger('error');
                    Notify.error('Ошибка загрузки файла');
                }
            });
        },
        selectFile: function(){
            $(this.$el).find('input[type=file]').click();
        },
        destroyUploader: function(){
            $(this.$el).find('input[type=file]').fileupload('destroy');
        }
    }
});
