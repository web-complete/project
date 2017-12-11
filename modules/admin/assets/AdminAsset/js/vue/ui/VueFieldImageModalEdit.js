Vue.component('VueFieldImageModalEdit', {
    template: `
        <modal :name="'image-modal-edit-'+name" width="600px" height="auto" :scrollable="true">
            <div v-if="url" class="popup-content _image">
                <h1>Параметры изображения</h1>
                <div class="image-wrapper clearfix">
                    <img :src="url" style="width: 100%" />
                </div>
                <form @submit.prevent="saveImage" class="form-filter">
                    <div class="form-row">
                        <label>Заголовок</label>
                        <input v-model="title" type="text" name="title" title="" />
                    </div>
                    <div class="form-row">
                        <label>Альтернативное название</label>
                        <input v-model="alt" type="text" name="alt" title="" />
                    </div>
                </form>
                <div class="form-actions">
                    <button @click="saveImage" class="button" type="button">Сохранить</button>
                    <button @click="deleteImage" class="button gray" type="button">Удалить</button>
                    <button @click="close" class="button gray" type="button">Отменить</button>
                </div>
            </div>

        </modal>
    `,
    props: {
        name: {required: true},
        fileFieldParams: Object
    },
    data: function(){
        return {
            id: '',
            title: '',
            alt: ''
        }
    },
    computed: {
        url: function(){
            return this.id && this.fileFieldParams.data[this.id] ? this.fileFieldParams.data[this.id].url : '';
        }
    },
    created: function(){
        this.title = this.id && this.fileFieldParams.data[this.id] ? this.fileFieldParams.data[this.id].title : '';
        this.alt = this.id && this.fileFieldParams.data[this.id] ? this.fileFieldParams.data[this.id].alt : '';
    },
    methods: {
        open: function(id){
            this.id = id;
            this.$modal.show('image-modal-edit-'+this.name);
        },
        close: function(){
            this.$modal.hide('image-modal-edit-'+this.name);
        },
        saveImage: function(){
            Request.post('/admin/api/updateImage', {
                id: this.id,
                title: this.title,
                alt: this.alt
            }, function(){
                this.close();
            }.bind(this));
        },
        deleteImage: function(){
            this.close();
            this.$emit('deleteImage', this.id);
        }
    }
});
