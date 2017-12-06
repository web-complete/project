window.store = window.store || new Vuex.Store();
window.store.registerModule('user', {
    state: {
        loginError: false,
        token: '',
        fullName: ''
    },
    mutations: {
        updateState: function(state, payload){
            if (payload instanceof Object) {
                _.extend(state, payload);
            }
        }
    },
    actions: {
        login: function(context, payload){
            context.commit('updateState', {loginError: false});
            Request.post('/admin/auth', payload, function(response){
                context.commit('updateState', {token: response.token});
                if (payload.redirect) {
                    App.redirect('/admin');
                }
            }, function(){
                context.commit('updateState', {loginError: true});
            });
        },

        logout: function(){
            App.redirect('/admin/login');
        }
    }
});
