Request = {

    headers: {
    },
    messageError: 'Ошибка сервера',

    get: function(url, payload, success, fail){
        success = success || function(){};
        fail = fail || function(){
            Notify.error(this.messageError);
        }.bind(this);

        $(Request).trigger('start');
        return $.get(url, payload, 'json')
            .done(function(response){
                $(Request).trigger('stop');
                success(response);
            })
            .fail(function(){
                $(Request).trigger('error');
                fail();
            });
    },

    post: function(url, payload, success, fail){
        success = success || function(){};
        fail = fail || function(){
            Notify.error(this.messageError);
        }.bind(this);

        $(Request).trigger('start');
        return $.post(url, payload, 'json')
            .done(function(response){
                $(Request).trigger('stop');
                success(response);
            })
            .fail(function(){
                $(Request).trigger('error');
                fail();
            });
    },

    delete: function(url, payload, success, fail){
        success = success || function(){};
        fail = fail || function(){
            Notify.error(this.messageError);
        }.bind(this);

        $(Request).trigger('start');
        $.ajax({
            url: url,
            data: payload,
            dataType: 'json',
            type: 'DELETE',
        })
            .done(function(response){
                $(Request).trigger('stop');
                success(response);
            })
            .fail(function(){
                $(Request).trigger('error');
                fail();
            });
    }
};
