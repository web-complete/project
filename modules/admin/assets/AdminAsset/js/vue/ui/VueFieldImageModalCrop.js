Vue.component('VueFieldImageModalCrop', {
    template: `
        <modal :name="'image-modal-crop-'+name"
               :scrollable="true"
               @opened="opened"
               @before-close="destroy"
               width="800px"
               height="auto"
        >
            <div v-show="dataUrl" class="popup-content _image">
                <h1>Параметры изображения</h1>
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
            filename: '',
            dataUrl: '',
            cropRatio: null,
            mimeType: 'image/jpeg',
        }
    },
    destroyed: function(){
        this.destroy();
    },
    methods: {
        open: function(filename, dataUrl, cropRatio, mimeType){
            this.$modal.show('image-modal-crop-'+this.name);
            this.filename = filename;
            this.dataUrl = dataUrl;
            this.cropRatio = cropRatio;
            this.mimeType = mimeType;
        },
        opened: function(){
            $(this.$el).find('img._data').cropper({
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
            let canvas = $(this.$el).find('img._data').cropper('getCroppedCanvas');
            if (canvas) {
                let dataUrl = canvas.toDataURL(this.mimeType);
                this.$emit('save', this.filename, dataUrl);
            }
            this.close();
        },
        destroy: function(){
            $(this.$el).find('img').cropper('destroy');
        }
    }
});
