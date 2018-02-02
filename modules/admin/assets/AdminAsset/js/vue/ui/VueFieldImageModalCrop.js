Vue.component('VueFieldImageModalCrop', {
    template: `
        <modal :name="'image-modal-crop-'+name"
               :scrollable="true"
               @opened="opened"
               @before-close="destroy"
               width="800px"
               height="auto"
        >
            <h1>Параметры изображения</h1>
            <div v-show="dataUrl" class="popup-content _image">
                <div class="image-wrapper clearfix">
                    <img class="_data" :src="dataUrl" style="width: 100%" />
                </div>
                <div class="form-actions">
                    <button @click="save" class="button" type="button">Сохранить</button>
                    <button @click="close" class="button gray" type="button">Отменить</button>
                </div>
            </div>
        </modal>
    `,
    props: {
        name: {required: true}
    },
    data: function(){
        return {
            dataUrl: '',
            cropRatio: null,
            mimeType: 'image/jpeg',
        }
    },
    destroyed: function(){
        this.destroy();
    },
    methods: {
        open: function(dataUrl, cropRatio, mimeType){
            this.$modal.show('image-modal-crop-'+this.name);
            this.dataUrl = dataUrl;
            this.cropRatio = cropRatio;
            this.mimeType = mimeType;
        },
        opened: function(){
            this.cropper = new $.fn.cropper.Constructor($(this.$el).find('img._data')[0], {
                viewMode: 3,
                autoCropArea: 1,
                aspectRatio: this.cropRatio,
                zoomable: false
            });
        },
        close: function(){
            this.destroy();
            this.$modal.hide('image-modal-crop-'+this.name);
        },
        save: function(){
            let cropData = this.cropper.getData();
            this.$emit('crop', cropData);
            this.close();
        },
        destroy: function(){
            if (this.cropper) {
                this.cropper.destroy();
            }
        }
    }
});
