Request = {

    headers: {
    },

    get: function(url, payload, success, fail){
        return $.get(url, payload, success || function(){}, 'json').fail(fail || function(){});
    },

    post: function(url, payload, success, fail){
        return $.post(url, payload, success || function(){}, 'json').fail(fail || function(){});
    }
};
