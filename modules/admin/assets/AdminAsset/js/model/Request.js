Request = {

    headers: {
    },
    messageError: 'Ошибка сервера',
    messageForbidden: 'Доступ запрещен',

    get: function(url, payload, success, fail){
        this.do('GET', url, payload, success, fail);
    },

    post: function(url, payload, success, fail){
        this.do('POST', url, payload, success, fail);
    },

    delete: function(url, payload, success, fail){
        this.do('DELETE', url, payload, success, fail);
    },

    do: function(method, url, payload, success, fail){
        success = success || function(){};
        $(Request).trigger('start');
        this.csrf();
        $.ajax({
            url: url,
            type: method,
            data: this._processPayload(payload),
            dataType: 'json'
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

    csrf: function(){
        Cookies.set('_csrf_check', Cookies.get('_csrf'));
    },

    failCallback: function(userCallback, jqXHR, status, error){
        if (error === 'Forbidden') {
            Notify.error(this.messageForbidden);
        } else if (!userCallback) {
            Notify.error(this.messageError);
        }
        if (userCallback) userCallback(jqXHR, status, error);
    },

    _processPayload: function(payload){
        return _.cloneDeepWith(payload, function(value){
            if (_.isArray(value) && !value.length) {
                return null;
            }
        });
    }
};
