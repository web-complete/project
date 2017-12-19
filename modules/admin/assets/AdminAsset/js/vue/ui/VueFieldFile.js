Vue.component('VueFieldFile', {
    template: `
<div class="form-row" :class="{'has-errors': error}">
    <label v-if="label">{{label}}</label>
    <div class="form-file">
        <input type="file"
               :name="name"
        />
        <span v-if="value && fileFieldParams.data[value]">
            <a :href="fileFieldParams.data[value].url" target="_blank">{{fileFieldParams.data[value].name}}</a>
            <a @click="deleteFile(value)" href="javascript://" class="_del"><i class="ion-close"></i></a>
        </span>
        <span v-else>
            <a @click="selectFile" href="javascript://" class="_add">Загрузить</a>
        </span>
    </div>
</div>    
    `,
    props: {
        label: String,
        name: {type: String, required: true},
        value: [Number, String],
        error: String,
        fieldParams: {
            type: [Object, Array],
            default: function(){
                return {
                }
            }
        }
    },
    data: function(){
        return {
            fileFieldParams: {}
        }
    },
    created: function(){
        this.fileFieldParams = this.fieldParams;
        if (this.fileFieldParams instanceof Array) {
            this.fileFieldParams = {};
        }
        if (!this.fileFieldParams.data) {
            this.fileFieldParams.data = {}
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
            let self = this;
            $(this.$el).find('input[type=file]').fileupload({
                dataType: 'json',
                url: '/admin/api/upload-file',
                add: function (e, data) {
                    $(Request).trigger('start');
                    data.formData = {};
                    data.submit();
                },
                done: function (e, data) {
                    if(data.result.result) {
                        $(Request).trigger('stop');
                        self.fileFieldParams.data[data.result.id] = {
                            name: data.result.name,
                            url: data.result.filelink
                        };
                        self.$emit('input', data.result.id);
                    }
                    else {
                        $(Request).trigger('error');
                        Notify.error(data.result.error || 'Ошибка загрузки файла');
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
        deleteFile: function(id){
            this.$emit('input', '');
            bus.$emit('deleteFileId', id);
        },
        destroyUploader: function(){
            $(this.$el).find('input[type=file]').fileupload('destroy');
        }
    }
});
