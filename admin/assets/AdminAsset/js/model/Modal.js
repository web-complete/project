Modal = {

    confirm: function(message, successCallback, cancelCallback){
        successCallback = successCallback || function(){};
        cancelCallback = cancelCallback || function(){};

        this.dialog('', message, [
            {
                title: 'Ok',
                default: true,
                handler: function(){
                    bus.$modal.hide('dialog');
                    successCallback();
                }
            },
            {
                title: 'Отмена',
                handler: function(){
                    bus.$modal.hide('dialog');
                    cancelCallback();
                }
            }
        ]);
    },

    dialog: function(title, content, buttons){
        bus.$modal.show('dialog', {
            title: title,
            text: content,
            buttons: buttons
        });
    }
};
