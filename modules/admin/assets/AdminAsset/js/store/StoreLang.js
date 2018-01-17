window.store = window.store || new Vuex.Store();
window.store.registerModule('lang', {
    state: {},
    getters: {
        mainLang: function(state){
            let mainLang = state.langs[0];
            _.each(state.langs, function(lang){
                if (lang['is_main']) {
                    mainLang = lang;
                }
            });
            return mainLang;
        }
    },
    mutations: {
        updateLangState: function(state, payload){
            state.langs = payload.langs;
        }
    }
});
