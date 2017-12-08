VueApp = {
    store: store,
    el: '#app',
    mounted: function(){
        var self = this;
        $(Request).on('start', function(){
            self.$refs['topProgress'].start();
        });
        $(Request).on('stop', function(){
            self.$refs['topProgress'].done();
        });
        $(Request).on('error', function(){
            self.$refs['topProgress'].fail();
        });
    }
};
