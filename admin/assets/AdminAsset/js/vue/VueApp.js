VueApp = {
    store: store,
    el: '#app',
    mounted: function(){
        this.handleAjaxLoading();
    },
    methods: {
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
