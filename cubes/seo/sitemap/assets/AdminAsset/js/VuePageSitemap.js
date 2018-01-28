VuePageSitemap = {
    template: `
<div class="page block">
    <div class="page-detail">
        <div class="page-top">
            <h1>Sitemap</h1>
            <button @click="generate" class="button">Сгенерировать</button>
            <button @click="triggerFileSelect" class="button">Загрузить</button>
        </div>
        
        <input id="upload" type="file" name="file" accept="text/xml" class="hide" />
        <div v-if="isLoaded && size" class="form-detail">
            <div class="form-row">
                <label>Файл</label>
                <a href="/sitemap.xml" target="_blank">sitemap.xml</a>
            </div>
            <div class="form-row">
                <label>Размер</label>
                {{size}} bytes
            </div>
            <div class="form-row">
                <label>Время</label>
                {{time}}
            </div>
        </div>
    </div>
</div>
`,
    data(){
        return {
            isLoaded: false,
            size: 0,
            time: 0
        }
    },
    created(){
        this.fetchData()
    },
    mounted: function(){
        this.initUploader();
    },
    destroyed: function(){
        this.destroyUploader();
    },
    watch: {'$route': 'fetchData'},
    methods: {
        fetchData(){
            Request.get('/admin/api/sitemap/get', function(response){
                this.updateDataFromResponse(response);
            }.bind(this));
        },
        generate(){
            Request.post('/admin/api/sitemap/generate', function(response){
                if (response.result) {
                    Notify.success('Новый sitemap сгенерирован');
                    this.updateDataFromResponse(response);
                } else {
                    Notify.error(response.error || 'Ошибка генерации sitemap');
                }
            }.bind(this));
        },
        triggerFileSelect(){
            $(this.$el).find('input[type=file]').click();
        },
        initUploader(){
            $(this.$el).find('input[type=file]').fileupload({
                dataType: 'json',
                url: '/admin/api/sitemap/upload',
                add: function (e, data) {
                    $(Request).trigger('start');
                    data.formData = {};
                    data.submit();
                },
                done: function (e, data) {
                    if(data.result.result) {
                        $(Request).trigger('stop');
                        Notify.success('Файл загружен');
                        this.updateDataFromResponse(data.result);
                    }
                    else {
                        $(Request).trigger('error');
                        Notify.error(data.result.error || 'Ошибка загрузки файла');
                    }
                }.bind(this),
                fail: function () {
                    $(Request).trigger('error');
                    Notify.error('Ошибка загрузки файла');
                }
            });
        },
        destroyUploader(){
            $(this.$el).find('input[type=file]').fileupload('destroy');
        },
        updateDataFromResponse(response){
            this.isLoaded = true;
            this.size = response.size || 0;
            this.time = response.time || 0;
        }
    }
};