if (typeof RedactorPlugins === 'undefined') var RedactorPlugins = {};
RedactorPlugins.resizedImage = function(){
    return {
        getTemplate: function(){
            return String()
                + '<section id="redactor-modal-link-insert">'
//        + '<label>Ссылка</label>'
//        + '<input type="text" class="redactor_input" id="redactor_resized_image_url" />'
//        + '<label>Или загрузить</label>'
                + '<input type="file" class="redactor_input" id="redactor_resized_image" />'
                + '</section>';
        },

        init: function(){
            var button = this.button.add('image', 'Изображение');
            this.button.addCallback(button, this.resizedImage.show);
        },

        show: function(){
            this.modal.addTemplate('image', this.resizedImage.getTemplate());

            this.modal.load('image', 'Изображение', 700);
            this.modal.createCancelButton();

            var button = this.modal.createActionButton(this.lang.get('insert'));
            button.on('click', this.resizedImage.insert);

            this.selection.save();
            this.modal.show();

            // $('#redactor-insert-video-area').focus();
        },

        initResizedImageModal: function(){
            var self = this;
            this.modalInit('Картинка', this.template_modal_resized, 460, function(){
                $('#redactor_resized_image').change(function(){
                    self.resizeFromFile('#redactor_resized_image', function(data){
                        self.modalClose();
                        self.insertResizedImage(data.imagelink);
                    });
                });
                $('#redactor_insert_resized_btn').click(function(){
                    var url = $('#redactor_resized_image_url').val();
                    if(url) {
                        self.resizeFromUrl(url, function(data){
                            self.modalClose();
                            self.insertResizedImage(data.imagelink);
                        });
                    }
                });
            });
        },

        resizeFromFile: function(selector, callback){
            $(selector).resizeFileAndUpload('/api/post/imageUpload', 700, 700, null, {}, callback);
        },

        resizeFromUrl: function(url, callback){
            $.ajax({
                url: '/api/post/imageUpload',
                dataType: 'json',
                type: 'POST',
                data:  { url: url },
                success: callback
            });
        },

        insertResizedImage: function(url){
            if(url) {
                var data = '<img id="image-marker" src="' + url + '" />';
//            if (this.opts.linebreaks === false) data = '<p>' + data + '</p>';
                this.imageInsert(data, true);
            }
        }
    };
};
