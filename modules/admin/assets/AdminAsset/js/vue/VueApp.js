VueApp = {
    store: store,
    el: '#app',
    mounted: function(){
        this.initAutoPing();
        this.handleAjaxLoading();
    },
    methods: {
        initAutoPing: function(){
            // prevent session timeout
            setInterval(function(){
                $.get('/admin/api/ping');
            }, 300000);
        },
        handleAjaxLoading: function(){
            var self = this;
            if (self.$refs['topProgress']) {
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
        }
    }
};
