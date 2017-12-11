Vue.component('VueFieldImageModalCrop', {
    template: `
        <modal :name="'image-modal-crop-'+name" width="800px" height="auto" :scrollable="true" @opened="opened">
            <div v-show="dataUrl" class="popup-content _image">
                <h1>Параметры изображения</h1>
                <div class="image-wrapper clearfix">
                    <img class="_data" :src="dataUrl" style="width: 100%" />
                </div>
                <div class="form-actions">
                    <button @click="uploadImage" class="button" type="button">Сохранить</button>
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
            cropRatio: null
        }
    },
    destroyed: function(){
        this.destroy();
    },
    methods: {
        open: function(dataUrl, cropRatio){
            this.$modal.show('image-modal-crop-'+this.name);
            this.dataUrl = dataUrl;
            this.cropRatio = cropRatio;
        },
        opened: function(){
            $(this.$el).find('img._data').cropper({
                viewMode: 3,
                autoCropArea: 1,
                aspectRatio: this.cropRatio
            });
        },
        close: function(){
            this.destroy();
            this.$modal.hide('image-modal-crop-'+this.name);
        },
        uploadImage: function(){
            let canvas = $(this.$el).find('img._data').cropper('getCroppedCanvas');
            console.log(canvas);
            // let dataUrl = canvas.toDataURL('image/png');
            // console.log(dataUrl);
            // $(this.$el).find('img').cropper('getCroppedCanvas').toBlob(function(dataUrl){
            //     this.$emit('uploadImage', dataUrl);
            // }.bind(this));
        },
        destroy: function(){
            $(this.$el).find('img').cropper('destroy');
        }
    }
});
