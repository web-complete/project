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
        <div v-show="!value || fileFieldParams.multiple" class="_add">
            <input type="file" :name="name" accept="image/*" />
            <i class="ion-android-upload"></i>
        </div>

        <vue-field-image-modal-crop ref="crop"
                                    :name="name"
                                    @save="uploadDataUrl"
        ></vue-field-image-modal-crop>        
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
        if (this.fileFieldParams.data instanceof Array) {
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
        updateImage: function(id, title, alt){
            _.extend(this.fileFieldParams.data[id], {
                title: title,
                alt: alt
            });
            Request.post('/admin/api/update-image', {
                id: id,
                title: title,
                alt: alt
            });
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
        uploadDataUrl: function(filename, dataUrl){
            Request.post('/admin/api/upload-image', {
                filename: filename,
                content: dataUrl
            }, function(response){
                this.onUploaded(response);
            }.bind(this));
        },
        initUploader: function(){
            let self = this;
            $(this.$el).find('input[type=file]').fileupload({
                dataType: 'json',
                url: '/admin/api/upload-file',
                add: function (e, data) {
                    if (self.fileFieldParams['cropRatio']) {
                        let file = data.files[0];
                        let reader = new FileReader();
                        reader.onload = function(e){
                            self.$refs['crop'].open(
                                file.name,
                                e.target.result,
                                self.fileFieldParams['cropRatio'],
                                self.fileFieldParams['cropMimeType']
                            );
                        };
                        reader.readAsDataURL(file);
                    } else {
                        $(Request).trigger('start');
                        data.formData = {};
                        data.submit();
                    }
                },
                done: function (e, data) {
                    if(data.result.result) {
                        $(Request).trigger('stop');
                        self.onUploaded(data.result);
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
        onUploaded: function(response){
            this.fileFieldParams.data[response.id] = {
                name: response.name,
                url: response.url
            };
            if (this.fileFieldParams.multiple) {
                let values = this.values;
                values.push(response.id);
                this.$emit('input', values);
            } else {
                this.$emit('input', response.id);
            }
        },
        destroyUploader: function(){
            $(this.$el).find('input[type=file]').fileupload('destroy');
        }
    }
});
