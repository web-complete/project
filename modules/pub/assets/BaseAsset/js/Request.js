Request = {

    headers: {
    },

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
        Cookies.set('_csrf_check', Cookies.get('_csrf'));
        $.ajax({
            url: url,
            type: method,
            data: payload,
            headers: this.headers,
            dataType: 'json'
        })
            .done(function(response){
                success(response);
            })
            .fail(function(jqXHR, status, error){
                if (fail) fail(jqXHR, status, error);
            }.bind(this));
    }
};