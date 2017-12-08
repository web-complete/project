Request = {

    headers: {
    },

    get: function(url, payload, success, fail){
        success = success || function(){};
        fail = fail || function(){};

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
        fail = fail || function(){};

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
    }
};
