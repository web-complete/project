Request = {

    headers: {
    },
    messageError: 'Ошибка сервера',
    messageForbidden: 'Доступ запрещен',

    get: function(url, payload, success, fail){
        success = success || function(){};
        $(Request).trigger('start');
        return $.get(url, payload, 'json')
            .done(function(response){
                $(Request).trigger('stop');
                success(response);
            })
            .fail(function(jqXHR, status, error){
                $(Request).trigger('error');
                this.failCallback(fail, jqXHR, status, error);
            }.bind(this));
    },

    post: function(url, payload, success, fail){
        success = success || function(){};
        $(Request).trigger('start');
        return $.post(url, payload, 'json')
            .done(function(response){
                $(Request).trigger('stop');
                success(response);
            })
            .fail(function(jqXHR, status, error){
                $(Request).trigger('error');
                this.failCallback(fail, jqXHR, status, error);
            }.bind(this));
    },

    delete: function(url, payload, success, fail){
        success = success || function(){};
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
            .fail(function(jqXHR, status, error){
                $(Request).trigger('error');
                this.failCallback(fail, jqXHR, status, error);
            }.bind(this));
    },

    failCallback: function(userCallback, jqXHR, status, error){
        if (error === 'Forbidden') {
            Notify.error(this.messageForbidden);
        } else if (!userCallback) {
            Notify.error(this.messageError);
        }
        if (userCallback) userCallback(jqXHR, status, error);
    }
};
