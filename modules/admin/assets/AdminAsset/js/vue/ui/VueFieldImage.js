Vue.component('VueFieldImage', {
    template: `
<div class="form-row">
    <label v-if="label">{{label}}</label>
    <div class="form-image">
        <draggable v-model="values" class="_list">
            <div v-for="v in values" v-if="v && fileFieldParams.data[v]" @click="openImage(v)" :key="v">
                <img :src="fileFieldParams.data[v].url" />
            </div>
        </draggable>
        <div v-if="!value || fileFieldParams.multiple" class="_add">
            <input type="file" :name="name" accept="image/*" />
            <i class="ion-android-upload"></i>
        </div>

        <vue-field-image-modal-edit ref="edit"
                                    :name="name"
                                    :fileFieldParams="fileFieldParams"
                                    @updateImage="updateImage"
                                    @deleteImage="deleteImage"
        ></vue-field-image-modal-edit>        
    </div>
</div>    
    `,
    props: {
        label: String,
        name: {type: String, required: true},
        value: [String, Number, Array],
        fieldParams: {
            type: [Object, Array],
            default: function(){
                return {
                    multiple: false,
                }
            }
        }
    },
    data: function(){
        return {
            fileFieldParams: {}
        }
    },
    computed: {
        values: {
            get: function(){
                return (this.value instanceof Array) ? this.value : [this.value];
            },
            set: function(values){
                this.$emit('input', this.fileFieldParams.multiple ? values : values[0]);
            }
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
        openImage: function(id){
            this.$refs['edit'].open(id);
        },
        deleteImage: function(id){
            if (this.fileFieldParams.multiple) {
                let values = this.values;
                values = _.filter(values, function(value){
                    return value != id;
                });
                this.$emit('input', values);
            } else {
                this.$emit('input', '');
            }
            bus.$emit('deleteFileId', id);
        },
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
                            url: data.result.url
                        };
                        if (self.fileFieldParams.multiple) {
                            let values = self.values;
                            values.push(data.result.id);
                            self.$emit('input', values);
                        } else {
                            self.$emit('input', data.result.id);
                        }
                    }
                    else {
                        $(Request).trigger('error');
                        Notify.error(data.result.error || 'Ошибка загрузки изображения');
                    }
                },
                fail: function () {
                    $(Request).trigger('error');
                    Notify.error('Ошибка загрузки изображения');
                }
            });
        },
        destroyUploader: function(){
            $(this.$el).find('input[type=file]').fileupload('destroy');
        }
    }
});
