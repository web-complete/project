Translations = {

    data: {},

    get: function(text, namespace){
        namespace = namespace || '_';
        if (this.data[namespace]) {
            if (this.data[namespace][text] !== undefined) {
                return this.data[namespace][text];
            }
        }

        $.post('/admin/api/translation/create', {
            namespace: namespace,
            text: text
        });

        this.data[namespace][text] = '%' + text + '%';
        return '%' + text + '%';
    }
};