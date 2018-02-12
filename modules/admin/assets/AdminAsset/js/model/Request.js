Request = {

    headers: {
    },
    messageError: 'Ошибка сервера',
    messageForbidden: 'Доступ запрещен',

    get: function(url, payload, success, fail){
        success = success || function(){};
        $(Request).trigger('start');
        return $.get(url, this._processPayload(payload), 'json')
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
        return $.post(url, this._processPayload(payload), 'json')
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
            data: this._processPayload(payload),
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
    },

    _processPayload: function(payload){
        return _.cloneDeepWith(payload, function(value){
            if (_.isArray(value) && !value.length) {
                return null;
            }
        });
    }
};
